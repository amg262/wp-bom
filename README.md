# WP BOM

Bill of Materials for WordPress. Track parts and assemblies, nest assemblies to
any depth, and explode a multi-level BOM with quantity, cost and weight roll-up.

No Advanced Custom Fields. No page builder. No build step. Drop it in
`wp-content/plugins`, activate, and it works.

**Requires:** WordPress 6.0+, PHP 8.0+

---

## The model

Two content types carry everything:

| Type | Means | Holds |
|------|-------|-------|
| **Part** | Something you buy | Part number, revision, UOM, unit cost, weight, stock on hand, reorder point, lead time, manufacturer part number, status |
| **Assembly** | Something you build | The same header fields, plus a labor/overhead cost and a list of **line items** |

A line item points at a part **or at another assembly**, with a quantity, a
reference designator and a note. That single rule is what makes the structure
recursive: an assembly containing an assembly containing a part is just three
rows of data, and the plugin walks it.

A third type, **BOM**, is a saved document: it points at one assembly and a build
quantity, so you can keep "500 × Chassis, as quoted in March" as a permanent,
shareable record.

## What you get from the structure

**Indented explosion.** Every level of the tree with quantity-per-parent and
extended quantity for the whole build.

**Flat part list.** The same tree summed per distinct part. A bolt used in three
different sub-assemblies appears once with the total — this is the list you hand
to purchasing.

**Cost and weight roll-up.** An assembly's unit cost is its labor cost plus the
extended cost of everything inside it, computed recursively. Change one part's
price and every product containing it reprices.

**Where used.** The reverse lookup: every assembly that consumes a given part,
backed by an indexed meta query rather than a table scan.

**CSV export.** The flat list with quantities, costs and reference designators.
UTF-8 with a byte order mark, so Excel opens it correctly.

## Circular references

If assembly A contains B and B contains A, the walk stops where the loop closes,
marks that row in the tree, excludes it from the totals, and shows a warning. It
does not hang and it does not exhaust memory.

Self-references are rejected at save time, before they can be stored.

## Shortcode

```
[wp_bom id="123"]                           Indented tree
[wp_bom id="123" view="flat" qty="10"]      Summed part list for a build of ten
[wp_bom id="123" view="both" totals="no"]   Both tables, no totals strip
[wp_bom id="123" depth="3"]                 Stop after three levels
```

Omit `id` inside a part, assembly or BOM to use the current post. Pass a **BOM**
post ID and it resolves to that document's assembly and stored build quantity.

## REST API

Both routes are read-only and permission-checked.

```
GET /wp-json/wp-bom/v1/items?search=bolt&type=part
GET /wp-json/wp-bom/v1/bom/123?qty=5
```

`/items` requires `edit_posts`. `/bom/<id>` requires read access to the post, or
public visibility if the public-shortcode setting is on.

## Settings

Under **Parts → Settings**: currency symbol, cost decimal places, maximum
explosion depth (1–25, default 12), and whether logged-out visitors can see
shortcode output.

## Layout

```
wp-bom.php              Bootstrap: constants, autoloader, activation hooks
includes/
  Plugin.php            Boots every subsystem on plugins_loaded
  PostTypes.php         Post types and taxonomies
  Meta.php              Meta schema, sanitising, line-item read/write, where-used
  MetaBoxes.php         All editing UI and the single save handler
  Explosion.php         Recursive walk, cycle detection, cost and weight roll-up
  Render.php            Tree and flat tables, shared by admin, shortcode and CSV
  AdminColumns.php      List-table columns
  Settings.php          Options page on the core Settings API
  Rest.php              REST routes
  Shortcode.php         [wp_bom]
  Export.php            CSV download
  Assets.php            CSS and JS loading
  Install.php           Activation, deactivation, upgrades
assets/
  css/wpbom-admin.css   Admin styles
  css/wpbom.css         Front-end styles
  js/wpbom-admin.js     Line-item repeater: add, remove, drag-reorder
tests/
  bootstrap.php         In-memory WordPress stubs
  run.php               Test suite
```

## Tests

The engine is testable without a WordPress install, composer or PHPUnit:

```
php tests/run.php
```

63 assertions covering roll-up arithmetic, nested multiplication, labor cost,
cycle detection, self-reference rejection, invalid-input filtering, missing
items, depth truncation, the where-used index, input sanitising, output
escaping, the meta box save path (including nonce rejection), and the shortcode.

## History

Version 1.x could not be activated on any supported PHP version. Its activation
hooks called instance methods statically, it required a vendored copy of a
commercial import plugin on every page load, and post type registration was
gated on an option key that does not exist on a fresh install — so no post type
was ever registered. Version 2.0.0 is a rewrite. See `readme.txt` for the full
changelog.

## License

GPL-3.0-or-later. See `LICENSE`.
