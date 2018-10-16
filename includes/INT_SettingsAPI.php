<?php
/**
 * Created by PhpStorm.
 * User: mint
 * Date: 10/16/18
 * Time: 5:32 PM
 */

namespace Netraa\WPB;

interface INT_SettingsAPI {
	/**
	 * Enqueue scripts and styles
	 */
	function admin_enqueue_scripts();

	/**
	 * Set settings sections
	 *
	 * @param array $sections setting sections array
	 */
	function set_sections( $sections );

	/**
	 * Add a single section
	 *
	 * @param array $section
	 */
	function add_section( $section );

	/**
	 * Set settings fields
	 *
	 * @param array $fields settings fields array
	 */
	function set_fields( $fields );

	function add_field( $section, $field );

	/**
	 * Initialize and registers the settings sections and fileds to WordPress
	 *
	 * Usually this should be called at `admin_init` hook.
	 *
	 * This function gets the initiated settings sections and fields. Then
	 * registers them to WordPress and ready for use.
	 */
	function admin_init();

	/**
	 * Get field description for display
	 *
	 * @param array $args settings field args
	 */
	public function get_field_description( $args );

	/**
	 * Displays a text field for a settings field
	 *
	 * @param array $args settings field args
	 */
	function callback_text( $args );

	/**
	 * Displays a url field for a settings field
	 *
	 * @param array $args settings field args
	 */
	function callback_url( $args );

	/**
	 * Displays a number field for a settings field
	 *
	 * @param array $args settings field args
	 */
	function callback_number( $args );

	/**
	 * Displays a checkbox for a settings field
	 *
	 * @param array $args settings field args
	 */
	function callback_checkbox( $args );

	/**
	 * Displays a multicheckbox a settings field
	 *
	 * @param array $args settings field args
	 */
	function callback_multicheck( $args );

	/**
	 * Displays a multicheckbox a settings field
	 *
	 * @param array $args settings field args
	 */
	function callback_radio( $args );

	/**
	 * Displays a selectbox for a settings field
	 *
	 * @param array $args settings field args
	 */
	function callback_select( $args );

	/**
	 * Displays a textarea for a settings field
	 *
	 * @param array $args settings field args
	 */
	function callback_textarea( $args );

	/**
	 * Displays a textarea for a settings field
	 *
	 * @param array $args settings field args
	 *
	 * @return string
	 */
	function callback_html( $args );

	/**
	 * Displays a rich text textarea for a settings field
	 *
	 * @param array $args settings field args
	 */
	function callback_wysiwyg( $args );

	/**
	 * Displays a file upload field for a settings field
	 *
	 * @param array $args settings field args
	 */
	function callback_file( $args );

	/**
	 * Displays a password field for a settings field
	 *
	 * @param array $args settings field args
	 */
	function callback_password( $args );

	/**
	 * Displays a color picker field for a settings field
	 *
	 * @param array $args settings field args
	 */
	function callback_color( $args );

	/**
	 * Sanitize callback for Settings API
	 */
	function sanitize_options( $options );

	/**
	 * Get sanitization callback for given option slug
	 *
	 * @param string $slug option slug
	 *
	 * @return mixed string or bool false
	 */
	function get_sanitize_callback( $slug = '' );

	/**
	 * Get the value of a settings field
	 *
	 * @param string $option  settings field name
	 * @param string $section the section name this field belongs to
	 * @param string $default default text if it's not found
	 *
	 * @return string
	 */
	function get_option( $option, $section, $default = '' );

	/**
	 * Show navigations as tab
	 *
	 * Shows all the settings section labels as tab
	 */
	function show_navigation();

	/**
	 * Show the section settings forms
	 *
	 * This function displays every sections in a different form
	 */
	function show_forms();

	/**
	 * Tabbable JavaScript codes & Initiate Color Picker
	 *
	 * This code uses localstorage for displaying active tabs
	 */
	function script();
}