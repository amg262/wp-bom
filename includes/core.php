<?php
/**
 * Created by PhpStorm.
 * User: mint
 * Date: 9/28/18
 * Time: 10:01 PM
 */

class WCB_Core {

	/**
	 * @var null
	 */
	protected static $instance = null;


	/**
	 * WCB_Init constructor.
	 */
	private function __construct() {

		$this->init();
	}

	/**
	 *
	 */
	protected function init() {

		if ( ! add_option( 'wc_bom_1', '' ) ) {
			update_option( 'wc_bom_1', 'true' );
		}

		$opt = get_option( 'wc_bom_1' );
		//echo json_encode( $opt );
		require __DIR__ . '/includes/class-wcb-post.php';
		require __DIR__ . '/includes/class-wcb-groups.php';
		require __DIR__ . '/includes/admin/class-wcb-settings-api.php';
		require __DIR__ . '/includes/admin/class-wcb-settings.php';

		$g = WCB_Field_Groups::getInstance();
		$t = new WeDevs_Settings_API_Test();
		//$p = WCB_Post::getInstance();

		add_action( 'init', [ $this, 'load_assets' ] );

		//add_action( 'init', [ $this, 'check_acf' ] );
		add_filter( 'plugin_action_links', [ $this, 'plugin_links' ], 10, 5 );
		register_activation_hook( __FILE__, [ $this, 'activate' ] );
		register_deactivation_hook( __FILE__, [ $this, 'deactivate' ] );

	}

	/**
	 * @return null
	 */
	public static function getInstance() {

		if ( static::$instance === null ) {
			static::$instance = new static;
		}

		return static::$instance;
	}

	/**
	 *
	 */
	public function activate() {

		flush_rewrite_rules();
	}

	/**
	 *
	 */
	public function deactivate() {

		flush_rewrite_rules();
	}

	/**
	 *
	 */
	public function load_assets() {

		wp_register_script( 'bom_adm_js', plugins_url( 'assets/wc-bom.js', __FILE__ ), [ 'jquery' ] );

		wp_enqueue_script( 'bom_adm_js' );

		wp_enqueue_script( 'sweetalertjs', 'https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js' );
		wp_enqueue_style( 'sweetalert_css', 'https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css' );

		wp_register_script( 'chosen_js', 'https://cdnjs.cloudflare.com/ajax/libs/chosen/1.7.0/chosen.jquery.min.js', [ 'jquery' ] );
		wp_register_style( 'chosen_css', 'https://cdnjs.cloudflare.com/ajax/libs/chosen/1.7.0/chosen.min.css' );
		//wp_enqueue_script( 'bom_adm_js' );
		wp_enqueue_script( 'chosen_js' );
		wp_enqueue_style( 'chosen_css' );
		//wp_enqueue_style( 'bom_css' );
	}

	/**
	 * @param $actions
	 * @param $plugin_file
	 *
	 * @return array
	 */
	public function plugin_links( $actions, $plugin_file ) {

		static $plugin;

		if ( $plugin === null ) {
			$plugin = plugin_basename( __FILE__ );
		}
		if ( $plugin === $plugin_file ) {
			$settings = [
				//edit.php?post_type=part
				'parts'    => '<a href="edit.php?post_type=part">' . __( 'Parts', 'wc-bom' ) . '</a>',
				'assembly' => '<a href="edit.php?post_type=assembly">' . __( 'Assembly', 'wc-bom' ) . '</a>',

				'settings' => '<a href="admin.php?page=wc-bill-materials">' . __( 'Settings', 'wc-bom' ) . '</a>',
			];
			$actions  = array_merge( $settings, $actions );
		}

		return $actions;
	}
}


$wcb_core = WCB_Core::getInstance();