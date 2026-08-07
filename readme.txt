=== WP BOM ===
Contributors: amg262
Tags: bill of materials, bom, manufacturing, inventory, parts, assemblies, mrp
Requires at least: 6.0
Tested up to: 6.8
Requires PHP: 8.0
Stable tag: 2.0.0
License: GPL-3.0-or-later
License URI: https://www.gnu.org/licenses/gpl-3.0.txt

Bill of Materials for WordPress. Track parts and assemblies, nest assemblies to any depth, and explode a multi-level BOM with cost and weight roll-up.

== Description ==

WP BOM turns WordPress into a lightweight bill-of-materials system.

You define **Parts** (things you buy) and **Assemblies** (things you build). An
assembly holds a list of line items, and each line item can point at a part *or*
at another assembly. That is the whole model, and it is enough to describe an
arbitrarily deep product structure.

From that structure the plugin derives:

* **An indented explosion** — every level of the tree, with quantity per parent
  and extended quantity for the whole build.
* **A flat part list** — the same tree summed per distinct part, which is what a
  purchasing or picking list actually needs. A bolt used in three different
  sub-assemblies appears once, with the total.
* **Rolled-up cost and weight** — a sub-assembly's cost is computed from its own
  contents plus its labor cost, recursively, so changing one part's price
  updates every product that contains it.
* **Where used** — every assembly that consumes a given part, in reverse.

= No ACF, no build step =

Version 2.0.0 is a rewrite. Custom fields are native WordPress meta boxes and
native post meta. There is no Advanced Custom Fields dependency, no bundled
copy of any commercial plugin, no webpack, no gulp, no npm install. Drop the
folder in `wp-content/plugins`, activate, and it works.

= Circular references are handled =

If assembly A contains assembly B and B contains A, the explosion stops at the
point where the loop closes, marks it in the tree, excludes it from the totals,
and shows a warning. It does not hang and it does not exhaust memory.

= Shortcode =

Render any assembly or saved BOM on the front end:

`[wp_bom id="123"]`                          Indented tree.
`[wp_bom id="123" view="flat" qty="10"]`     Summed part list for a build of ten.
`[wp_bom id="123" view="both" totals="no"]`  Both tables, no totals strip.

Omit `id` inside a part, assembly or BOM to use the current post.

= REST API =

Two read-only routes, both permission-checked:

* `GET /wp-json/wp-bom/v1/items?search=bolt&type=part` — search the catalogue.
* `GET /wp-json/wp-bom/v1/bom/123?qty=5` — tree, flat list and totals as JSON.

== Installation ==

1. Upload the `wp-bom` folder to `/wp-content/plugins/`.
2. Activate the plugin through the Plugins screen.
3. Add some Parts, then create an Assembly and add line items to it.
4. Configure currency and explosion depth under Parts → Settings.

== Frequently Asked Questions ==

= Do I need Advanced Custom Fields? =

No. Version 1.x required ACF Pro and shipped a copy of it. Version 2.0.0 removed
that dependency entirely in favour of native meta boxes. If you have ACF
installed for other reasons it will not conflict.

= What happens to my 1.x data? =

The `part` and `assembly` post types keep the same slugs, so your posts and
their titles, taxonomies and media survive. The custom field storage format
changed, so line items and costs entered through the old ACF fields need to be
re-entered. The 1.x code path never registered its post types successfully on
PHP 7.4+, so in practice most installs have no data to migrate.

= How deep can assemblies nest? =

Twelve levels by default, adjustable up to twenty-five under Parts → Settings.
The limit exists to bound rendering cost, not to prevent recursion — circular
references are detected independently of it.

= Can I export? =

Yes. Every exploded view has an Export CSV button that produces the flat part
list with quantities, costs and reference designators, UTF-8 with a byte order
mark so Excel reads it correctly.

== Changelog ==

= 2.0.0 =

Complete rewrite. The 1.x plugin could not be activated on any supported PHP
version; this release makes it work.

* Removed the Advanced Custom Fields dependency and the bundled copy of ACF Pro.
* Removed the vendored copies of WP All Import Pro and its ACF add-on, which
  were required unconditionally on every page load.
* Fixed activation: the activation hooks called instance methods statically,
  which is fatal on PHP 8.
* Fixed post type registration: registration was gated on an option key that
  does not exist on a fresh install, so no post type was ever registered.
* Replaced all ACF fields with native meta boxes, including a drag-reorderable
  repeatable line-item editor that needs no JavaScript to save correctly.
* Rewrote the explosion as a single recursive walk with cycle detection,
  replacing three hand-unrolled copies of the same loop that could recurse
  without bound.
* Explosion is now read-only. The old code wrote post meta during rendering.
* Added cost and weight roll-up, flat part lists, where-used lookups, admin list
  columns, a settings screen, CSV export, REST endpoints and a real shortcode.
* Added a dependency-free test suite: `php tests/run.php`.
* Removed the React/webpack/gulp scaffolding; there is no build step.

= 1.0.0 =
* Initial, non-functional release.

== Upgrade Notice ==

= 2.0.0 =
Complete rewrite. Removes the ACF dependency. Line items and costs from 1.x must
be re-entered; post types, titles and taxonomies are preserved.
