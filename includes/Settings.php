<?php

/**
 * WordPress settings API demo class
 *
 * @author Tareq Hasan
 */

namespace Netraa\WPB;

use WP_Post;

class Settings {

	private $settings_api;

	function __construct() {

		$this->settings_api = new SettingsAPI;

		add_action( 'admin_init', [ $this, 'admin_init' ] );
		add_action( 'admin_menu', [ $this, 'admin_menu' ] );
	}

	function admin_init() {

		//set the settings
		$this->settings_api->set_sections( $this->get_settings_sections() );
		$this->settings_api->set_fields( $this->get_settings_fields() );

		//initialize settings
		$this->settings_api->admin_init();

		//var_dump( get_option( 'wedevs_basics' ) );
	}

	function admin_menu() {

		echo '';
		add_options_page( 'Settings API', 'Settings API', 'manage_options', 'settings_api_test', [
			$this,
			'plugin_page',
		] );
	}

	function get_settings_sections() {

		$sections = [
			[
				'id'    => 'wcb_settings',
				'title' => __( 'Basic Settings', 'wedevs' ),
			],
			[
				'id'    => 'wcb_advanced',
				'title' => __( 'Advanced Settings', 'wedevs' ),
			],
			[
				'id'    => 'wcb_others',
				'title' => __( 'Other Settings', 'wpuf' ),
			],
		];

		return $sections;
	}

	/**
	 * Returns all the settings fields
	 *
	 * @return array settings fields
	 */
	function get_settings_fields() {

		foreach ( get_post_types() as $type ) {

			//echo json_encode( $type );
		}

		$args = [
			'posts_per_page'   => - 1,
			'post_type'        => 'part',
			'post_status'      => 'publish',
			'suppress_filters' => true,
		];

		$posts_array = get_posts( $args );

		foreach ( $posts_array as $post ) {
			$post  = new WP_Post( $post );
			$arr[] = [ $post->post_title => $post->post_title ];
		}


		$settings_fields = [
			'wcb_settings' => [
				[
					'name'              => 'text_val',
					'label'             => __( 'Text Input', 'wedevs' ),
					'desc'              => __( 'Text input description', 'wedevs' ),
					'type'              => 'text',
					'default'           => 'Title',
					'sanitize_callback' => 'intval',
				],
				[
					'name'              => 'number_input',
					'label'             => __( 'Number Input', 'wedevs' ),
					'desc'              => __( 'Number field with validation callback `intval`', 'wedevs' ),
					'type'              => 'number',
					'default'           => 'Title',
					'sanitize_callback' => 'intval',
				],
				[
					'name'  => 'textarea',
					'label' => __( 'Textarea Input', 'wedevs' ),
					'desc'  => __( 'Textarea description', 'wedevs' ),
					'type'  => 'textarea',
				],
				[
					'name'  => 'checkbox',
					'label' => __( 'Checkbox', 'wedevs' ),
					'desc'  => __( 'Checkbox Label', 'wedevs' ),
					'type'  => 'checkbox',
				],
				[
					'name'    => 'radio',
					'label'   => __( 'Radio Button', 'wedevs' ),
					'desc'    => __( 'A radio button', 'wedevs' ),
					'type'    => 'radio',
					'options' => [
						'yes' => 'Yes',
						'no'  => 'No',
					],
				],
				[
					'name'    => 'multicheck',
					'label'   => __( 'Multile checkbox', 'wedevs' ),
					'desc'    => __( 'Multi checkbox description', 'wedevs' ),
					'type'    => 'multicheck',
					'options' => [
						'one'   => 'One',
						'two'   => 'Two',
						'three' => 'Three',
						'four'  => 'Four',
					],
				],
				[
					'name'    => 'selectbox',
					'label'   => __( 'A Dropdown', 'wedevs' ),
					'desc'    => __( 'Dropdown description', 'wedevs' ),
					'type'    => 'select',
					'default' => 'no',
					'options' => [
						//json_encode( $arr )
						//'yes' => 'Yes',
						//'no'  => 'No',
					],
				],
				[
					'name'    => 'password',
					'label'   => __( 'Password', 'wedevs' ),
					'desc'    => __( 'Password description', 'wedevs' ),
					'type'    => 'password',
					'default' => '',
				],
				[
					'name'    => 'file',
					'label'   => __( 'File', 'wedevs' ),
					'desc'    => __( 'File description', 'wedevs' ),
					'type'    => 'file',
					'default' => '',
					'options' => [
						'button_label' => 'Choose Image',
					],
				],
			],
			'wcb_advanced' => [
				[
					'name'    => 'color',
					'label'   => __( 'Color', 'wedevs' ),
					'desc'    => __( 'Color description', 'wedevs' ),
					'type'    => 'color',
					'default' => '',
				],
				[
					'name'    => 'password',
					'label'   => __( 'Password', 'wedevs' ),
					'desc'    => __( 'Password description', 'wedevs' ),
					'type'    => 'password',
					'default' => '',
				],
				[
					'name'    => 'wysiwyg',
					'label'   => __( 'Advanced Editor', 'wedevs' ),
					'desc'    => __( 'WP_Editor description', 'wedevs' ),
					'type'    => 'wysiwyg',
					'default' => '',
				],
				[
					'name'    => 'multicheck',
					'label'   => __( 'Multile checkbox', 'wedevs' ),
					'desc'    => __( 'Multi checkbox description', 'wedevs' ),
					'type'    => 'multicheck',
					'default' => [ 'one' => 'one', 'four' => 'four' ],
					'options' => [
						'one'   => 'One',
						'two'   => 'Two',
						'three' => 'Three',
						'four'  => 'Four',
					],
				],
				[
					'name'    => 'selectbox',
					'label'   => __( 'A Dropdown', 'wedevs' ),
					'desc'    => __( 'Dropdown description', 'wedevs' ),
					'type'    => 'select',
					'options' => [
						'yes' => 'Yes',
						'no'  => 'No',
					],
				],
				[
					'name'    => 'password',
					'label'   => __( 'Password', 'wedevs' ),
					'desc'    => __( 'Password description', 'wedevs' ),
					'type'    => 'password',
					'default' => '',
				],
				[
					'name'    => 'file',
					'label'   => __( 'File', 'wedevs' ),
					'desc'    => __( 'File description', 'wedevs' ),
					'type'    => 'file',
					'default' => '',
				],
			],
			'wcb_others'   => [
				[
					'name'    => 'text',
					'label'   => __( 'Text Input', 'wedevs' ),
					'desc'    => __( 'Text input description', 'wedevs' ),
					'type'    => 'text',
					'default' => 'Title',
				],
				[
					'name'  => 'textarea',
					'label' => __( 'Textarea Input', 'wedevs' ),
					'desc'  => __( 'Textarea description', 'wedevs' ),
					'type'  => 'textarea',
				],
				[
					'name'  => 'checkbox',
					'label' => __( 'Checkbox', 'wedevs' ),
					'desc'  => __( 'Checkbox Label', 'wedevs' ),
					'type'  => 'checkbox',
				],
				[
					'name'    => 'radio',
					'label'   => __( 'Radio Button', 'wedevs' ),
					'desc'    => __( 'A radio button', 'wedevs' ),
					'type'    => 'radio',
					'options' => [
						'yes' => 'Yes',
						'no'  => 'No',
					],
				],
				[
					'name'    => 'multicheck',
					'label'   => __( 'Multile checkbox', 'wedevs' ),
					'desc'    => __( 'Multi checkbox description', 'wedevs' ),
					'type'    => 'multicheck',
					'options' => [
						'one'   => 'One',
						'two'   => 'Two',
						'three' => 'Three',
						'four'  => 'Four',
					],
				],
				[
					'name'    => 'selectbox',
					'label'   => __( 'A Dropdown', 'wedevs' ),
					'desc'    => __( 'Dropdown description', 'wedevs' ),
					'type'    => 'select',
					'options' => [
						'yes' => 'Yes',
						'no'  => 'No',
					],
				],
				[
					'name'    => 'password',
					'label'   => __( 'Password', 'wedevs' ),
					'desc'    => __( 'Password description', 'wedevs' ),
					'type'    => 'password',
					'default' => '',
				],
				[
					'name'    => 'file',
					'label'   => __( 'File', 'wedevs' ),
					'desc'    => __( 'File description', 'wedevs' ),
					'type'    => 'file',
					'default' => '',
				],
			],
		];

		return $settings_fields;
	}

	function plugin_page() {

		echo '<div class="wrap">';

		$this->settings_api->show_navigation();
		$this->settings_api->show_forms();

		echo '</div>';
	}

	/**
	 * Get all the pages
	 *
	 * @return array page names with key value pairs
	 */
	function get_pages() {

		$pages         = get_pages();
		$pages_options = [];
		if ( $pages ) {
			foreach ( $pages as $page ) {
				$pages_options[ $page->ID ] = $page->post_title;
			}
		}

		return $pages_options;
	}

}
