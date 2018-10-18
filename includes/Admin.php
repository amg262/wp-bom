<?php
/**
 * WP-Reactivate
 *
 *
 * @package   WP-Reactivate
 * @author    Pangolin
 * @license   GPL-3.0
 * @link      https://gopangolin.com
 * @copyright 2017 Pangolin (Pty) Ltd
 */

namespace Netraa\WPB;

use WP_User;

/**
 * @subpackage Admin
 */
class Admin {

	/**
	 * Instance of this class.
	 *
	 * @since    1.0.0
	 *
	 * @var      object
	 */
	protected static $instance = null;

	/**
	 * Plugin basename.
	 *
	 * @since    1.0.0
	 *
	 * @var      string
	 */
	protected $plugin_basename = null;

	/**
	 * Slug of the plugin screen.
	 *
	 * @since    1.0.0
	 *
	 * @var      string
	 */
	protected $plugin_screen_hook_suffix = null;


	/**
	 * Return an instance of this class.
	 *
	 * @since     1.0.0
	 *
	 * @return    object    A single instance of this class.
	 */
	public static function get_instance() {

		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
			self::$instance->do_hooks();
		}

		return self::$instance;
	}

	/**
	 * Initialize the plugin by loading admin scripts & styles and adding a
	 * settings page and menu.
	 *
	 * @since     1.0.0
	 */
	private function __construct() {
		$plugin            = Plugin::get_instance();
		$this->plugin_slug = $plugin->get_plugin_slug();
		$this->version     = $plugin->get_plugin_version();

		$this->plugin_basename = plugin_basename( plugin_dir_path( realpath( dirname( __FILE__ ) ) ) . $this->plugin_slug . '.php' );
	}


	/**
	 * Handle WP actions and filters.
	 *
	 * @since    1.0.0
	 */
	private function do_hooks() {
		// Load admin style sheet and JavaScript.
		add_action( 'admin_init', [ $this, 'page_init' ] );
		add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_admin_styles' ] );
		add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_admin_scripts' ] );

		// Add the options page and menu item.
		add_action( 'admin_menu', [ $this, 'add_plugin_admin_menu' ] );

		// Add plugin action link point to settings page
		add_filter( 'plugin_action_links_' . $this->plugin_basename, [ $this, 'plugin_links' ] );
		//add_filter( 'plugin_action_links', [ $this, 'plugin_links' ], 10, 5 );
		add_action( 'admin_enqueue_scripts', [ $this, 'wco_admin' ] );

		add_action( 'admin_enqueue_scripts', [ $this, 'wco_admin' ] );
		add_action( 'wp_ajax_wco_ajax', [ $this, 'wco_ajax' ] );

		//add_action( 'wp_ajax_nopriv_wco_ajax', [ $this, 'wco_ajax' ] );

	}

	/**
	 * Register and enqueue admin-specific style sheet.
	 *
	 * @since     1.0.0
	 *
	 * @return    null    Return early if no settings page is registered.
	 */
	public function enqueue_admin_styles() {
		if ( ! isset( $this->plugin_screen_hook_suffix ) ) {
			return;
		}
		$screen = get_current_screen();
		if ( $this->plugin_screen_hook_suffix == $screen->id ) {
			wp_enqueue_style( $this->plugin_slug . '-style', plugins_url( 'assets/css/admin.css', dirname( __FILE__ ) ), [], $this->version );
		}
	}

	/**
	 * Register and enqueue admin-specific javascript
	 *
	 * @since     1.0.0
	 *
	 * @return    null    Return early if no settings page is registered.
	 */
	public function enqueue_admin_scripts() {
		if ( ! isset( $this->plugin_screen_hook_suffix ) ) {
			return;
		}
		$ajax_object = [
			'ajax_url' => admin_url( 'admin-ajax.php' ),
			'nonce'    => wp_create_nonce( 'wp_bom_admin' ),
			'product'  => get_option( 'wcb_options' ),
			'action'   => [ $this, 'wco_ajax' ], //'options'  => 'wc_bom_option[opt]',
		];


		$screen = get_current_screen();
		if ( $this->plugin_screen_hook_suffix == $screen->id ) {

			wp_enqueue_script( $this->plugin_slug . '-admin-script', plugins_url( 'assets/js/admin.js', dirname( __FILE__ ) ), [ 'jquery' ], $this->version );
			wp_enqueue_script( $this->plugin_slug . '-admin-js', plugins_url( 'assets/js/wp-bom-admin.js', dirname( __FILE__ ) ), [ 'jquery' ], $this->version );


			wp_localize_script( $this->plugin_slug . '-admin-js', 'wp_bom_admin', $ajax_object );

			wp_localize_script( $this->plugin_slug . '-admin-script', 'wpb_object', [
					'api_nonce' => wp_create_nonce( 'wp_rest' ),
					'api_url'   => rest_url( $this->plugin_slug . '/v1/' ),
				]
			);
		}
	}

	/**
	 * Register the administration menu for this plugin into the WordPress Dashboard menu.
	 *
	 * @since    1.0.0
	 */
	public function add_plugin_admin_menu() {
		/*
		 * Add a settings page for this plugin to the Settings menu.
		 */
//		$this->plugin_screen_hook_suffix = add_options_page(
//			__( 'WP Reactivate', $this->plugin_slug ),
//			__( 'WP Reactivate', $this->plugin_slug ),
//			'manage_options',
//			$this->plugin_slug,
//			[ $this, 'display_plugin_admin_page' ]
//		);

		$this->plugin_screen_hook_suffix = add_menu_page( 'WP BOM', 'WP BOM', 'manage_options', $this->plugin_slug, [
			$this,
			'display_plugin_admin_page',
		], 'dashicons-schedule', 60 );
	}

	/**
	 * Register and add settings
	 */
	public function page_init() {

		register_setting( 'wcb_options_group', // Option group
			'wcb_options', // Option name
			[ $this, 'sanitize' ] // Sanitize
		);

		add_settings_section( 'wcb_options_section', // ID
			'', // Title
			[ $this, 'settings_info' ], // Callback
			'wcb-options-admin' // Page
		);

		add_settings_section( 'wcb_option', // ID
			'', // Title
			[ $this, 'settings_callback' ], // Callback
			'wcb-options-admin' // Page
		);

	}

	/**
	 * Print the Section text
	 */
	public function settings_info() { ?>
        <div id="plugin-info-header" class="plugin-info header">
            <div class="plugin-info content">
                <h2>WP Bom</h2>
            </div>
        </div>
	<?php }


	public function settings_callback() {
		$wcb_options = get_option( 'wcb_options' );

		?>
        <table class="form-table">
            <tbody>
            <tr><?php $label = 'Sdf';
				$key         = $this->format_key( $label );
				$id          = $key; ?>

                <th scope="row"><label for="<?php _e( $id ); ?>"><?php _e( $label ); ?></label></th>
                <td><input type="checkbox" id="<?php _e( $id ); ?>"
                           title="<?php _e( $id ); ?>"
                           class="wcb_cb"
                           name="wcb_options[<?php _e( $key ); ?>]"
                           value="1"<?php checked( 1, $wcb_options[ $key ], true ); ?> /></td>
            </tr>

            <tr><?php $label = 'Email';
				$key         = $this->format_key( $label );
				$id          = $key; ?>

                <th scope="row"><label for="<?php _e( $id ); ?>"><?php _e( $label ); ?></label></th>
                <td>
                    <input type="text"
                           title="<?php _e( $id ); ?>"
                           id="<?php _e( $id ); ?>"
                           placeholder="<?php if ( ! isset( $wcb_options[ $key ] ) ) {
						       $user = new WP_User( get_current_user_id() );
						       echo $user->user_email;
					       } else {
						       echo $wcb_options[ $key ];
					       } ?>"
                           name="wcb_options[<?php _e( $key ); ?>]"
                           value="<?php echo $wcb_options[ $key ]; ?>"/>
                </td>
            </tr>

            <tr><?php $label = 'Key';
				$key         = $this->format_key( $label );
				$id          = $key; ?>

                <th scope="row"><label for="<?php _e( $id ); ?>"><?php _e( $label ); ?></label></th>
                <td>
                    <input type="password"
                           title="<?php _e( $id ); ?>"
                           id="<?php _e( $id ); ?>"
                           placeholder="<?php if ( ! isset( $wcb_options[ $key ] ) ) {
						       $user = new WP_User( get_current_user_id() );
						       echo $user->user_email;
					       } else {
						       echo $wcb_options[ $key ];
					       } ?>"
                           name="wcb_options[<?php _e( $key ); ?>]"
                           value="<?php echo $wcb_options[ $key ]; ?>"/>
                </td>
            </tr>
            <tr><?php $label = 'Key';
	            $key         = $this->format_key( $label );
	            $id          = $key; ?>

                <th scope="row"><label for="<?php _e( $id ); ?>"><?php _e( $label ); ?></label></th>
                <td>
                    <input type="password"
                           title="<?php _e( $id ); ?>"
                           id="<?php _e( $id ); ?>"
                           placeholder="<?php if ( ! isset( $wcb_options[ $key ] ) ) {
			                   $user = new WP_User( get_current_user_id() );
			                   echo $user->user_email;
		                   } else {
			                   echo $wcb_options[ $key ];
		                   } ?>"
                           name="wcb_options[<?php _e( $key ); ?>]"
                           value="<?php echo $wcb_options[ $key ]; ?>"/>
                </td>
            </tr>
            <tr>
				<?php

				echo '<h1>' . $wcb_options['key'] . '</h1>';
				echo '<h1>' . md5( $wcb_options['key'] ) . '</h1>';
				echo '<h1>' . $wcb_options['key'] . '</h1>';


				?>

                <th>
                    <span id="wpb_admin_ajax" name="wpb_admin_ajax" class="button-primary">Button</span>
                    <span id="wpb_ajax_io" name="wpb_ajax_io">Heyo</span>
                </th>
            </tr>
            </tbody>
        </table>
	<?php }


	public function setting_element( $args ) {


		$defaults = [
			'type'  => 'text',
			'label' => "",
			'key'   => "",
			'id'    => "",
			'value' => "",
		];

		/**
		 * Parse incoming $args into an array and merge it with $defaults
		 */
		$args = wp_parse_args( $args, $defaults );
	}

	public function html_elements() {

		$settings = [


		];

	}

	public function sanitize( $input ) {

		$new_input = [];


		if ( isset( $input['key'] ) ) {
			echo '<h1>' . $input['key'] . '</h1>';
		}

		return $input;

		//return $input;
	}

	/**
	 * Render the settings page for this plugin.
	 *
	 * @since    1.0.0
	 */
	public function display_plugin_admin_page() { ?>
        <div class="wrap">
            <div id="wp-reactivate-admin"><h1>Hello</h1></div>
            <form method="post" id="wc_bom_form" action="options.php">
				<?php
				settings_fields( 'wcb_options_group' );
				do_settings_sections( 'wcb-options-admin' );
				submit_button( 'Save Settings' );
				?>
            </form>
        </div>
	<?php }

	/**
	 * @param $text
	 *
	 * @return string
	 */
	protected function format_key( $text ) {
		return strtolower( str_replace( [ '-', ' ' ], '_', $text ) );
	}

	/**
	 * @param $data
	 *
	 * @return string
	 */
	public function build_select_options( $data, $post_type ) {

//		$option = '';
//
//		echo $post_type;
//
//
//		//var_dump( $data );
//		foreach ( $post_type as $type ) {
//
//			//  $option .= '<strong><option>'. strtoupper($type).'</option></strong>';
//			foreach ( $this->get_data( $type ) as $arr ) {
//
//				//var_dump( $arr );
//				if ( $data == $arr['id'] ) {
//					$selected = 'selected="selected"';
//				} else {
//					$selected = '';
//				}
//				$option .= '<option id="' . $arr['id'] . '" value="' . $arr['id'] . '" ' . $selected . '">' . substr( $arr['text'], 0, 40 ) . '</option>';
//			}
//		}
//
//		return $option;
	}

	/**
	 *
	 */
	public function wco_admin() {

		$opts = get_option( 'wcb_options' );
		//$ajax_data = $this->get_data( 'product' );


		$ajax_object = [
			'ajax_url' => admin_url( 'admin-ajax.php' ),
			'nonce'    => wp_create_nonce( 'wp_bom_admin' ),
			'product'  => get_option( 'wcb_options' ),
			'action'   => [ $this, 'wco_ajax' ], //'options'  => 'wc_bom_option[opt]',
		];

		wp_enqueue_script( $this->plugin_slug . '-admin-js', plugins_url( 'assets/js/wp-bom-admin.js', dirname( __FILE__ ) ), [ 'jquery' ], $this->version );


		wp_localize_script( $this->plugin_slug . '-admin-js', 'wp_bom_admin', $ajax_object );
	}

	/**
	 *
	 */
	public function wco_ajax() {

		//global $wpdb;
		check_ajax_referer( 'ajax_nonce', 'security' );
		if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
		}

		$product = $_POST['product'];


		wp_die( 'Ajax finished.' );
	}

	/**
	 * Add settings action link to the plugins page.
	 *
	 * @since    1.0.0
	 */
	public function add_action_links( $links ) {
		return array_merge(
			[
				'settings' => '<a href="' . admin_url( 'options-general.php?page=' . $this->plugin_slug ) . '">' . __( 'Settings',
						$this->plugin_slug ) . '</a>',
			],
			$links
		);
	}

	/**
	 * @param $actions
	 * @param $plugin_file
	 *
	 * @return array
	 */
	public function plugin_links( $links ) {

		$settings = [
			'settings' => '<a href="' . admin_url( 'options-general.php?page=' . $this->plugin_slug ) . '">' . __( 'Settings',
					$this->plugin_slug ) . '</a>',
			'parts'    => '<a href="edit.php?post_type=part">' . __( 'Parts', 'wp-bom' ) . '</a>',
			'assembly' => '<a href="edit.php?post_type=assembly">' . __( 'Assembly', 'wp-bom' ) . '</a>',
			'options'  => '<a href="admin.php?page=wp-bom-settings">' . __( 'Options', 'wp-bom' ) . '</a>',
		];
		$actions  = array_merge( $settings, $links );

		return $actions;
	}


}
