# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## What this is

A WordPress plugin ("WP-Bom" / "WooBOM") that adds Bill of Materials / MRP tracking on top of WordPress + WooCommerce. It started as a fork of the **WP Reactivate** React boilerplate (Pangolin), so much of `app/`, `includes/Shortcode.php`, `includes/Widget.php`, `includes/Endpoint/Example.php`, `app/utils/fetchWP.js` and the top half of `README.md` are still boilerplate scaffolding. The BOM domain code (`Post`, `PostObject`, `Component`, `Module`, `BOM`, `Data`, `Settings`) is the actual product and is work-in-progress: several overlapping implementations of the same recursion exist side by side, and large blocks are commented out (including most of `init()` in `wp-bom.php`).

Treat "this looks half-finished / duplicated" as expected, not as something to clean up unless asked.

## Commands

```bash
# JS deps — NOTE: `postinstall` runs `gulp run`, which starts browser-sync + a
# blocking file watcher. In CI or non-interactive work use:
yarn install --ignore-scripts        # or: npm install --ignore-scripts

yarn build     # webpack --watch  -> assets/js/{admin,shortcode,widget}.js
yarn prod      # NODE_ENV=production webpack -p (one-shot production bundle)
yarn watch     # gulp run: purge + imagemin + cssnano + uglify + zip + browser-sync + watch
yarn clean     # gulp clean: purge + imagemin + cssnano + uglify (no server)
yarn purge     # delete dist/js/* and dist/css/*
yarn zip       # gulp zip

npx eslint app --ext .js,.jsx        # ESLint is configured (.eslintrc) but has no npm script

composer install                     # PHP tooling (PHPCS/WPCS, PHPMD, PHPUnit, Codeception, Behat)
```

Things that do **not** work despite appearing in config — don't be misled by them:

- `yarn test` is the npm stub (`echo "Error: no test specified" && exit 1`).
- `yarn min` maps to `gulp min`, and there is no `min` task in `gulpfile.js`.
- `test/*.php` are IDE-generated stubs with **empty method bodies**, spread across four frameworks (PHPUnit `AdminTest`/`PartTest`/`PluginTest`, Codeception `AdminUnitTest`/`AdminCest`, PhpSpec `AdminSpec`). There is no `phpunit.xml`, `codeception.yml`, or `phpcs.xml`, so there is no runnable suite. If asked to "run the tests," say this rather than inventing a command.
- `browser-sync` proxies a hardcoded `http://localhost/wp/wp-admin` (`paths.host` in `gulpfile.js`); it only works against a local WP install.

There is no local WordPress in this repo — the plugin must be symlinked/copied into a `wp-content/plugins/` directory to run.

## Architecture

### Bootstrap (`wp-bom.php`)

- Namespace `Netraa\WPB`. A hand-rolled `spl_autoload_register` maps `Netraa\WPB\Foo\Bar` → `includes/Foo/Bar.php`. **Any new class must live under `includes/` with a filename matching the class name**, or it will not autoload. There is no Composer autoloader for plugin code.
- `plugins_loaded` → `Netraa\WPB\init()`, which `require`s the two bundled third-party plugins (`wp-all-import-pro/`, `wpai-acf-add-on/`) plus `includes/acfload.php`, then bootstraps singletons: `Plugin`, `Post`, `Shortcode`, `Endpoint\Example`, and `new Settings()`.
- `Admin::get_instance()` is **commented out** in `init()`, so the admin menu, settings page, and the `wp_ajax_wco_ajax` handler in `includes/Admin.php` are currently dead code. `includes/Admin2.php` is an unreferenced variant. Wiring the admin UI back on means uncommenting that line.
- Asset switching is driven by the namespaced `const WP_BOM` (set to `WP_BOM_BUILD`, i.e. `'build'`). Note there are two constants with the same name: `define('WP_BOM_BUILD','prod')` creates a *global* constant while `const WP_BOM_BUILD = 'build'` creates `Netraa\WPB\WP_BOM_BUILD`; unqualified lookups inside the namespace resolve to the latter, so the `WP_BOM === WP_BOM_PROD` branches never fire and the minified `dist/` assets are what actually load. Change `const WP_BOM` to flip this.
- `node_modules/` is enqueued at runtime (`select2` is loaded straight out of `node_modules/select2/dist/`), so `node_modules` has to ship with the deployed plugin.

### Data model

Custom post types are registered by `Post::register_post_types2()` (hooked on `init`) through the `gen_cpt( $labels, $args )` helper, which reads the type slug from `$labels['id']`:

| slug | REST `rest_base` |
|---|---|
| `part` | `parts-api` |
| `assembly` | `assembly-api` |
| `requisition` | `req-api` |
| `bom` | `bom-api` |
| `ecn` | — |

The older `register_post_types()` is **not** hooked, and since it is the only caller of `register_taxonomy()`, the `material` / `vendor` / `location` / `keyword` taxonomies defined further down `includes/Post.php` are not actually registered at runtime.

A BOM is expressed as an **ACF repeater field named `items`** on an `assembly` post. Each row has sub-fields `type`, `level`, `quantity`, and `item` (a post ID pointing at another `part` or `assembly`). Recursion through those rows — an assembly whose `items` contain assemblies — is the core of the domain logic, and it is implemented several times over:

- `PostObject` — `set_levels()`, `set_levels2()`, `setSub()`, `setItems()`; base class for `Assembly`.
- `Component` — the largest/most developed version (`setCfAssemItems`, `setAssemblyItemList`, `setSub`, `parse_tiers`).
- `BOM` — thin wrapper that drives a `Component`.
- `Module` — another `get_item_data()` pass that also self-heals rows whose `type` sub-field disagrees with the referenced post's real `post_type`.

`zap.json` and `assets/export/*.json` are captured output of this recursion and are useful references for the expected nested shape (`{title, type, qty, sub: {…, sub2: […]}}`).

`Plugin::upgrade_data()` creates a custom table `{$wpdb->prefix}wpb_bom` (`WP_BOM_TBL`) via `dbDelta` on activation, but nothing writes to it in the current code path. Note the activation/deactivation hooks pass `[ 'Netraa\WPB\Plugin', 'activate' ]` — static callables for methods declared non-static.

### Settings

`includes/Settings.php` declares sections (`wpb_settings`, `wpb_advanced`, …) and field definitions, and hands them to `includes/SettingsAPI.php` — a vendored copy of the well-known WordPress Settings API wrapper that renders every field type (`callback_text`, `callback_multicheck`, `callback_select`, …). Add or change settings in `Settings::get_settings_sections()` / `get_settings_fields()`; `SettingsAPI.php` is generic plumbing and rarely needs edits. `Data` reads all those options plus caches `part`/`assembly`/`requisition` post lists into `wp_cache`.

### ACF

ACF **Pro is vendored** at `includes/acf/` and conditionally loaded by `includes/acfload.php` only when `class_exists('acf')` is false, so a site-installed ACF Pro wins. `acfload.php` filters `acf/settings/path` and `acf/settings/dir` to the bundled copy, points the JSON save point at `includes/acf-json/` and the load point at `includes/acf-json-load` (**neither directory exists in the repo** — field groups are therefore DB-only, not version-controlled), and suppresses ACF update notices. It also registers an options page under the `wp-bom` menu.

All ACF field access in this plugin goes through the ACF API (`get_field`, `have_rows`/`the_row`/`get_sub_field`, `update_sub_field`), never raw post meta.

### React layer

`webpack.config.js` builds three independent apps, one per WordPress view:

```
app/admin.js      -> assets/js/admin.js       (settings page)
app/shortcode.js  -> assets/js/shortcode.js   ([wp-bom] shortcode)
app/widget.js     -> assets/js/widget.js      (Widget)
```

Each PHP side (`Admin`, `Shortcode`, `Widget`) creates a uniquely-named JS object via `wp_localize_script` and renders an empty `<div data-object-id="…">`; the entry point reads that object and passes it into the container as the `wpObject` prop. `app/utils/fetchWP.js` wraps `fetch` with the `X-WP-Nonce` header and is initialised from `wpObject.api_url` / `wpObject.api_nonce`.

Known mismatch: `app/admin.js` mounts into `document.getElementById('wp-bom')` and reads `window.wpr_object`, but `Admin::display_plugin_admin_page()` renders `#wp-bom-admin` (only the unused `display_plugin_admin_page2()` renders `#wp-bom`). The React admin app does not currently mount.

**`assets/js/wp-bom.js` and `assets/js/wp-bom-admin.js` are hand-written jQuery, not webpack output** — edit them in place. Everything else in `assets/js/` is generated; never edit those by hand. Gulp then uglifies `assets/js/*.js` → `dist/js/*.min.js` and cssnanos `assets/css/*` → `dist/css/*.min.css`. `dist/` is committed.

### REST API

Custom controllers live in `includes/Endpoint/` under namespace `wp-bom/v1`:

- `Example` — `/example/` CRUD over the `wpb_example_setting` option; guarded by `manage_options`. This is the boilerplate endpoint the React admin app talks to.
- `PartAPI` — `/part/`; **not instantiated in `init()`**, so its routes are not registered.

New endpoints follow the same shape: singleton `get_instance()` → `do_hooks()` → `rest_api_init` → `register_rest_route()`, with a `permission_callback` on every route.

### Vendored code — do not edit

`wp-all-import-pro/`, `wpai-acf-add-on/`, `includes/acf/`, `includes/SettingsAPI.php`, and `wp-all-import-pro/static/codemirror/` are third-party. They are listed in `.gitignore` but committed anyway; the plugin `require`s the first two unconditionally in `init()`, so removing them breaks activation.
