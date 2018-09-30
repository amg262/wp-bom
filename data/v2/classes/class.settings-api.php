<?php

/**
 * weDevs Settings API wrapper class
 *
 * @version 1.2 (18-Oct-2015)
 *
 * @author  Tareq Hasan <tareq@weDevs.com>
 * @link    http://tareq.weDevs.com Tareq's Planet
 * @example src/settings-api.php How to use the class
 */
if ( ! class_exists( 'WeDevs_Settings_API' ) ):
	class WeDevs_Settings_API {

		/**
		 * settings sections array
		 *
		 * @var array
		 */
		protected $settings_sections = [];

		/**
		 * Settings fields array
		 *
		 * @var array
		 */
		protected $settings_fields = [];

		public function __construct() {
			add_action( 'admin_enqueue_scripts', [ $this, 'admin_enqueue_scripts' ] );
			add_action( 'admin_enqueue_scripts', [ $this, 'wco_admin' ] );
			add_action( 'wp_ajax_wco_ajax', [ $this, 'wco_ajax' ] );
		}

		/**
		 * Enqueue scripts and styles
		 */
		function admin_enqueue_scripts() {
			wp_enqueue_style( 'wp-color-picker' );

			wp_enqueue_media();
			wp_enqueue_script( 'wp-color-picker' );
			wp_enqueue_script( 'jquery' );
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
		 * Set settings sections
		 *
		 * @param array $sections setting sections array
		 */
		function set_sections( $sections ) {
			$this->settings_sections = $sections;

			return $this;
		}

		/**
		 * Add a single section
		 *
		 * @param array $section
		 */
		function add_section( $section ) {
			$this->settings_sections[] = $section;

			return $this;
		}

		/**
		 * Set settings fields
		 *
		 * @param array $fields settings fields array
		 */
		function set_fields( $fields ) {
			$this->settings_fields = $fields;

			return $this;
		}

		function add_field( $section, $field ) {
			$defaults = [
				'name'  => '',
				'label' => '',
				'desc'  => '',
				'type'  => 'text',
			];

			$arg                                 = wp_parse_args( $field, $defaults );
			$this->settings_fields[ $section ][] = $arg;

			return $this;
		}

		/**
		 * Initialize and registers the settings sections and fileds to WordPress
		 *
		 * Usually this should be called at `admin_init` hook.
		 *
		 * This function gets the initiated settings sections and fields. Then
		 * registers them to WordPress and ready for use.
		 */
		function admin_init() {
			//register settings sections
			foreach ( $this->settings_sections as $section ) {
				if ( false == get_option( $section['id'] ) ) {
					add_option( $section['id'] );
				}

				if ( isset( $section['desc'] ) && ! empty( $section['desc'] ) ) {
					$section['desc'] = '<div class="inside">' . $section['desc'] . '</div>';
					$callback        = create_function( '', 'echo "' . str_replace( '"', '\"', $section['desc'] ) . '";' );
				} elseif ( isset( $section['callback'] ) ) {
					$callback = $section['callback'];
				} else {
					$callback = null;
				}

				add_settings_section( $section['id'], $section['title'], $callback, $section['id'] );
			}

			//register settings fields
			foreach ( $this->settings_fields as $section => $field ) {
				foreach ( $field as $option ) {

					$type = isset( $option['type'] ) ? $option['type'] : 'text';

					$args = [
						'id'                => $option['name'],
						'label_for'         => $args['label_for'] = "{$section}[{$option['name']}]",
						'desc'              => isset( $option['desc'] ) ? $option['desc'] : '',
						'name'              => $option['label'],
						'section'           => $section,
						'size'              => isset( $option['size'] ) ? $option['size'] : null,
						'options'           => isset( $option['options'] ) ? $option['options'] : '',
						'std'               => isset( $option['default'] ) ? $option['default'] : '',
						'sanitize_callback' => isset( $option['sanitize_callback'] ) ? $option['sanitize_callback'] : '',
						'type'              => $type,
					];

					add_settings_field( $section . '[' . $option['name'] . ']', $option['label'], [
						$this,
						'callback_' . $type,
					], $section, $section, $args );
				}
			}

			// creates our settings in the options table
			foreach ( $this->settings_sections as $section ) {
				register_setting( $section['id'], $section['id'], [ $this, 'sanitize_options' ] );
			}
		}

		/**
		 * Get field description for display
		 *
		 * @param array $args settings field args
		 */
		public function get_field_description( $args ) {
			if ( ! empty( $args['desc'] ) ) {
				$desc = sprintf( '<p class="description">%s</p>', $args['desc'] );
			} else {
				$desc = '';
			}

			return $desc;
		}

		/**
		 * Displays a text field for a settings field
		 *
		 * @param array $args settings field args
		 */
		function callback_text( $args ) {

			$value = esc_attr( $this->get_option( $args['id'], $args['section'], $args['std'] ) );
			$size  = isset( $args['size'] ) && ! is_null( $args['size'] ) ? $args['size'] : 'regular';
			$type  = isset( $args['type'] ) ? $args['type'] : 'text';

			$html = sprintf( '<input type="%1$s" class="%2$s-text" id="%3$s[%4$s]" name="%3$s[%4$s]" value="%5$s"/>', $type, $size, $args['section'], $args['id'], $value );
			$html .= $this->get_field_description( $args );

			echo $html;
		}

		/**
		 * Displays a url field for a settings field
		 *
		 * @param array $args settings field args
		 */
		function callback_url( $args ) {
			$this->callback_text( $args );
		}

		/**
		 * Displays a number field for a settings field
		 *
		 * @param array $args settings field args
		 */
		function callback_number( $args ) {
			$this->callback_text( $args );
		}

		/**
		 * Displays a checkbox for a settings field
		 *
		 * @param array $args settings field args
		 */
		function callback_checkbox( $args ) {

			$value = esc_attr( $this->get_option( $args['id'], $args['section'], $args['std'] ) );

			$html = '<fieldset>';
			$html .= sprintf( '<label for="wpuf-%1$s[%2$s]">', $args['section'], $args['id'] );
			$html .= sprintf( '<input type="hidden" name="%1$s[%2$s]" value="off" />', $args['section'], $args['id'] );
			$html .= sprintf( '<input type="checkbox" class="checkbox" id="wpuf-%1$s[%2$s]" name="%1$s[%2$s]" value="on" %3$s />', $args['section'], $args['id'], checked( $value, 'on', false ) );
			$html .= sprintf( '%1$s</label>', $args['desc'] );
			$html .= '</fieldset>';

			echo $html;
		}

		/**
		 * Displays a multicheckbox a settings field
		 *
		 * @param array $args settings field args
		 */
		function callback_multicheck( $args ) {

			$value = $this->get_option( $args['id'], $args['section'], $args['std'] );
			$html  = '<fieldset>';

			foreach ( $args['options'] as $key => $label ) {
				$checked = isset( $value[ $key ] ) ? $value[ $key ] : '0';
				$html    .= sprintf( '<label for="wpuf-%1$s[%2$s][%3$s]">', $args['section'], $args['id'], $key );
				$html    .= sprintf( '<input type="checkbox" class="checkbox" id="wpuf-%1$s[%2$s][%3$s]" name="%1$s[%2$s][%3$s]" value="%3$s" %4$s />', $args['section'], $args['id'], $key, checked( $checked, $key, false ) );
				$html    .= sprintf( '%1$s</label><br>', $label );
			}

			$html .= $this->get_field_description( $args );
			$html .= '</fieldset>';

			echo $html;
		}

		/**
		 * Displays a multicheckbox a settings field
		 *
		 * @param array $args settings field args
		 */
		function callback_radio( $args ) {

			$value = $this->get_option( $args['id'], $args['section'], $args['std'] );
			$html  = '<fieldset>';

			foreach ( $args['options'] as $key => $label ) {
				$html .= sprintf( '<label for="wpuf-%1$s[%2$s][%3$s]">', $args['section'], $args['id'], $key );
				$html .= sprintf( '<input type="radio" class="radio" id="wpuf-%1$s[%2$s][%3$s]" name="%1$s[%2$s]" value="%3$s" %4$s />', $args['section'], $args['id'], $key, checked( $value, $key, false ) );
				$html .= sprintf( '%1$s</label><br>', $label );
			}

			$html .= $this->get_field_description( $args );
			$html .= '</fieldset>';

			echo $html;
		}

		/**
		 * Displays a selectbox for a settings field
		 *
		 * @param array $args settings field args
		 */
		function callback_select( $args ) {

			$value = esc_attr( $this->get_option( $args['id'], $args['section'], $args['std'] ) );
			$size  = isset( $args['size'] ) && ! is_null( $args['size'] ) ? $args['size'] : 'regular';
			$html  = sprintf( '<select class="%1$s" name="%2$s[%3$s]" id="%2$s[%3$s]">', $size, $args['section'], $args['id'] );

			foreach ( $args['options'] as $key => $label ) {
				$html .= sprintf( '<option value="%s"%s>%s</option>', $key, selected( $value, $key, false ), $label );
			}

			$html .= sprintf( '</select>' );
			$html .= $this->get_field_description( $args );

			echo $html;
		}

		/**
		 * Displays a textarea for a settings field
		 *
		 * @param array $args settings field args
		 */
		function callback_textarea( $args ) {

			$value = esc_textarea( $this->get_option( $args['id'], $args['section'], $args['std'] ) );
			$size  = isset( $args['size'] ) && ! is_null( $args['size'] ) ? $args['size'] : 'regular';

			$html = sprintf( '<textarea rows="5" cols="55" class="%1$s-text" id="%2$s[%3$s]" name="%2$s[%3$s]">%4$s</textarea>', $size, $args['section'], $args['id'], $value );
			$html .= $this->get_field_description( $args );

			echo $html;
		}

		/**
		 * Displays a textarea for a settings field
		 *
		 * @param array $args settings field args
		 *
		 * @return string
		 */
		function callback_html( $args ) {
			echo $this->get_field_description( $args );
		}

		/**
		 * Displays a rich text textarea for a settings field
		 *
		 * @param array $args settings field args
		 */
		function callback_wysiwyg( $args ) {

			$value = $this->get_option( $args['id'], $args['section'], $args['std'] );
			$size  = isset( $args['size'] ) && ! is_null( $args['size'] ) ? $args['size'] : '500px';

			echo '<div style="max-width: ' . $size . ';">';

			$editor_settings = [
				'teeny'         => true,
				'textarea_name' => $args['section'] . '[' . $args['id'] . ']',
				'textarea_rows' => 10,
			];

			if ( isset( $args['options'] ) && is_array( $args['options'] ) ) {
				$editor_settings = array_merge( $editor_settings, $args['options'] );
			}

			wp_editor( $value, $args['section'] . '-' . $args['id'], $editor_settings );

			echo '</div>';

			echo $this->get_field_description( $args );
		}

		/**
		 * Displays a file upload field for a settings field
		 *
		 * @param array $args settings field args
		 */
		function callback_file( $args ) {

			$value = esc_attr( $this->get_option( $args['id'], $args['section'], $args['std'] ) );
			$size  = isset( $args['size'] ) && ! is_null( $args['size'] ) ? $args['size'] : 'regular';
			$id    = $args['section'] . '[' . $args['id'] . ']';
			$label = isset( $args['options']['button_label'] ) ? $args['options']['button_label'] : __( 'Choose File' );

			$html = sprintf( '<input type="text" class="%1$s-text wpsa-url" id="%2$s[%3$s]" name="%2$s[%3$s]" value="%4$s"/>', $size, $args['section'], $args['id'], $value );
			$html .= '<input type="button" class="button wpsa-browse" value="' . $label . '" />';
			$html .= $this->get_field_description( $args );

			echo $html;
		}

		/**
		 * Displays a password field for a settings field
		 *
		 * @param array $args settings field args
		 */
		function callback_password( $args ) {

			$value = esc_attr( $this->get_option( $args['id'], $args['section'], $args['std'] ) );
			$size  = isset( $args['size'] ) && ! is_null( $args['size'] ) ? $args['size'] : 'regular';

			$html = sprintf( '<input type="password" class="%1$s-text" id="%2$s[%3$s]" name="%2$s[%3$s]" value="%4$s"/>', $size, $args['section'], $args['id'], $value );
			$html .= $this->get_field_description( $args );

			echo $html;
		}

		/**
		 * Displays a color picker field for a settings field
		 *
		 * @param array $args settings field args
		 */
		function callback_color( $args ) {

			$value = esc_attr( $this->get_option( $args['id'], $args['section'], $args['std'] ) );
			$size  = isset( $args['size'] ) && ! is_null( $args['size'] ) ? $args['size'] : 'regular';

			$html = sprintf( '<input type="text" class="%1$s-text wp-color-picker-field" id="%2$s[%3$s]" name="%2$s[%3$s]" value="%4$s" data-default-color="%5$s" />', $size, $args['section'], $args['id'], $value, $args['std'] );
			$html .= $this->get_field_description( $args );

			echo $html;
		}

		/**
		 * Sanitize callback for Settings API
		 */
		function sanitize_options( $options ) {
			foreach ( $options as $option_slug => $option_value ) {
				$sanitize_callback = $this->get_sanitize_callback( $option_slug );

				// If callback is set, call it
				if ( $sanitize_callback ) {
					$options[ $option_slug ] = call_user_func( $sanitize_callback, $option_value );
					continue;
				}
			}

			return $options;
		}

		/**
		 * Get sanitization callback for given option slug
		 *
		 * @param string $slug option slug
		 *
		 * @return mixed string or bool false
		 */
		function get_sanitize_callback( $slug = '' ) {
			if ( empty( $slug ) ) {
				return false;
			}

			// Iterate over registered fields and see if we can find proper callback
			foreach ( $this->settings_fields as $section => $options ) {
				foreach ( $options as $option ) {
					if ( $option['name'] != $slug ) {
						continue;
					}

					// Return the callback name
					return isset( $option['sanitize_callback'] ) && is_callable( $option['sanitize_callback'] ) ? $option['sanitize_callback'] : false;
				}
			}

			return false;
		}

		/**
		 * Get the value of a settings field
		 *
		 * @param string $option  settings field name
		 * @param string $section the section name this field belongs to
		 * @param string $default default text if it's not found
		 *
		 * @return string
		 */
		function get_option( $option, $section, $default = '' ) {

			$options = get_option( $section );

			if ( isset( $options[ $option ] ) ) {
				return $options[ $option ];
			}

			return $default;
		}

		/**
		 * Show navigations as tab
		 *
		 * Shows all the settings section labels as tab
		 */
		function show_navigation() {
			$html = '<h2 class="nav-tab-wrapper">';

			foreach ( $this->settings_sections as $tab ) {
				$html .= sprintf( '<a href="#%1$s" class="nav-tab" id="%1$s-tab">%2$s</a>', $tab['id'], $tab['title'] );
			}

			$html .= '</h2>';

			echo $html;
		}

		/**
		 * Show the section settings forms
		 *
		 * This function displays every sections in a different form
		 */
		function show_forms() {
			?>
            <div class="metabox-holder">
				<?php foreach ( $this->settings_sections as $form ) { ?>
                    <div id="<?php echo $form['id']; ?>" class="group" style="display: none;">
                        <form method="post" action="options.php">
							<?php
							do_action( 'wsa_form_top_' . $form['id'], $form );
							settings_fields( $form['id'] );
							do_settings_sections( $form['id'] );
							do_action( 'wsa_form_bottom_' . $form['id'], $form );
							?>
                            <div style="padding-left: 10px">
								<?php submit_button(); ?>
                            </div>
                        </form>
                    </div>
				<?php } ?>
            </div>
			<?php
			$this->script();
		}

		/**
		 * Tabbable JavaScript codes & Initiate Color Picker
		 *
		 * This code uses localstorage for displaying active tabs
		 */
		function script() {
			?>
            <script>
              jQuery(document).ready(function($) {
                //Initiate Color Picker
                $('.wp-color-picker-field').wpColorPicker();

                // Switches option sections
                $('.group').hide();
                var activetab = '';
                if (typeof(localStorage) != 'undefined') {
                  activetab = localStorage.getItem('activetab');
                }
                if (activetab != '' && $(activetab).length) {
                  $(activetab).fadeIn();
                } else {
                  $('.group:first').fadeIn();
                }
                $('.group .collapsed').each(function() {
                  $(this).find('input:checked').parent().parent().parent().nextAll().each(function() {
                    if ($(this).hasClass('last')) {
                      $(this).removeClass('hidden');
                      return false;
                    }
                    $(this).filter('.hidden').removeClass('hidden');
                  });
                });

                if (activetab != '' && $(activetab + '-tab').length) {
                  $(activetab + '-tab').addClass('nav-tab-active');
                } else {
                  $('.nav-tab-wrapper a:first').addClass('nav-tab-active');
                }
                $('.nav-tab-wrapper a').click(function(evt) {
                  $('.nav-tab-wrapper a').removeClass('nav-tab-active');
                  $(this).addClass('nav-tab-active').blur();
                  var clicked_group = $(this).attr('href');
                  if (typeof(localStorage) != 'undefined') {
                    localStorage.setItem('activetab', $(this).attr('href'));
                  }
                  $('.group').hide();
                  $(clicked_group).fadeIn();
                  evt.preventDefault();
                });

                $('.wpsa-browse').on('click', function(event) {
                  event.preventDefault();

                  var self = $(this);

                  // Create the media frame.
                  var file_frame = wp.media.frames.file_frame = wp.media({
                    title: self.data('uploader_title'), button: {
                      text: self.data('uploader_button_text'),
                    }, multiple: false,
                  });

                  file_frame.on('select', function() {
                    attachment = file_frame.state().get('selection').first().toJSON();

                    self.prev('.wpsa-url').val(attachment.url);
                  });

                  // Finally, open the modal
                  file_frame.open();
                });
              });
            </script>

            <style type="text/css">
                /** WordPress 3.8 Fix **/
                .form-table th {
                    padding: 20px 10px;
                }

                #wpbody-content .metabox-holder {
                    padding-top: 5px;
                }
            </style>
			<?php
		}

	}
endif;
