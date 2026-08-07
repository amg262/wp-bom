<?php
/**
 * Minimal WordPress stubs so the BOM engine can be exercised without a WP install.
 *
 * Only the functions WPBom\Explosion, WPBom\Meta, WPBom\Settings and WPBom\Render
 * actually call are implemented, backed by an in-memory post and meta store.
 *
 * @package WPBom\Tests
 */

declare( strict_types=1 );

define( 'ABSPATH', __DIR__ );
define( 'WPBOM_FILE', dirname( __DIR__ ) . '/wp-bom.php' );
define( 'WPBOM_DIR', dirname( __DIR__ ) . '/' );
define( 'WPBOM_URL', 'https://example.test/wp-content/plugins/wp-bom/' );

/**
 * In-memory store standing in for the posts and postmeta tables.
 */
final class WPBom_Test_Store {

	/**
	 * Posts by ID.
	 *
	 * @var array<int, WP_Post>
	 */
	public static array $posts = [];

	/**
	 * Meta rows: [post_id][meta_key] = list of values.
	 *
	 * @var array<int, array<string, array<int, mixed>>>
	 */
	public static array $meta = [];

	/**
	 * Site options.
	 *
	 * @var array<string, mixed>
	 */
	public static array $options = [];

	/**
	 * Wipe everything between tests.
	 */
	public static function reset(): void {
		self::$posts   = [];
		self::$meta    = [];
		self::$options = [];

		\WPBom\Explosion::flush_cache();
	}
}

/**
 * Stand-in for the core WP_Post class.
 */
final class WP_Post {

	public int $ID = 0;
	public string $post_title = '';
	public string $post_type = 'post';
	public string $post_status = 'publish';

	/**
	 * @param array<string, mixed> $data Field values.
	 */
	public function __construct( array $data = [] ) {
		foreach ( $data as $key => $value ) {
			if ( property_exists( $this, $key ) ) {
				$this->$key = $value;
			}
		}
	}
}

/**
 * Create a post in the store.
 *
 * @param array<string, mixed> $data Post fields, must include ID.
 */
function wpbom_test_insert_post( array $data ): int {
	$post = new WP_Post( $data );

	WPBom_Test_Store::$posts[ $post->ID ] = $post;

	return $post->ID;
}

// ---------------------------------------------------------------------------
// Post API
// ---------------------------------------------------------------------------

function get_post( $post_id = 0 ) {
	$post_id = (int) $post_id;

	return WPBom_Test_Store::$posts[ $post_id ] ?? null;
}

function get_post_type( $post_id = 0 ) {
	$post = get_post( $post_id );

	return $post instanceof WP_Post ? $post->post_type : false;
}

function get_the_title( $post_id = 0 ): string {
	$post = get_post( $post_id );

	return $post instanceof WP_Post ? $post->post_title : '';
}

function get_edit_post_link( $post_id = 0, $context = 'display' ): string {
	return 'https://example.test/wp-admin/post.php?post=' . (int) $post_id . '&action=edit';
}

function get_permalink( $post_id = 0 ): string {
	return 'https://example.test/?p=' . (int) $post_id;
}

function get_post_status( $post_id = 0 ) {
	$post = get_post( $post_id );

	return $post instanceof WP_Post ? $post->post_status : false;
}

/**
 * Supports only the subset of WP_Query args the plugin uses.
 *
 * @param array<string, mixed> $args Query args.
 *
 * @return array<int, WP_Post|int>
 */
function get_posts( array $args = [] ): array {
	$types   = (array) ( $args['post_type'] ?? 'post' );
	$exclude = array_map( 'intval', (array) ( $args['exclude'] ?? [] ) );
	$results = [];

	foreach ( WPBom_Test_Store::$posts as $post ) {
		if ( ! in_array( $post->post_type, $types, true ) ) {
			continue;
		}

		if ( in_array( $post->ID, $exclude, true ) ) {
			continue;
		}

		if ( isset( $args['meta_query'] ) ) {
			$matched = true;

			foreach ( (array) $args['meta_query'] as $clause ) {
				if ( ! is_array( $clause ) || ! isset( $clause['key'] ) ) {
					continue;
				}

				$values = WPBom_Test_Store::$meta[ $post->ID ][ $clause['key'] ] ?? [];

				// Loose comparison mirrors how MySQL compares meta values.
				if ( ! in_array( (string) $clause['value'], array_map( 'strval', $values ), true ) ) {
					$matched = false;
					break;
				}
			}

			if ( ! $matched ) {
				continue;
			}
		}

		$results[] = 'ids' === ( $args['fields'] ?? '' ) ? $post->ID : $post;
	}

	return $results;
}

// ---------------------------------------------------------------------------
// Meta API
// ---------------------------------------------------------------------------

function get_post_meta( $post_id = 0, $key = '', $single = false ) {
	$values = WPBom_Test_Store::$meta[ (int) $post_id ][ $key ] ?? [];

	if ( $single ) {
		return $values[0] ?? '';
	}

	return $values;
}

function update_post_meta( $post_id, $key, $value ): bool {
	WPBom_Test_Store::$meta[ (int) $post_id ][ $key ] = [ $value ];

	return true;
}

function add_post_meta( $post_id, $key, $value ): bool {
	WPBom_Test_Store::$meta[ (int) $post_id ][ $key ][] = $value;

	return true;
}

function delete_post_meta( $post_id, $key ): bool {
	unset( WPBom_Test_Store::$meta[ (int) $post_id ][ $key ] );

	return true;
}

// ---------------------------------------------------------------------------
// Options
// ---------------------------------------------------------------------------

function get_option( $name, $default = false ) {
	return WPBom_Test_Store::$options[ $name ] ?? $default;
}

function update_option( $name, $value ): bool {
	WPBom_Test_Store::$options[ $name ] = $value;

	return true;
}

function add_option( $name, $value ): bool {
	if ( isset( WPBom_Test_Store::$options[ $name ] ) ) {
		return false;
	}

	WPBom_Test_Store::$options[ $name ] = $value;

	return true;
}

// ---------------------------------------------------------------------------
// Sanitising, escaping, i18n
// ---------------------------------------------------------------------------

function absint( $value ): int {
	return abs( (int) $value );
}

function sanitize_text_field( $value ): string {
	return trim( strip_tags( (string) $value ) );
}

function sanitize_file_name( $value ): string {
	return preg_replace( '/[^A-Za-z0-9._-]/', '-', (string) $value ) ?? '';
}

function wp_kses_post( $value ): string {
	return (string) $value;
}

function esc_html( $value ): string {
	return htmlspecialchars( (string) $value, ENT_QUOTES, 'UTF-8' );
}

function esc_attr( $value ): string {
	return htmlspecialchars( (string) $value, ENT_QUOTES, 'UTF-8' );
}

function esc_url( $value ): string {
	return (string) $value;
}

function esc_textarea( $value ): string {
	return htmlspecialchars( (string) $value, ENT_QUOTES, 'UTF-8' );
}

function esc_html__( $text, $domain = '' ): string {
	return esc_html( $text );
}

function esc_attr__( $text, $domain = '' ): string {
	return esc_attr( $text );
}

function __( $text, $domain = '' ): string {
	return (string) $text;
}

function _e( $text, $domain = '' ): void {
	echo $text;
}

function number_format_i18n( $number, $decimals = 0 ): string {
	return number_format( (float) $number, (int) $decimals );
}

// ---------------------------------------------------------------------------
// Hooks and capabilities
// ---------------------------------------------------------------------------

function apply_filters( $tag, $value, ...$args ) {
	return $value;
}

function add_action( ...$args ): bool {
	return true;
}

function add_filter( ...$args ): bool {
	return true;
}

function do_action( ...$args ): void {}

function current_user_can( ...$args ): bool {
	return true;
}

function plugin_basename( $file ): string {
	return basename( dirname( (string) $file ) ) . '/' . basename( (string) $file );
}

function admin_url( $path = '' ): string {
	return 'https://example.test/wp-admin/' . ltrim( (string) $path, '/' );
}

function register_post_meta( ...$args ): bool {
	return true;
}

// ---------------------------------------------------------------------------
// Admin form helpers
// ---------------------------------------------------------------------------

function wp_nonce_field( $action = '', $name = '_wpnonce', ...$rest ): void {
	echo '<input type="hidden" name="' . esc_attr( (string) $name ) . '" value="test-nonce" />';
}

function wp_verify_nonce( $nonce, $action = '' ) {
	return 'test-nonce' === $nonce ? 1 : false;
}

function wp_unslash( $value ) {
	return $value;
}

function selected( $haystack, $current = true, $echo = true ): string {
	// Loose comparison mirrors core, which compares form strings to typed values.
	$result = ( (string) $haystack === (string) $current ) ? " selected='selected'" : '';

	if ( $echo ) {
		echo $result;
	}

	return $result;
}

function checked( $haystack, $current = true, $echo = true ): string {
	$result = ( (string) $haystack === (string) $current ) ? " checked='checked'" : '';

	if ( $echo ) {
		echo $result;
	}

	return $result;
}

function wp_is_post_revision( $post_id ): bool {
	return false;
}

function wp_is_post_autosave( $post_id ): bool {
	return false;
}

function add_meta_box( $id, ...$args ): void {
	if ( class_exists( 'WPBom_Test_Registry' ) ) {
		WPBom_Test_Registry::$meta_boxes[] = (string) $id;
	}
}

function add_shortcode( ...$args ): void {}

function shortcode_atts( $pairs, $atts, $shortcode = '' ): array {
	return array_merge( $pairs, is_array( $atts ) ? array_intersect_key( $atts, $pairs ) : [] );
}

function wp_enqueue_style( ...$args ): void {}

function wp_enqueue_script( ...$args ): void {}

function register_setting( ...$args ): void {}

function add_settings_section( ...$args ): void {}

function add_settings_field( ...$args ): void {}

function add_query_arg( $args, $url = '' ): string {
	return $url . '?' . http_build_query( is_array( $args ) ? $args : [] );
}

function wp_nonce_url( $url, $action = -1 ): string {
	return $url . '&_wpnonce=test-nonce';
}

// ---------------------------------------------------------------------------
// Registration APIs, recording what the plugin asks for
// ---------------------------------------------------------------------------

/**
 * Records registrations so the boot smoke test can assert on them.
 */
final class WPBom_Test_Registry {

	/**
	 * Registered post types, keyed by slug.
	 *
	 * @var array<string, array<string, mixed>>
	 */
	public static array $post_types = [];

	/**
	 * Registered taxonomies, keyed by slug.
	 *
	 * @var array<string, array<string, mixed>>
	 */
	public static array $taxonomies = [];

	/**
	 * Registered REST routes as "namespace/route" strings.
	 *
	 * @var string[]
	 */
	public static array $routes = [];

	/**
	 * Registered meta box IDs.
	 *
	 * @var string[]
	 */
	public static array $meta_boxes = [];
}

function load_plugin_textdomain( ...$args ): bool {
	return true;
}

function register_post_type( $slug, $args = [] ) {
	WPBom_Test_Registry::$post_types[ $slug ] = $args;

	return (object) [ 'name' => $slug ];
}

function register_taxonomy( $slug, $object_type, $args = [] ): void {
	WPBom_Test_Registry::$taxonomies[ $slug ] = [
		'object_type' => (array) $object_type,
		'args'        => $args,
	];
}

function register_rest_route( $namespace, $route, $args = [] ): bool {
	WPBom_Test_Registry::$routes[] = $namespace . $route;

	return true;
}

function add_submenu_page( ...$args ): string {
	return 'wpbom-settings';
}

function flush_rewrite_rules( ...$args ): void {}

/**
 * Stand-in for the core REST server constants.
 */
final class WP_REST_Server {
	public const READABLE = 'GET';
}

require_once dirname( __DIR__ ) . '/includes/PostTypes.php';
require_once dirname( __DIR__ ) . '/includes/Meta.php';
require_once dirname( __DIR__ ) . '/includes/Explosion.php';
require_once dirname( __DIR__ ) . '/includes/Settings.php';
require_once dirname( __DIR__ ) . '/includes/Render.php';
require_once dirname( __DIR__ ) . '/includes/Export.php';
require_once dirname( __DIR__ ) . '/includes/Rest.php';
require_once dirname( __DIR__ ) . '/includes/MetaBoxes.php';
require_once dirname( __DIR__ ) . '/includes/Shortcode.php';
require_once dirname( __DIR__ ) . '/includes/AdminColumns.php';
require_once dirname( __DIR__ ) . '/includes/Assets.php';
require_once dirname( __DIR__ ) . '/includes/Install.php';
require_once dirname( __DIR__ ) . '/includes/Plugin.php';

// Plugin::boot() reads the version constant the main plugin file defines.
if ( ! defined( 'WPBom\VERSION' ) ) {
	define( 'WPBom\VERSION', '2.0.0' );
}
