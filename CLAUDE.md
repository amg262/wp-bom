# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## What this is

A WordPress plugin (WP BOM) implementing a bill of materials: parts, assemblies,
multi-level explosion with cost and weight roll-up. PHP 8.0+, WordPress 6.0+.

There is **no build step and no runtime dependency**. No npm, no webpack, no ACF,
no framework. Edit a PHP file and reload. Do not reintroduce a build pipeline or
a field-framework dependency — v1.x died of exactly that and the whole v2 rewrite
was to remove it.

## Commands

```bash
php tests/run.php                 # full test suite
composer test                     # same thing
php -d error_reporting=E_ALL tests/run.php   # catch deprecations/warnings too
php -l includes/Explosion.php     # syntax check one file
composer lint                     # php -l over every file
node --check assets/js/wpbom-admin.js
```

The test runner is a standalone script, not PHPUnit — no composer install needed
to run it. It has **no filter flag**: there is no way to run one test or one
group from the CLI. To iterate on a single area, either comment out the other
`group()` blocks in `tests/run.php` or pipe through grep:

```bash
php tests/run.php | grep -A20 'Circular references'
```

Always run the suite under `E_ALL` before committing. PHP 8.4 is what's
installed here, and it surfaces deprecations (see `fputcsv` below) that the
default error level hides.

## Architecture

### The one idea that matters

A line item points at a part **or at another assembly**. That single rule is what
makes the structure recursive and is the entire reason the plugin exists. Every
feature — explosion, roll-up, flat lists, where-used — falls out of it.

v1.x tried to service this by hand-unrolling three levels of nested loops, three
separate times, in `Component.php` and `PostObject.php`. If you find yourself
writing a second loop over children, you are re-creating that bug. Use
`Explosion::walk()` or recursion.

### Line-item storage is dual-write

`Meta::ITEMS` (`_wpbom_items`) holds the authoritative array of rows. `Meta::CHILD_ID`
(`_wpbom_child_id`) is a **denormalised index** — one meta row per distinct child —
so `Meta::where_used()` is an indexed meta query instead of a table scan.

These two must never drift. **Always write line items through `Meta::set_items()`**,
which rebuilds the index, filters invalid rows, drops self-references, and coerces
zero quantities to 1. Never call `update_post_meta( $id, Meta::ITEMS, … )` directly
outside of a test that is deliberately simulating corrupt data.

### Explosion is read-only

`Explosion::tree()` and everything it calls must not write. v1.x called
`update_field()` from inside its render path, so viewing a page mutated the
database. If a computed value needs persisting, do it in a save hook, not here.

`Explosion::flush_cache()` clears the per-request post memo; call it after writing
meta within the same request (`MetaBoxes::save()` already does).

### Cost semantics

- A **part**'s `unit_cost` is its meta value.
- An **assembly**'s `unit_cost` is its labor cost **plus** `Σ( line qty × child unit_cost )`, recursively.
- `ext_cost` is always `unit_cost × qty_total`.

So changing one part's price reprices every product containing it, at every level.
`tests/run.php` pins this arithmetic; if you change the formula, those assertions
should fail loudly — do not "fix" them without deciding the semantics changed.

### Cycle and depth are different mechanisms

Circular references are caught by an explicit ancestor `$path` array passed down
the recursion, independent of depth. `Settings::max_depth()` (default 12) bounds
rendering cost only; `Explosion::MAX_DEPTH_LIMIT` (25) is the hard ceiling that
clamps it. **Never rely on the depth limit to stop recursion** — that was the v1
failure mode.

A cycle produces a stub node with `cycle => true`, zero cost, no children.
Missing posts produce `missing => true`. Both surface as warnings via
`Render::warnings()`.

### The node shape is a contract

`Explosion::tree()` returns a nested array whose keys (`id`, `qty_per`, `qty_total`,
`unit_cost`, `ext_cost`, `unit_weight`, `ext_weight`, `cycle`, `missing`,
`truncated`, `children`, …) are consumed by `Render`, `Export`, `Rest` and
`Shortcode`. Adding a key is safe; renaming or removing one breaks four callers
and the REST response shape. `Explosion::placeholder_node()` must keep emitting
every key the full node emits, or downstream `foreach` loops hit undefined indexes.

### Registration flow

Nothing registers hooks in a constructor. Every subsystem exposes `register()`,
and `Plugin::boot()` (on `plugins_loaded`) instantiates and calls them in a fixed
order. To add a subsystem: create the class, give it `register()`, add it to the
`$services` array in `Plugin::boot()`.

The autoloader maps `WPBom\Foo\Bar` → `includes/Foo/Bar.php` and refuses to escape
`includes/`.

`Install::activate()` must register post types itself before `flush_rewrite_rules()`,
since activation runs before `init`. Activation-hook callbacks are **static** —
v1.x registered instance methods here and fatalled on every activation attempt.

### Meta box field naming

There is one save handler, `MetaBoxes::save()`, guarded by a single nonce
(`wpbom_save_meta` / `wpbom_nonce`) that several boxes each render.

The POST key for a scalar field is **the meta key with its leading underscore
stripped**: `_wpbom_unit_cost` ⇄ `$_POST['wpbom_unit_cost']`. `save_scalar()`
derives this with `ltrim( $key, '_' )`, so adding a field means adding the
constant to `Meta`, rendering it with the matching name, and adding one
`save_scalar()` call with the right type (`text`, `html`, `float`, `int`,
`choice`).

`choice` fields validate against an allow-list and fall back to the first allowed
value — never persist an unvalidated select value.

An **absent** `wpbom_items` key means the box wasn't rendered (quick edit, REST),
which is different from an explicitly empty array meaning "delete all lines". Keep
that distinction.

### Editor

BOM post types force the **classic editor** via `use_block_editor_for_post_type`.
The line-item UI is a meta box and would be hidden or broken under the block
editor. If block editor support is ever wanted, that's a rewrite of the line-item
UI as a block/plugin sidebar, not a flag flip.

## Testing

`tests/bootstrap.php` stubs WordPress with an in-memory post/meta/options store.
It implements **only the functions the plugin actually calls**. If you use a new
WP function in `includes/`, the suite will fatal with "undefined function" until
you add a stub — that's the intended signal, not a bug.

`get_posts()` in the stub supports only `post_type`, `exclude`, `fields`, and a
simple `meta_query`. Extend it if you need more; don't work around it.

`WPBom_Test_Store::reset()` wipes state between groups and flushes the explosion
memo. Call it at the top of each `group()` that inserts fixtures.

## Conventions

- WordPress coding standards: tabs, spaces inside parens, `[]` array syntax,
  Yoda-free comparisons are fine but strict `===` throughout.
- `declare( strict_types=1 )` in every file. Core calls into callbacks from
  non-strict files, so incoming coercion is permissive; internal calls are not.
- Text domain is `wp-bom` everywhere.
- Escape at output, always. `Render::*` returns escaped strings; callers that
  `echo` them carry a `phpcs:ignore` explaining why.
- PHP 8.4 deprecates `fputcsv()` without an explicit `$escape`. All CSV writing
  goes through `Export::put()`, which passes `','`, `'"'`, `''`. Don't call
  `fputcsv()` directly.

## History worth knowing

v1.x was unactivatable on any supported PHP version and had never registered a
post type. The four blockers were: static calls to instance methods in activation
hooks; an unconditional `require` of a vendored commercial import plugin; post
type registration gated on an option key absent on fresh installs; and an ACF Pro
dependency shipped as a bundled 2016 copy. The `readme.txt` changelog documents
the full list. Don't restore any of it.
