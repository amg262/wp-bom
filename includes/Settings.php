<?php
/**
 * Settings screen, built on the core Settings API.
 *
 * @package WPBom
 */

declare( strict_types=1 );

namespace WPBom;

/**
 * A single options page under the Parts menu.
 *
 * Replaces the bundled third-party SettingsAPI class the plugin used to carry,
 * and every getter here is defensive: a fresh install with no option row still
 * returns sane defaults instead of fatalling.
 */
final class Settings {

	public const OPTION    = 'wpbom_settings';
	public const PAGE_SLUG = 'wpbom-settings';

	/**
	 * Default option values.
	 *
	 * @return array<string, mixed>
	 */
	public static function defaults(): array {
		return [
			'currency_symbol' => '$',
			'cost_decimals'   => 2,
			'max_depth'       => 12,
			'public_bom'      => 1,
		];
	}

	/**
	 * The stored options merged over the defaults.
	 *
	 * @return array<string, mixed>
	 */
	public static function all(): array {
		$stored = get_option( self::OPTION, [] );

		if ( ! is_array( $stored ) ) {
			$stored = [];
		}

		return array_merge( self::defaults(), $stored );
	}

	/**
	 * One option value.
	 */
	public static function get( string $key, mixed $fallback = null ): mixed {
		$all = self::all();

		return $all[ $key ] ?? $fallback;
	}

	/**
	 * Currency symbol used in every money format.
	 */
	public static function currency_symbol(): string {
		$symbol = (string) self::get( 'currency_symbol', '$' );

		return '' !== $symbol ? $symbol : '$';
	}

	/**
	 * Decimal places used in every money format.
	 */
	public static function cost_decimals(): int {
		return (int) min( 6, max( 0, (int) self::get( 'cost_decimals', 2 ) ) );
	}

	/**
	 * Maximum explosion depth.
	 */
	public static function max_depth(): int {
		return (int) min( Explosion::MAX_DEPTH_LIMIT, max( 1, (int) self::get( 'max_depth', 12 ) ) );
	}

	/**
	 * Whether the shortcode renders for visitors who cannot edit posts.
	 */
	public static function public_bom(): bool {
		return (bool) self::get( 'public_bom', 1 );
	}

	/**
	 * Hook registration.
	 */
	public function register(): void {
		add_action( 'admin_menu', [ $this, 'add_page' ] );
		add_action( 'admin_init', [ $this, 'register_settings' ] );
		add_filter( 'plugin_action_links_' . plugin_basename( WPBOM_FILE ), [ $this, 'action_links' ] );
	}

	/**
	 * Add a Settings link on the plugins screen.
	 *
	 * @param string[] $links Existing links.
	 *
	 * @return string[]
	 */
	public function action_links( array $links ): array {
		$url = admin_url( 'edit.php?post_type=' . PostTypes::PART . '&page=' . self::PAGE_SLUG );

		array_unshift( $links, '<a href="' . esc_url( $url ) . '">' . esc_html__( 'Settings', 'wp-bom' ) . '</a>' );

		return $links;
	}

	/**
	 * Register the submenu page.
	 */
	public function add_page(): void {
		add_submenu_page(
			'edit.php?post_type=' . PostTypes::PART,
			__( 'WP BOM Settings', 'wp-bom' ),
			__( 'Settings', 'wp-bom' ),
			'manage_options',
			self::PAGE_SLUG,
			[ $this, 'render_page' ]
		);
	}

	/**
	 * Register the option and its fields.
	 */
	public function register_settings(): void {
		register_setting(
			self::OPTION,
			self::OPTION,
			[
				'type'              => 'array',
				'sanitize_callback' => [ $this, 'sanitize' ],
				'default'           => self::defaults(),
			]
		);

		add_settings_section(
			'wpbom_general',
			__( 'General', 'wp-bom' ),
			static function (): void {
				echo '<p>' . esc_html__( 'How costs are displayed and how deeply assemblies are expanded.', 'wp-bom' ) . '</p>';
			},
			self::PAGE_SLUG
		);

		$options = self::all();

		add_settings_field(
			'currency_symbol',
			__( 'Currency Symbol', 'wp-bom' ),
			static function () use ( $options ): void {
				printf(
					'<input type="text" name="%s[currency_symbol]" value="%s" class="small-text" maxlength="6" />',
					esc_attr( self::OPTION ),
					esc_attr( (string) $options['currency_symbol'] )
				);
			},
			self::PAGE_SLUG,
			'wpbom_general'
		);

		add_settings_field(
			'cost_decimals',
			__( 'Cost Decimals', 'wp-bom' ),
			static function () use ( $options ): void {
				printf(
					'<input type="number" min="0" max="6" step="1" name="%s[cost_decimals]" value="%d" class="small-text" />',
					esc_attr( self::OPTION ),
					(int) $options['cost_decimals']
				);
			},
			self::PAGE_SLUG,
			'wpbom_general'
		);

		add_settings_field(
			'max_depth',
			__( 'Maximum Explosion Depth', 'wp-bom' ),
			static function () use ( $options ): void {
				printf(
					'<input type="number" min="1" max="%d" step="1" name="%s[max_depth]" value="%d" class="small-text" />',
					(int) Explosion::MAX_DEPTH_LIMIT,
					esc_attr( self::OPTION ),
					(int) $options['max_depth']
				);
				echo '<p class="description">' . esc_html__( 'How many levels of sub-assembly to expand before stopping. Circular references are detected separately and never rely on this limit.', 'wp-bom' ) . '</p>';
			},
			self::PAGE_SLUG,
			'wpbom_general'
		);

		add_settings_field(
			'public_bom',
			__( 'Public Shortcode', 'wp-bom' ),
			static function () use ( $options ): void {
				printf(
					'<label><input type="checkbox" name="%s[public_bom]" value="1" %s /> %s</label>',
					esc_attr( self::OPTION ),
					checked( (bool) $options['public_bom'], true, false ),
					esc_html__( 'Let logged-out visitors see the [wp_bom] shortcode output.', 'wp-bom' )
				);
			},
			self::PAGE_SLUG,
			'wpbom_general'
		);
	}

	/**
	 * Sanitise the whole option array.
	 *
	 * @param mixed $input Raw submitted value.
	 *
	 * @return array<string, mixed>
	 */
	public function sanitize( mixed $input ): array {
		$input    = is_array( $input ) ? $input : [];
		$defaults = self::defaults();

		return [
			'currency_symbol' => isset( $input['currency_symbol'] ) ? substr( sanitize_text_field( (string) $input['currency_symbol'] ), 0, 6 ) : $defaults['currency_symbol'],
			'cost_decimals'   => isset( $input['cost_decimals'] ) ? min( 6, max( 0, absint( $input['cost_decimals'] ) ) ) : $defaults['cost_decimals'],
			'max_depth'       => isset( $input['max_depth'] ) ? min( Explosion::MAX_DEPTH_LIMIT, max( 1, absint( $input['max_depth'] ) ) ) : $defaults['max_depth'],
			'public_bom'      => empty( $input['public_bom'] ) ? 0 : 1,
		];
	}

	/**
	 * Render the options page.
	 */
	public function render_page(): void {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		echo '<div class="wrap">';
		echo '<h1>' . esc_html__( 'WP BOM Settings', 'wp-bom' ) . '</h1>';

		echo '<form action="options.php" method="post">';
		settings_fields( self::OPTION );
		do_settings_sections( self::PAGE_SLUG );
		submit_button();
		echo '</form>';

		echo '<hr />';
		echo '<h2>' . esc_html__( 'Shortcode', 'wp-bom' ) . '</h2>';
		echo '<p>' . esc_html__( 'Render any assembly or saved BOM on the front end:', 'wp-bom' ) . '</p>';
		echo '<p><code>[wp_bom id="123"]</code> — ' . esc_html__( 'indented tree for assembly or BOM 123.', 'wp-bom' ) . '</p>';
		echo '<p><code>[wp_bom id="123" view="flat" qty="10"]</code> — ' . esc_html__( 'summed part list for a build of ten.', 'wp-bom' ) . '</p>';
		echo '<p><code>[wp_bom id="123" view="both" totals="no"]</code> — ' . esc_html__( 'tree and flat list, without the totals strip.', 'wp-bom' ) . '</p>';

		echo '</div>';
	}
}
