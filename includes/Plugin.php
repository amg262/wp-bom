<?php
/**
 * Plugin orchestrator.
 *
 * @package WPBom
 */

declare( strict_types=1 );

namespace WPBom;

/**
 * Wires every subsystem up on boot.
 *
 * Nothing in this plugin registers hooks in a constructor at file-include time;
 * everything hangs off boot() so load order stays predictable and the whole
 * thing is testable.
 */
final class Plugin {

	private static ?Plugin $instance = null;

	private bool $booted = false;

	/**
	 * Subsystems, instantiated on boot.
	 *
	 * @var array<string, object>
	 */
	private array $services = [];

	private function __construct() {}

	/**
	 * Shared instance.
	 */
	public static function instance(): Plugin {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Register every subsystem. Safe to call twice.
	 */
	public function boot(): void {
		if ( $this->booted ) {
			return;
		}

		$this->booted = true;

		load_plugin_textdomain( 'wp-bom', false, dirname( plugin_basename( WPBOM_FILE ) ) . '/languages' );

		$this->services = [
			'post_types' => new PostTypes(),
			'meta'       => new Meta(),
			'metaboxes'  => new MetaBoxes(),
			'columns'    => new AdminColumns(),
			'settings'   => new Settings(),
			'rest'       => new Rest(),
			'shortcode'  => new Shortcode(),
			'export'     => new Export(),
			'assets'     => new Assets(),
		];

		foreach ( $this->services as $service ) {
			if ( method_exists( $service, 'register' ) ) {
				$service->register();
			}
		}

		// Late upgrade check for sites that updated files without re-activating.
		add_action( 'admin_init', [ Install::class, 'maybe_upgrade' ] );
	}

	/**
	 * Fetch a booted subsystem by key.
	 */
	public function service( string $key ): ?object {
		return $this->services[ $key ] ?? null;
	}
}
