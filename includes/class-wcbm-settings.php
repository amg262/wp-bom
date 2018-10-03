<?php
/**
 * Copyright (c) 2017.  |  Andrew Gunn
 * http://andrewgunn.org  |   https://github.com/amg262
 * andrewmgunn26@gmail.com
 *
 */

global $wcb_options;

if ( ! is_admin() ) {
	//wp_die( 'You must be an admin to view this.' );
}

/**
 * Class wcb_options
 *
 * @package WooBom
 */
class WC_Bom_Settings {//implements WC_Abstract_Settings {

	/**
	 * @var null
	 */
	protected static $instance;


	public $options = [
		'inventory'          => false,
		'vendor'             => false,
		'related_text'       => 'asdfasdf',
		'copy_part_data'     => '',
		'copy_assembly_data' => '',
		'copy_product_data'  => '',
	];

	/**
	 * WC_Bom constructor.
	 */
	public function __construct() {

		$this->init();
	}

	/**
	 *
	 */
	public function init() {

		//delete_option( WCB_OPTIONS );
		add_action( 'admin_init', [ $this, 'pre_init' ] );

		add_action( 'admin_menu', [ $this, 'wc_bom_menu' ], 99 );
		add_action( 'admin_init', [ $this, 'page_init' ] );
		add_action( 'admin_enqueue_scripts', [ $this, 'wco_admin' ] );
		add_action( 'wp_ajax_wco_ajax', [ $this, 'wco_ajax' ] );

		//add_action( 'wp_ajax_nopriv_wco_ajax', [ $this, 'wco_ajax' ] );
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

	public function pre_init() {

		global $wcb_options;

		if ( ! get_option( WCB_OPTIONS ) ) {
			add_option( WCB_OPTIONS, $this->options );
		}

		$wcb_options = get_option( WCB_OPTIONS );
	}

	/**
	 * /**
	 * Add options page
	 */
	public function wc_bom_menu() {

		add_submenu_page( 'woocommerce', 'Bill of Materials', 'Bill of Materials', 'manage_options', 'wc-bill-materials', [
			$this,
			'settings_page',
		]//,
		);

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
        </div>
      </div>
	<?php }

	/**
	 * Options page callback
	 */
	public function settings_page() {

		global $wcb_options;

		$active_tab = ( isset( $_GET['tab'] ) ) ? $_GET['tab'] : 'all';

		wp_enqueue_media(); ?>

      <div class="wrap">
        <div class="wc-bom settings-page">
          <h2><?php esc_html_e( the_title(), 'wc-bom' ); ?></h2>
          <div id="icon-themes" class="icon32">&nbps;</div>
			<?php ?>
          <h2 class="nav-tab-wrapper">
            <a id="wcrp-nav-all" href="#all" class="nav-tab
                    <?php echo $active_tab === 'all' ? 'nav-tab-active' : ''; ?>">All</a>

            <a id="wcrp-nav-settings" href="#settings" class="nav-tab
                    <?php echo $active_tab === 'settings' ? 'nav-tab-active' : ''; ?>">Settings</a>


            <a id="wcrp-nav-options" href="#options" class="nav-tab
                    <?php echo $active_tab === 'options' ? 'nav-tab-active' : ''; ?>">Options</a>

          </h2>
			<?php ?>
          <form method="post" id="wc_bom_form" action="options.php">
            <div id="poststuff">

              <div id="post-body" class="metabox-holder columns-2">
				  <?php if ( $active_tab === 'all' || $active_tab === null ) {
					  settings_fields( 'wcb_options_group' );
					  do_settings_sections( 'wcb-options-admin' );
					  submit_button( 'Save Settings' );

				  } elseif ( $active_tab === 'settings' ) {
					  settings_fields( 'wcb_options_group' );
					  do_settings_sections( 'wcb-options-admin' );
					  submit_button( 'Save Settings' );
				  } elseif ( $active_tab === 'options' ) {
					  settings_fields( 'wcb_options_group' );
					  do_settings_sections( 'wcb-options-admin' );
					  submit_button( 'Save Settings' );
				  }

				  ?>
              </div>
            </div>
          </form>
        </div>
      </div>
		<?php
	}


	/**
	 * Sanitize each setting field as needed
	 *
	 * @param array $input Contains all settings fields as array keys
	 *
	 * @return array
	 */
	public function sanitize( $input ) {

		$new_input = [];
		if ( isset( $input['inventory'] ) ) {

			$new_input['inventory'] = (bool) $input['inventory'];
		} else {
			$new_input['inventory'] = false;

		}

		if ( isset( $input['vendor'] ) ) {

			$new_input['vendor'] = (bool) ( $input['vendor'] );
		} else {
			$new_input['vendor'] = false;

		}

		if ( isset( $input['bom'] ) ) {

			$new_input['bom'] = (bool) ( $input['bom'] );
		} else {
			$new_input['bom'] = false;

		}
		if ( isset( $input['custom_category'] ) ) {

			$new_input['custom_category'] = (bool) ( $input['custom_category'] );
		} else {
			$new_input['custom_category'] = false;

		}

		if ( isset( $input['custom_tags'] ) ) {

			$new_input['custom_tags'] = (bool) ( $input['custom_tags'] );
		} else {
			$new_input['custom_tags'] = false;

		}
		if ( isset( $input['category_name'] ) ) {
			$new_input['category_name'] = sanitize_text_field( $input['category_name'] );

		}

		if ( isset( $input['category_single'] ) ) {
			$new_input['category_single'] = sanitize_text_field( $input['category_single'] );

		}
		if ( isset( $input['category_menu'] ) ) {
			$new_input['category_menu'] = sanitize_text_field( $input['category_menu'] );

		}
		if ( isset( $input['tags_name'] ) ) {
			$new_input['tags_name'] = sanitize_text_field( $input['tags_name'] );

		}

		if ( isset( $input['tags_single'] ) ) {
			$new_input['tags_single'] = sanitize_text_field( $input['tags_single'] );

		}
		if ( isset( $input['tags_menu'] ) ) {
			$new_input['tags_menu'] = sanitize_text_field( $input['tags_menu'] );

		}

		if ( isset( $input['related_text'] ) ) {
			$new_input['related_text'] = sanitize_text_field( $input['related_text'] );
		}

		if ( isset( $input['copy_part_data'] ) ) {
			$new_input['copy_part_data'] = absint( $input['copy_part_data'] );
		}

		if ( isset( $input['copy_assembly_data'] ) ) {
			$new_input['copy_assembly_data'] = absint( $input['copy_assembly_data'] );
		}

		if ( isset( $input['copy_product_data'] ) ) {
			$new_input['copy_product_data'] = absint( $input['copy_product_data'] );
		}

		if ( isset( $input['prod_bom'] ) ) {
			$new_input['prod_bom'] = absint( $input['prod_bom'] );
		}


		return $new_input;

		//return $input;
	}

	/**
	 * Get the settings option array and print one of its values
	 */
	public function settings_callback() {

		global $wcb_options;
		// Enqueue Media Library Use
		wp_enqueue_media(); ?>
      <div id="postbox-container-1" class="postbox-container">

        <div id="normal-sortables" class="meta-box-sortables">

          <div id="postbox" class="postbox">

            <button type="button" class="handlediv button-link" aria-expanded="true">
              <span class="screen-reader-text">Toggle panel: General</span>
              <span class="toggle-indicator" aria-hidden="true"></span>
            </button>
            <h2 class='hndle'><span>General</span></h2>

            <div class="inside ">
              Update the fields
            </div>
            <div id="major-publishing-actions">
              <div id="publishing-action">
                <span class="spinner"></span>
                <input type="submit" accesskey="p" value="Update"
                       class="button button-primary button-large"
                       id="publish" name="publish">
                <button class="button button-secondary button-large">
                  Reset
                </button>
              </div>
              <div class="clear"></div>
            </div>
          </div>
        </div>
      </div>
      <div id="postbox-container-2" class="postbox-container">
        <div id="normal-sortables" class="meta-box-sortables">
          <div id="postbox" class="postbox">
            <button type="button" class="handlediv button-link" aria-expanded="true">
              <span class="screen-reader-text">Toggle panel: General</span>
              <span class="toggle-indicator" aria-hidden="true"></span>
            </button>
            <h2 class='hndle'><span>General</span></h2>
            <div class="inside acf-fields -left">
				<?php settings_errors(); ?>
				<?php $this->settings_fields(); ?>
            </div>
          </div>
        </div>
      </div>
	<?php }

	/**
	 * @return string
	 */
	protected function settings_fields() {

		global $wcb_options, $wcb_data;

		var_dump( $wcb_options );
		var_dump( $wcb_data );

		?>

      <div id="wcrp-settings">
        <table class="form-table">
          <tbody>

          <h1>Post Types & Categories</h1>
          <tr>
			  <?php $label = 'Inventory';
			  $key         = $this->format_key( $label );
			  $id          = WCB_PREFIX . $key;
			  ?>
            <th scope="row"><label for="<?php _e( $id ); ?>"><?php _e( $label ); ?></label></th>
            <td><input type="checkbox" id="<?php _e( $id ); ?>"
                       title="<?php _e( $id ); ?>"
                       class="wcb_cb"
                       name="wcb_options[<?php _e( $key ); ?>]"
                       value="1"<?php checked( 1, $wcb_options[ $key ], true ); ?> /></td>
          </tr>

          <tr>
			  <?php $label = 'Vendor';
			  $key         = $this->format_key( $label );
			  $id          = WCB_PREFIX . $key;

			  ?>
            <th scope="row"><label for="<?php _e( $id ); ?>"><?php _e( $label ); ?></label></th>
            <td><input type="checkbox" id="<?php _e( $id ); ?>"
                       title="<?php _e( $id ); ?>"
                       class="wcb_cb"

                       name="wcb_options[<?php _e( $key ); ?>]"
                       value="1"<?php checked( 1, $wcb_options[ $key ], true ); ?> /></td>
          </tr>

          <tr>
			  <?php $label = 'BOM';
			  $key         = $this->format_key( $label );
			  $id          = WCB_PREFIX . $key;
			  ?>
            <th scope="row"><label for="<?php _e( $id ); ?>"><?php _e( $label ); ?></label></th>
            <td><input type="checkbox" id="<?php _e( $id ); ?>"
                       title="<?php _e( $id ); ?>"
                       class="wcb_cb"

                       name="wcb_options[<?php _e( $key ); ?>]"
                       value="1"<?php checked( 1, $wcb_options[ $key ], true ); ?> /></td>
          </tr>


          <tr>
			  <?php
			  $type = 'Category';

			  $label = 'Custom ' . $type;
			  $key   = $this->format_key( $label );
			  $id    = WCB_PREFIX . $key;
			  ?>
            <th scope="row"><label for="<?php _e( $id ); ?>"><?php _e( $label ); ?></label></th>
            <td><input type="checkbox" id="<?php _e( $id ); ?>"
                       title="<?php _e( $id ); ?>"
                       class="wcb_cb"

                       name="wcb_options[<?php _e( $key ); ?>]"
                       value="1"<?php checked( 1, $wcb_options[ $key ], true ); ?> />

				<?php $label = $type . ' Name';
				$key         = $this->format_key( $label );
				$id          = WCB_PREFIX . $key; ?>
              <input type="text"
                     title="<?php _e( $id ); ?>"
                     id="<?php _e( $id ); ?>"
                     class="wcb_custom_cat _cat"
                     name="wcb_options[<?php _e( $key ); ?>]"
                     value="<?php echo $wcb_options[ $key ]; ?>"/>

				<?php $label = $type . ' Single';
				$key         = $this->format_key( $label );
				$id          = WCB_PREFIX . $key; ?>
              <input type="text"
                     title="<?php _e( $id ); ?>"
                     id="<?php _e( $id ); ?>"
                     class="wcb_custom_cat _cat"

                     name="wcb_options[<?php _e( $key ); ?>]"
                     value="<?php echo $wcb_options[ $key ]; ?>"/>

				<?php $label = $type . ' Menu';
				$key         = $this->format_key( $label );
				$id          = WCB_PREFIX . $key; ?>
              <input type="text"
                     title="<?php _e( $id ); ?>"
                     id="<?php _e( $id ); ?>"
                     class="wcb_custom_cat _cat"

                     name="wcb_options[<?php _e( $key ); ?>]"
                     value="<?php echo $wcb_options[ $key ]; ?>"/>

            </td>

          </tr>
          <tr>
			  <?php
			  $type  = 'Tags';
			  $label = 'Custom ' . $type;
			  $key   = $this->format_key( $label );
			  $id    = WCB_PREFIX . $key;
			  ?>
            <th scope="row"><label for="<?php _e( $id ); ?>"><?php _e( $label ); ?></label></th>
            <td><input type="checkbox" id="<?php _e( $id ); ?>"
                       title="<?php _e( $id ); ?>"
                       class="wcb_cb"

                       name="wcb_options[<?php _e( $key ); ?>]"
                       value="1"<?php checked( 1, $wcb_options[ $key ], true ); ?> />

				<?php $label = $type . ' Name';
				$key         = $this->format_key( $label );
				$id          = WCB_PREFIX . $key; ?>
              <input type="text"
                     title="<?php _e( $id ); ?>"
                     id="<?php _e( $id ); ?>"
                     class="wcb_custom_tag _tag"
                     name="wcb_options[<?php _e( $key ); ?>]"
                     value="<?php echo $wcb_options[ $key ]; ?>"/>

				<?php $label = $type . ' Name';
				$key         = $this->format_key( $label );
				$id          = WCB_PREFIX . $key; ?>
              <input type="text"
                     title="<?php _e( $id ); ?>"
                     id="<?php _e( $id ); ?>"
                     class="wcb_custom_tag _tag"

                     name="wcb_options[<?php _e( $key ); ?>]"
                     value="<?php echo $wcb_options[ $key ]; ?>"/>

				<?php $label = $type . ' Name';
				$key         = $this->format_key( $label );
				$id          = WCB_PREFIX . $key; ?>
              <input type="text"
                     title="<?php _e( $id ); ?>"
                     id="<?php _e( $id ); ?>"
                     class="wcb_custom_tag _tag"

                     name="wcb_options[<?php _e( $key ); ?>]"
                     value="<?php echo $wcb_options[ $key ]; ?>"/>

            </td>

          </tr>


          <tr><?php $label = 'Related Text';
			  $key         = $this->format_key( $label );
			  $id          = WCB_PREFIX . $key;
			  ?>
            <th scope="row"><label for="<?php _e( $id ); ?>"><?php _e( $label ); ?></label></th>
            <td>
              <input type="text"
                     title="<?php _e( $id ); ?>"
                     id="<?php _e( $id ); ?>"
                     name="wcb_options[<?php _e( $key ); ?>]"
                     value="<?php echo $wcb_options[ $key ]; ?>"/>
            </td>
          </tr>


          </tbody>
        </table>
      </div>


      <div id="wcrp-options">
        <table class="form-table">
          <h1></h1>
          <tbody>

		  <?php $label = 'Copy Part Data';
		  $key         = $this->format_key( $label );
		  $id          = WCB_PREFIX . $key;
		  ?>
          <tr>
            <th>
              <span class="button primary" id="button_hit" name="part_button_hit">Generate</span>
            </th>
            <td>
              <select id="<?php _e( $key ); ?>"
                      name="wcb_options[<?php _e( $key ); ?>]"
                      data-placeholder="Select Product" value="wcb_options[<?php _e( $key ); ?>]"
                      class="prod-select wc_bom_select chosen-select">
				  <?php _e( $this->build_select_options( $wcb_options[ $key ], [
					  'part',
				  ] ), 'wc-related-products' ); ?>
              </select>
            </td>
          </tr>


		  <?php $label = 'Copy Assembly Data';
		  $key         = $this->format_key( $label );
		  $id          = WCB_PREFIX . $key;
		  ?>
          <tr>
            <th>
              <span class="button primary" id="button_hit" name="button_hit">Generate</span>
            </th>
            <td>
              <select id="<?php _e( $key ); ?>"
                      name="wcb_options[<?php _e( $key ); ?>]"
                      data-placeholder="Select Product" value="wcb_options[<?php _e( $key ); ?>]"
                      class="prod-select wc_bom_select chosen-select">
				  <?php _e( $this->build_select_options( $wcb_options[ $key ], [ 'assembly' ] ), 'wc-related-products' ); ?>
              </select>
            </td>
          </tr>

		  <?php $label = 'Copy Product Data';
		  $key         = $this->format_key( $label );
		  $id          = WCB_PREFIX . $key;
		  ?>
          <tr>
            <th>
              <span class="button primary" id="button_hit" name="button_hit">Generate</span>
            </th>
            <td>
              <select id="<?php _e( $key ); ?>"
                      name="wcb_options[<?php _e( $key ); ?>]"
                      data-placeholder="Select Product" value="wcb_options[<?php _e( $key ); ?>]"
                      class="prod-select wc_bom_select chosen-select">
				  <?php _e( $this->build_select_options( $wcb_options[ $key ], [ 'product' ] ), 'wc-related-products' ); ?>
              </select>
            </td>
          </tr>


          <tr><?php $label = 'Prod Bom';
			  $key         = $this->format_key( $label );
			  $id          = WCB_PREFIX . $key;
			  ?>
            <th scope="row"><label for="<?php _e( $id ); ?>"><?php _e( $label ); ?></label></th>
            <td>
              <input type="hidden" id="<?php echo $id; ?>" name="wcb_options[<?php echo $key; ?>]"
                     value="<?php echo $wcb_options[ $key ]; ?>"/>

              <span id="<?php echo 'wcb_' . $id; ?>"
                    name="<?php echo $key; ?>"
                    value="<?php echo $key; ?>">
                            Output
                        </span>
            </td>
          </tr>


          </tbody>
        </table>
      </div>
		<?php

		return 'hi';
	}

	/**
	 * @param $text
	 *
	 * @return string
	 */
	public function format_key( $text ) {

		$str   = str_replace( [ '-', ' ' ], '_', $text );
		$lower = strtolower( $str );

		//	$this->option_keys[] = $lower;


		return $lower;
	}

	/**
	 * @param $data
	 *
	 * @return string
	 */
	public function build_select_options( $data, $post_type ) {

		$option = '';

		echo $post_type;


		//var_dump( $data );
		foreach ( $post_type as $type ) {

			//  $option .= '<strong><option>'. strtoupper($type).'</option></strong>';
			foreach ( $this->get_data( $type ) as $arr ) {

				//var_dump( $arr );
				if ( $data == $arr['id'] ) {
					$selected = 'selected="selected"';
				} else {
					$selected = '';
				}
				$option .= '<option id="' . $arr['id'] . '" value="' . $arr['id'] . '" ' . $selected . '">' . substr( $arr['text'], 0, 40 ) . '</option>';
			}
		}

		return $option;
	}

	/**
	 * @return array
	 */
	public function get_data( $post_type ) {

		//var_dump( $post_type );
		$args = [
			'post_type'      => $post_type,
			'post_status'    => 'publish',
			'posts_per_page' => - 1,
			'orderby'        => 'title',
			'order'          => 'ASC',

		];

		$out   = [];
		$posts = get_posts( $args );


		foreach ( $posts as $p ) {
			$out[] = [ 'id' => $p->ID, 'text' => $p->post_title ];
		}
		$json = json_encode( $out );

		return $out;
	}


	/**
	 *
	 */
	public function wco_admin() {

		global $wcb_options;
		$ajax_data = $this->get_data( 'product' );
		$settings  = $wcb_options;
		$opts      = $wcb_options;
		$p         = $opts['copy_product_data'];


		$ajax_object = [
			'ajax_url'  => admin_url( 'admin-ajax.php' ),
			'nonce'     => wp_create_nonce( 'ajax_nonce' ),
			'product'   => $wcb_options['copy_product_data'],
			'part'      => $wcb_options['copy_part_data'],
			'action'    => [ $this, 'wco_ajax' ], //'options'  => 'wc_bom_option[opt]',
			'ajax_data' => $p,
			'settings'  => $wcb_options,
			'options'   => $this->options,
			'prod_bom'  => $wcb_options['prod_bom'],
		];
		wp_localize_script( 'bom_adm_js', 'ajax_object', $ajax_object );
	}


	public function save_part_db() {

		$part = $_POST['part'];

		$post = get_post( $part );

		$part_no = get_post_meta( $post->ID, 'part_no', true );

		$sku    = get_post_meta( $post->ID, 'sku', true );
		$cost   = get_post_meta( $post->ID, 'cost', true );
		$weight = get_post_meta( $post->ID, 'weight', true );
		$stock  = get_post_meta( $post->ID, 'stock', true );


		$this->install_part_data( $post->ID, $part_no, $sku, $cost, $weight, $stock, 'data' );


		$arg = [];
		$in  = $_POST['input'];


		var_dump( $in );
		update_option( 'wcb_options', $in );


		var_dump( get_option( 'wcb_options' ) );
		echo $in;


	}

	/**
	 *
	 */
	public function wco_ajax() {

		//global $wpdb;
		check_ajax_referer( 'ajax_nonce', 'security' );
		if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
		}

		$product = (int) $_POST['product'];


		$meta = get_post_meta( $product, '_sku' );


		$part = (int) $_POST['part'];
		//include_once __DIR__.'/class-wcbm-bom.php';

		//$a = new WC_Bom_Builder();
		//$a->dothis($product);

		if ( isset( $part ) ) {
			include_once __DIR__ . '/class-wcbm-part.php';

			$p = new WCB_Part();
			$m = $p->get_part_data( $part );

			//echo $m;
		} else {

			$p         = get_post( $product );
			$parrr_arr = [];
			$ass4_arr  = [];
			$asss5_arr = [];
			$parr_arr  = [];
			$ass_arr   = [];
			$asss_arr  = [];
			$par_arr   = [];
			$po        = get_post_meta( $p->ID );
			if ( have_rows( 'product_assembly', $p->ID ) ) {

				$i = 0;
				while ( have_rows( 'product_assembly', $p->ID ) ) : the_row();
					$i ++;

					$ass = get_sub_field( 'assembly' );
					$qty = get_sub_field( 'qty' );

					//$ark[] = ['']
					$pos = get_post( $ass );

					if ( $pos->post_type === 'assembly' ) {
						if ( have_rows( 'assembly_items', $pos->ID ) ) {

							while ( have_rows( 'assembly_items', $pos->ID ) ) : the_row();
								$ass2 = get_sub_field( 'item' );
								$qty2 = get_sub_field( 'qty' );

								$asss      = get_post( $ass2 );
								$ass_arr[] = [
									'ID'      => $pos->ID,
									'assemby' => $ass2,
									'type'    => $asss->post_type,
									'qty'     => $qty2,
								];

								if ( $asss->post_type === 'part' ) {
									$par_arr[] = $asss->ID;
								} elseif ( $asss->post_type === 'assembly' ) {
									while ( have_rows( 'assembly_items', $asss->ID ) ) : the_row();
										$asss2 = get_sub_field( 'item' );
										$qtyy2 = get_sub_field( 'qty' );

										$asss3      = get_post( $asss2 );
										$asss_arr[] = [
											'ID'      => $asss->ID,
											'assemby' => $asss2,
											'type'    => $asss3->post_type,
											'qty'     => $qtyy2,
										];

										if ( $asss3->post_type === 'part' ) {
											$parr_arr[] = $asss3->ID;
										} elseif ( $asss3->post_type === 'assembly' ) {
											echo 'shit';

											/*while ( have_rows( 'assembly_items', $asss3->ID ) ) : the_row();
												$asss32 = get_sub_field( 'item' );
												$qtyy32 = get_sub_field( 'qty' );

												$asss33      = get_post( $asss2 );
												$asss_arr[] = [
													'ID'      => $asss3->ID,
													'assemby' => $asss32,
													'type'    => $asss33->post_type,
													'qty'     => $qtyy32,
												];

												if ( $asss33->post_type === 'part' ) {
													$parrr_arr[] = $asss33->ID;
												} elseif ( $asss33->post_type === 'assembly' ) {
													echo 'shit';



												}

											endwhile;*/

										}

									endwhile;
								}

							endwhile;

						}
					}

					echo $ass . '<br>' . $qty;
					//get_sub_field('assembl')
				endwhile;
			}
		}

		$arg = [];
		$set = $_POST['settings'];
		$in  = $_POST['input'];


		echo 'input- ';
		//var_dump( $in );

		$id = $m['id'];

		$part_id = (int) $_POST['part'];

		$pa   = get_post( $part_id );
		$id   = $pa->ID;
		$type = $pa->post_type;
		var_dump( $m );

		$this->install_data( 'name', $id, $type, '', json_encode( $m ) );

		var_dump( $in );
		update_option( 'wcb_options', $in );


		var_dump( get_option( 'wcb_options' ) );
		echo $in;
		/*echo json_encode( $parrr_arr );
		echo '<br><hr><br>';
		echo json_encode( $parr_arr );
		echo '<br><hr><br>';
		echo json_encode( $asss_arr );
		echo '<br><hr><br>';
		echo json_encode( $ass_arr );
		echo '<br><hr><br>';
		echo json_encode( $par_arr );*/
		//echo json_encode( $par_arr );
		//var_dump( get_option( 'wcb_options' ) );
		//echo json_decode( $set );

		//echo json_encode( get_option( 'wcb_options' ) );
		//echo 'ZIP - ' . $i . ' <br>';
		//

		wp_die( 'Ajax finished.' );
	}

	/**
	 *
	 */
	public function install_assembly_data( $post_id, $assembly_id, $revision, $part_ids, $sub_ids, $data ) {

		global $wpdb;

		$table_name = $wpdb->prefix . 'wcbm_assembly';


		$wpdb->insert( $table_name, [
			'post_id'     => $post_id,
			'assembly_id' => $assembly_id,
			'revision'    => $revision,
			'part_ids'    => $part_ids,
			'sub_ids'     => $sub_ids,
			'data'        => $data,
			'time'        => current_time( 'mysql' ),
			'active'      => - 1,
		] );
	}

	/**
	 *
	 */
	public function install_data( $title, $post_id, $type, $sub_ids, $data ) {

		global $wpdb;

		$table_name = $wpdb->prefix . WCB_TBL;

		$wpdb->insert( $table_name, [
			'title'   => $title,
			'post_id' => $post_id,
			'type'    => $type,
			'sub_ids' => $sub_ids,
			'data'    => $data,
			'time'    => current_time( 'mysql' ),
			'active'  => - 1,
		] );
	}

	/**
	 *
	 */
	public function install_part_data( $post_id, $part_no, $sku, $cost, $weight, $stock, $data ) {

		global $wpdb;

		$table_name = $wpdb->prefix . 'wcbm_part';


		$wpdb->insert( $table_name, [
			'post_id' => $post_id,
			'part_no' => $part_no,
			'sku'     => $sku,
			'cost'    => $cost,
			'weight'  => $weight,
			'stock'   => $stock,
			'data'    => $data,
			'time'    => current_time( 'mysql' ),
			'active'  => - 1,
		] );
	}
}
