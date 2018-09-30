<?php declare( strict_types=1 );
/**
 * Copyright (c) 2017.  |  Andrew Gunn
 * http://andrewgunn.org  |   https://github.com/amg262
 * andrewmgunn26@gmail.com
 *
 */

namespace WooBom;

if ( ! is_admin() ) {
	wp_die( 'You must be an admin to view this.' );
}

use function add_submenu_page;
use function esc_html_e;
use function wp_enqueue_media;

/**
 * Class WC_Bom_Settings
 *
 * @package WooBom
 */
class WC_Bom_Settings {//implements WC_Abstract_Settings {

	/**
	 * @var null
	 */
	protected static $instance;
	/**
	 * @var null
	 */
	private $worker;

	/**
	 * WC_Bom constructor.
	 */
	private function __construct() {

		$this->init();
	}

	/**
	 *
	 */
	public function init() {


		include_once __DIR__ . '/class-wc-bom-worker.php';

		$this->worker = new WC_Bom_Worker();
		add_action( 'admin_menu', [ $this, 'wc_bom_menu' ] );
		add_action( 'admin_init', [ $this, 'page_init' ] );
	}

	/**
	 * @return null
	 */
	public static function getInstance() {

		if ( ! isset( static::$instance ) ) {
			static::$instance = new static;
		}

		return static::$instance;
	}

	/**
	 *W
	 *
	 * /**
	 * Add options page
	 */
	public function wc_bom_menu() {

		add_menu_page(
			__( 'WooCommerce BOM', 'wc_bom' ),
			'Bill Materials',
			'manage_options',
			'wc-bom-settings',
			[ $this, 'settings_page' ],
			//plugins_url( 'assets/dist/images/bom30.png', WC_BOM_FILE ),
			'dashicons-clipboard',
			57
		);

		add_submenu_page(
			'wc-bom-settings',
			'Parts',
			'Parts',
			'manage_options',
			'edit.php?post_type=part'
		);

		add_submenu_page(
			'wc-bom-settings',
			'Assembly',
			'Assembly',
			'manage_options',
			'edit.php?post_type=assembly'
		);
	}

	/**
	 * Register and add settings
	 */
	public function page_init() {

		register_setting(
			'wc_bom_settings_group', // Option group
			'wc_bom_settings', // Option name
			[ $this->worker, 'sanitize' ] // Sanitize
		);

		add_settings_section(
			'wc_bom_settings_section', // ID
			'', // Title
			[ $this, 'settings_info' ], // Callback
			'wc-bom-settings-admin' // Page
		);

		add_settings_section(
			'wc_bom_setting', // ID
			'', // Title
			[ $this->worker, 'settings_callback' ], // Callback
			'wc-bom-settings-admin' // Page
		);

		register_setting(
			'wc_bom_options_group', // Option group
			'wc_bom_options', // Option name
			[ $this->worker, 'sanitize' ] // Sanitize
		);

		add_settings_section(
			'wc_bom_options_section', // ID
			'', // Title
			[ $this, 'options_info' ], // Callback
			'wc-bom-options-admin' // Page
		);

		add_settings_section(
			'wc_bom_option', // ID
			'', // Title
			[ $this->worker, 'options_callback' ], // Callback
			'wc-bom-options-admin' // Page
		);

	}

	/**
	 * Print the Section text
	 */

	/**
	 * Print the Section text
	 */
	public function settings_info() { ?>
        <div id="plugin-info-header" class="plugin-info header">
            <div class="plugin-info content">

            </div>

        </div>
	<?php }


	/**
	 * Print the Section text
	 */
	public function options_info() { ?>
        <div id="plugin-info-header" class="plugin-info header">
            <div class="plugin-info content">
                <b>sPitons</b>
            </div>

        </div>
	<?php }

	/**
	 * Options page callback
	 */
	public function settings_page() {

		global $wc_bom_options, $wc_bom_settings;
		$wc_bom_settings = get_option( WC_BOM_SETTINGS );
		$wc_bom_options  = get_option( WC_BOM_OPTIONS );

		//include_once __DIR__ . '/class-wc-bom-calculate.php';
		//$calc = new WC_Bom_Calculate();

		if ( isset( $_GET['tab'] ) ) {
			$active_tab = $_GET['tab'];
		} else {
			$active_tab = 'settings';
		}

		wp_enqueue_media(); ?>

        <div class="wrap">

            <div class="wc-bom settings-page">

                <h2><?php esc_html_e( the_title(), 'wc-bom' ); ?></h2>

                <div id="icon-themes" class="icon32">&nbps;</div>

				<?php ?>

                <h2 class="nav-tab-wrapper">
                    <a href="?page=wc-bom-settings&tab=settings" class="nav-tab
                    <?php echo $active_tab === 'settings' ? 'nav-tab-active' : ''; ?>">
                        Settings
                    </a>

                    <a href="?page=wc-bom-settings&tab=options" class="nav-tab
                    <?php echo $active_tab === 'options' ? 'nav-tab-active' : ''; ?>">
                        Options
                    </a>

                    <a href="?page=wc-bom-settings&tab=support" class="nav-tab
                    <?php echo $active_tab === 'support' ? 'nav-tab-active' : ''; ?>">
                        Support
                    </a>

                </h2>

				<?php  ?>


                <form method="post" action="options.php">
                    <div id="poststuff">

                        <div id="post-body" class="metabox-holder columns-2">

							<?php if ( $active_tab === 'settings' || $active_tab === null ) {

								settings_fields( 'wc_bom_settings_group' );
								do_settings_sections( 'wc-bom-settings-admin' );
								submit_button( 'Save Settings' );

							} else if ( $active_tab === 'options' ) {
								//echo 'hi';
								settings_fields( 'wc_bom_options_group' );
								do_settings_sections( 'wc-bom-options-admin' );
								submit_button( 'Save Options' );

							} else if ( $active_tab === 'support' ) {
							} // end if/else//wc_bom_options_group2

							//				submit_button( 'Save Options' );
							?>
                        </div>
                    </div>

                </form>

            </div>

        </div>
		<?php
	}
}
