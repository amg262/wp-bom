<?php
/**
 * Standalone test runner for the BOM explosion engine.
 *
 * Usage: php tests/run.php
 *
 * Deliberately dependency-free so the maths can be verified on any machine with
 * PHP 8, without composer, PHPUnit or a WordPress install.
 *
 * @package WPBom\Tests
 */

declare( strict_types=1 );

require_once __DIR__ . '/bootstrap.php';

use WPBom\Explosion;
use WPBom\Meta;
use WPBom\PostTypes;
use WPBom\Render;

$passed = 0;
$failed = 0;

/**
 * Assert two values match.
 *
 * @param string $label    What is being checked.
 * @param mixed  $expected Expected value.
 * @param mixed  $actual   Actual value.
 */
function check( string $label, mixed $expected, mixed $actual ): void {
	global $passed, $failed;

	$ok = is_float( $expected ) || is_float( $actual )
		? abs( (float) $expected - (float) $actual ) < 0.00001
		: $expected === $actual;

	if ( $ok ) {
		++$passed;
		echo "  \033[32mPASS\033[0m {$label}\n";

		return;
	}

	++$failed;
	echo "  \033[31mFAIL\033[0m {$label}\n";
	echo '       expected: ' . var_export( $expected, true ) . "\n";
	echo '       actual:   ' . var_export( $actual, true ) . "\n";
}

/**
 * Announce a test group.
 */
function group( string $name ): void {
	echo "\n\033[1m{$name}\033[0m\n";
}

/**
 * Create a part with cost and weight.
 */
function make_part( int $id, string $title, float $cost = 0.0, float $weight = 0.0, string $number = '' ): int {
	wpbom_test_insert_post(
		[
			'ID'         => $id,
			'post_title' => $title,
			'post_type'  => PostTypes::PART,
		]
	);

	update_post_meta( $id, Meta::UNIT_COST, $cost );
	update_post_meta( $id, Meta::WEIGHT, $weight );
	update_post_meta( $id, Meta::PART_NUMBER, '' !== $number ? $number : 'P-' . $id );
	update_post_meta( $id, Meta::UOM, 'ea' );

	return $id;
}

/**
 * Create an assembly with line items.
 *
 * @param array<int, array{0:int, 1:float}> $lines [child ID, qty] pairs.
 */
function make_assembly( int $id, string $title, array $lines = [], float $labor = 0.0 ): int {
	wpbom_test_insert_post(
		[
			'ID'         => $id,
			'post_title' => $title,
			'post_type'  => PostTypes::ASSEMBLY,
		]
	);

	update_post_meta( $id, Meta::LABOR_COST, $labor );
	update_post_meta( $id, Meta::PART_NUMBER, 'A-' . $id );
	update_post_meta( $id, Meta::UOM, 'ea' );

	$items = [];

	foreach ( $lines as $line ) {
		$items[] = [
			'item_id'   => $line[0],
			'qty'       => $line[1],
			'reference' => $line[2] ?? '',
			'note'      => '',
		];
	}

	Meta::set_items( $id, $items );

	return $id;
}

/**
 * Find one flattened row by post ID.
 *
 * @param array<int, array<string, mixed>> $rows Flattened rows.
 *
 * @return array<string, mixed>|null
 */
function row_for( array $rows, int $id ): ?array {
	foreach ( $rows as $row ) {
		if ( (int) $row['id'] === $id ) {
			return $row;
		}
	}

	return null;
}

// ---------------------------------------------------------------------------

group( 'Single-level assembly rolls up cost and weight' );

WPBom_Test_Store::reset();
make_part( 10, 'Bracket', 10.00, 0.5 );
make_part( 11, 'Bolt', 0.25, 0.01 );
make_assembly( 100, 'Frame', [ [ 10, 2 ], [ 11, 8 ] ] );

$tree = Explosion::tree( 100 );

check( 'unit cost = 2*10.00 + 8*0.25', 22.0, $tree['unit_cost'] );
check( 'unit weight = 2*0.5 + 8*0.01', 1.08, $tree['unit_weight'] );
check( 'two child lines', 2, count( $tree['children'] ) );
check( 'bolt extended qty', 8.0, $tree['children'][1]['qty_total'] );

// ---------------------------------------------------------------------------

group( 'Build quantity extends every level' );

$tree = Explosion::tree( 100, 5.0 );

check( 'cost each is unchanged', 22.0, $tree['unit_cost'] );
check( 'extended cost = 5 * 22.00', 110.0, $tree['ext_cost'] );
check( 'bracket extended qty = 5 * 2', 10.0, $tree['children'][0]['qty_total'] );
check( 'bolt extended qty = 5 * 8', 40.0, $tree['children'][1]['qty_total'] );

// ---------------------------------------------------------------------------

group( 'Nested sub-assemblies multiply through' );

WPBom_Test_Store::reset();
make_part( 10, 'Bracket', 10.00, 0.5 );
make_part( 11, 'Bolt', 0.25, 0.01 );
make_assembly( 100, 'Frame', [ [ 10, 2 ], [ 11, 8 ] ] );
make_assembly( 200, 'Chassis', [ [ 100, 3 ], [ 11, 4 ] ] );

$tree = Explosion::tree( 200 );

check( 'unit cost = 3*22.00 + 4*0.25', 67.0, $tree['unit_cost'] );

$flat = Explosion::flatten( $tree );

check( 'two distinct parts', 2, count( $flat ) );
check( 'bracket total qty = 3*2', 6.0, row_for( $flat, 10 )['qty_total'] );
check( 'bolt total qty = 3*8 + 4', 28.0, row_for( $flat, 11 )['qty_total'] );
check( 'bolt extended cost = 28 * 0.25', 7.0, row_for( $flat, 11 )['ext_cost'] );

// ---------------------------------------------------------------------------

group( 'Labor cost adds at each assembly level' );

WPBom_Test_Store::reset();
make_part( 10, 'Bracket', 10.00 );
make_assembly( 100, 'Frame', [ [ 10, 2 ] ], 15.00 );
make_assembly( 200, 'Chassis', [ [ 100, 2 ] ], 30.00 );

$tree = Explosion::tree( 200 );

check( 'frame each = 2*10 + 15', 35.0, $tree['children'][0]['unit_cost'] );
check( 'chassis each = 2*35 + 30', 100.0, $tree['unit_cost'] );

// ---------------------------------------------------------------------------

group( 'Circular references are detected, not fatal' );

WPBom_Test_Store::reset();
make_part( 10, 'Bracket', 10.00 );
make_assembly( 100, 'A', [ [ 10, 1 ] ] );
make_assembly( 200, 'B', [ [ 100, 1 ] ] );

// Close the loop: A now contains B, and B already contains A.
Meta::set_items(
	100,
	[
		[ 'item_id' => 10, 'qty' => 1 ],
		[ 'item_id' => 200, 'qty' => 1 ],
	]
);
Explosion::flush_cache();

$tree    = Explosion::tree( 100 );
$summary = Explosion::summary( $tree );

check( 'explosion completed', true, is_array( $tree ) );
check( 'cycle flagged', true, $summary['has_cycle'] );
check( 'cycle contributes no cost', 10.0, $tree['unit_cost'] );

$cycle_nodes = 0;
Explosion::walk(
	$tree,
	static function ( array $node ) use ( &$cycle_nodes ): void {
		if ( $node['cycle'] ) {
			++$cycle_nodes;
		}
	}
);

check( 'exactly one cycle stub', 1, $cycle_nodes );

// ---------------------------------------------------------------------------

group( 'Self-references are rejected on save' );

WPBom_Test_Store::reset();
make_part( 10, 'Bracket', 10.00 );
make_assembly( 100, 'A', [] );

Meta::set_items(
	100,
	[
		[ 'item_id' => 100, 'qty' => 1 ],
		[ 'item_id' => 10, 'qty' => 2 ],
	]
);

$items = Meta::get_items( 100 );

check( 'self-reference dropped', 1, count( $items ) );
check( 'real line kept', 10, $items[0]['item_id'] );

// ---------------------------------------------------------------------------

group( 'Invalid line items are filtered' );

WPBom_Test_Store::reset();
make_part( 10, 'Bracket', 10.00 );
wpbom_test_insert_post( [ 'ID' => 999, 'post_title' => 'A page', 'post_type' => 'page' ] );
make_assembly( 100, 'A', [] );

Meta::set_items(
	100,
	[
		[ 'item_id' => 999, 'qty' => 1 ],   // Wrong post type.
		[ 'item_id' => 0, 'qty' => 1 ],     // Blank row.
		[ 'item_id' => 10, 'qty' => 0 ],    // Zero qty becomes 1.
	]
);

$items = Meta::get_items( 100 );

check( 'only the valid row survives', 1, count( $items ) );
check( 'zero quantity defaults to 1', 1.0, $items[0]['qty'] );

// ---------------------------------------------------------------------------

group( 'Missing items degrade gracefully' );

WPBom_Test_Store::reset();
make_part( 10, 'Bracket', 10.00 );
make_assembly( 100, 'A', [ [ 10, 1 ] ] );

// Simulate the referenced part being deleted after the fact.
update_post_meta(
	100,
	Meta::ITEMS,
	[
		[ 'item_id' => 10, 'qty' => 1, 'reference' => '', 'note' => '' ],
		[ 'item_id' => 4242, 'qty' => 3, 'reference' => '', 'note' => '' ],
	]
);
Explosion::flush_cache();

$tree    = Explosion::tree( 100 );
$summary = Explosion::summary( $tree );

check( 'missing item flagged', true, $summary['has_missing'] );
check( 'cost excludes the missing item', 10.0, $tree['unit_cost'] );
check( 'both lines still listed', 2, count( $tree['children'] ) );

// ---------------------------------------------------------------------------

group( 'Depth limit truncates instead of recursing forever' );

WPBom_Test_Store::reset();
make_part( 10, 'Bracket', 1.00 );

// Chain of 6 assemblies, L0 (id 500) down to L5 (id 505), which holds the part.
make_assembly( 505, 'L5', [ [ 10, 1 ] ] );
for ( $i = 4; $i >= 0; $i-- ) {
	make_assembly( 500 + $i, 'L' . $i, [ [ 500 + $i + 1, 1 ] ] );
}

$tree    = Explosion::tree( 500, 1.0, 3 );
$summary = Explosion::summary( $tree );

check( 'truncation flagged at depth 3', true, $summary['has_truncated'] );

$full = Explosion::tree( 500, 1.0, 10 );

check( 'full depth reaches the part', 1.0, $full['unit_cost'] );
check( 'full depth is not truncated', false, Explosion::summary( $full )['has_truncated'] );

// ---------------------------------------------------------------------------

group( 'Where-used index resolves parents' );

WPBom_Test_Store::reset();
make_part( 10, 'Bolt', 0.25 );
make_assembly( 100, 'Frame', [ [ 10, 4 ] ] );
make_assembly( 200, 'Chassis', [ [ 10, 2 ] ] );
make_assembly( 300, 'Panel', [] );

$used = Meta::where_used( 10 );
sort( $used );

check( 'bolt used in two assemblies', [ 100, 200 ], $used );
check( 'unused part has no parents', [], Meta::where_used( 999 ) );

// Removing the line updates the index.
Meta::set_items( 100, [] );

check( 'index shrinks after removal', [ 200 ], Meta::where_used( 10 ) );

// ---------------------------------------------------------------------------

group( 'Number sanitising accepts messy input' );

check( 'currency string', 1234.50, Meta::sanitize_float( '$1,234.50' ) );
check( 'empty string', 0.0, Meta::sanitize_float( '' ) );
check( 'negative clamped to zero', 0.0, Meta::sanitize_float( '-5' ) );
check( 'array rejected', 0.0, Meta::sanitize_float( [ 1, 2 ] ) );
check( 'plain float', 3.75, Meta::sanitize_float( 3.75 ) );

// ---------------------------------------------------------------------------

group( 'Rendering produces escaped, complete tables' );

WPBom_Test_Store::reset();
make_part( 10, '<script>alert(1)</script>', 10.00 );
make_assembly( 100, 'Frame', [ [ 10, 2 ] ] );

$tree = Explosion::tree( 100 );
$html = Render::tree_table( $tree );

check( 'title is escaped', false, str_contains( $html, '<script>alert' ) );
check( 'escaped form present', true, str_contains( $html, '&lt;script&gt;' ) );
check( 'quantity column rendered', true, str_contains( $html, '<td class="wpbom-num">2</td>' ) );

$flat_html = Render::flat_table( Explosion::flatten( $tree ) );

check( 'flat table has a total row', true, str_contains( $flat_html, 'Material total' ) );

// ---------------------------------------------------------------------------

group( 'Meta box renders a usable line-item editor' );

WPBom_Test_Store::reset();
make_part( 10, 'Bracket', 10.00, 0.0, 'BRK-1042' );
make_part( 11, 'Bolt', 0.25, 0.0, 'BLT-0001' );
make_assembly( 100, 'Frame', [ [ 10, 2, 'R1' ] ] );

$boxes = new WPBom\MetaBoxes();

ob_start();
$boxes->render_line_items( get_post( 100 ) );
$html = (string) ob_get_clean();

check( 'nonce field present', true, str_contains( $html, 'wpbom_nonce' ) );
check( 'saved row is selected', true, str_contains( $html, "value=\"10\" selected='selected'>BRK-1042" ) );
check( 'saved quantity rendered', true, str_contains( $html, 'name="wpbom_items[0][qty]" value="2"' ) );
check( 'reference designator rendered', true, str_contains( $html, 'value="R1"' ) );
check( 'other parts offered as options', true, str_contains( $html, 'BLT-0001 — Bolt' ) );
check( 'assembly excludes itself', false, str_contains( $html, 'value="100"' ) );
check( 'add-row template present', true, str_contains( $html, '__index__' ) );

// ---------------------------------------------------------------------------

group( 'Meta box save persists the whole form' );

WPBom_Test_Store::reset();
make_part( 10, 'Bracket', 0.0 );
make_part( 11, 'Bolt', 0.0 );
make_assembly( 100, 'Frame', [] );

$_POST = [
	'wpbom_nonce'         => 'test-nonce',
	'wpbom_part_number'   => 'ASM-200',
	'wpbom_revision'      => 'C',
	'wpbom_uom'           => 'ea',
	'wpbom_status'        => 'active',
	'wpbom_labor_cost'    => '$15.50',
	'wpbom_items'         => [
		[ 'item_id' => '10', 'qty' => '2', 'reference' => 'R1', 'note' => '' ],
		[ 'item_id' => '11', 'qty' => '8', 'reference' => 'R2', 'note' => 'torque to spec' ],
	],
];

$boxes->save( 100, get_post( 100 ) );

check( 'assembly number saved', 'ASM-200', Meta::get_string( 100, Meta::PART_NUMBER ) );
check( 'revision saved', 'C', Meta::get_string( 100, Meta::REVISION ) );
check( 'currency-formatted labor parsed', 15.50, Meta::get_float( 100, Meta::LABOR_COST ) );
check( 'both line items saved', 2, count( Meta::get_items( 100 ) ) );
check( 'quantities saved', 8.0, Meta::get_items( 100 )[1]['qty'] );
check( 'notes saved', 'torque to spec', Meta::get_items( 100 )[1]['note'] );
check( 'where-used index written', [ 100 ], Meta::where_used( 11 ) );

group( 'Meta box save rejects a bad nonce' );

$_POST['wpbom_nonce']       = 'wrong';
$_POST['wpbom_part_number'] = 'TAMPERED';

$boxes->save( 100, get_post( 100 ) );

check( 'unchanged after failed nonce', 'ASM-200', Meta::get_string( 100, Meta::PART_NUMBER ) );

group( 'Invalid choice values fall back instead of persisting garbage' );

$_POST = [
	'wpbom_nonce'  => 'test-nonce',
	'wpbom_uom'    => 'furlongs',
	'wpbom_status' => '; DROP TABLE',
];

$boxes->save( 100, get_post( 100 ) );

check( 'unknown unit rejected', 'ea', Meta::get_string( 100, Meta::UOM ) );
check( 'unknown status rejected', 'active', Meta::get_string( 100, Meta::STATUS ) );

$_POST = [];

// ---------------------------------------------------------------------------

group( 'Shortcode renders and resolves BOM documents' );

WPBom_Test_Store::reset();
make_part( 10, 'Bracket', 10.00 );
make_assembly( 100, 'Frame', [ [ 10, 2 ] ] );

wpbom_test_insert_post( [ 'ID' => 700, 'post_title' => 'Frame BOM', 'post_type' => PostTypes::BOM ] );
update_post_meta( 700, Meta::ROOT_ID, 100 );
update_post_meta( 700, Meta::BUILD_QTY, 10.0 );

$shortcode = new WPBom\Shortcode();
$output    = $shortcode->render( [ 'id' => '700', 'view' => 'both' ] );

check( 'BOM document resolves to its assembly', true, str_contains( $output, 'Bracket' ) );
check( 'build quantity applied (10 * 2)', true, str_contains( $output, '>20 ea<' ) );
check( 'totals strip rendered', true, str_contains( $output, 'wpbom-totals' ) );
check( 'both views rendered', true, str_contains( $output, 'wpbom-flat-table' ) && str_contains( $output, 'wpbom-tree-table' ) );

$missing = $shortcode->render( [ 'id' => '4242' ] );

check( 'unknown ID gives a notice, not a crash', true, str_contains( $missing, 'wpbom-notice' ) );

// ---------------------------------------------------------------------------

group( 'CSV export produces the flat list with totals' );

WPBom_Test_Store::reset();
make_part( 10, 'Bracket', 10.00, 0.5, 'BRK-1042' );
make_part( 11, 'Bolt', 0.25, 0.01, 'BLT-0001' );
make_assembly( 100, 'Frame', [ [ 10, 2, 'R1' ], [ 11, 8, 'R2' ] ] );

$tree = Explosion::tree( 100, 3.0 );
$rows = WPBom\Export::build_rows( $tree );

check( 'summary names the assembly', [ 'Assembly', 'Frame' ], $rows[0] );
check( 'summary carries total cost', 66.0, $rows[3][1] );
check( 'blank separator row', [], $rows[5] );
check( 'column header row', 'Part Number', $rows[6][0] );
check( 'one row per distinct part', 9, count( $rows ) );

// Rows are sorted by part number, so BLT-0001 precedes BRK-1042.
check( 'bolt row first', 'BLT-0001', $rows[7][0] );
check( 'bolt extended qty = 3 * 8', 24.0, $rows[7][5] );
check( 'bolt extended cost = 24 * 0.25', 6.0, $rows[7][7] );
check( 'bracket extended cost = 6 * 10.00', 60.0, $rows[8][7] );

// The writer must not emit a PHP 8.4 deprecation for the escape parameter.
$stream = fopen( 'php://memory', 'w+' );
$notice = '';

set_error_handler(
	static function ( int $errno, string $message ) use ( &$notice ): bool {
		$notice = $message;
		return true;
	},
	E_ALL
);

$writer = new ReflectionMethod( WPBom\Export::class, 'put' );
$writer->setAccessible( true );
$writer->invoke( null, $stream, [ 'a', 'b, with comma', 'c "quoted"' ] );

restore_error_handler();
rewind( $stream );
$line = (string) fgets( $stream );
fclose( $stream );

check( 'no deprecation from fputcsv', '', $notice );
check( 'commas are quoted', true, str_contains( $line, '"b, with comma"' ) );

// ---------------------------------------------------------------------------

group( 'Plugin boots and registers its content model' );

WPBom_Test_Store::reset();

// This is the path that fatally failed in 1.x: activation hooks called instance
// methods statically, and post type registration read a missing option key.
WPBom\Install::activate();

check( 'activation stores defaults', true, is_array( get_option( WPBom\Settings::OPTION ) ) );
check( 'part registered on a bare install', true, isset( WPBom_Test_Registry::$post_types['part'] ) );
check( 'assembly registered', true, isset( WPBom_Test_Registry::$post_types['assembly'] ) );
check( 'bom registered', true, isset( WPBom_Test_Registry::$post_types['bom'] ) );
check( 'vendor taxonomy registered', true, isset( WPBom_Test_Registry::$taxonomies['wpbom_vendor'] ) );
check( 'part is not hierarchical', false, WPBom_Test_Registry::$post_types['part']['hierarchical'] );

WPBom\Plugin::instance()->boot();

check( 'boot is idempotent', null, WPBom\Plugin::instance()->boot() );
check( 'services are reachable', true, WPBom\Plugin::instance()->service( 'metaboxes' ) instanceof WPBom\MetaBoxes );
check( 'unknown service returns null', null, WPBom\Plugin::instance()->service( 'nope' ) );

$rest = WPBom\Plugin::instance()->service( 'rest' );
$rest->register_routes();

check( 'items route registered', true, in_array( 'wp-bom/v1/items', WPBom_Test_Registry::$routes, true ) );
check( 'bom route registered', true, in_array( 'wp-bom/v1/bom/(?P<id>\d+)', WPBom_Test_Registry::$routes, true ) );

WPBom\Plugin::instance()->service( 'metaboxes' )->add_meta_boxes();

check( 'line items box registered', true, in_array( 'wpbom-line-items', WPBom_Test_Registry::$meta_boxes, true ) );
check( 'where-used box registered', true, in_array( 'wpbom-where-used', WPBom_Test_Registry::$meta_boxes, true ) );

WPBom\Plugin::instance()->service( 'settings' )->register_settings();
WPBom\Plugin::instance()->service( 'meta' )->register_meta();

check( 'settings defaults are sane', 12, WPBom\Settings::max_depth() );
check( 'depth is clamped to the hard ceiling', 25, ( function () {
	update_option( WPBom\Settings::OPTION, [ 'max_depth' => 999 ] );
	return WPBom\Settings::max_depth();
} )() );

// ---------------------------------------------------------------------------

echo "\n";
echo str_repeat( '-', 52 ) . "\n";
printf( "  \033[32m%d passed\033[0m, %s%d failed\033[0m\n", $passed, $failed > 0 ? "\033[31m" : '', $failed );
echo str_repeat( '-', 52 ) . "\n\n";

exit( $failed > 0 ? 1 : 0 );
