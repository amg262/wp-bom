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

namespace Netraa\WPB\Endpoint;

use Netraa\WPB;
use WP_Post;

/**
 * @subpackage REST_Controller
 */
class PartAPI {
	/**
	 * Instance of this class.
	 *
	 * @since    0.8.1
	 *
	 * @var      object
	 */
	protected static $instance = null;

	/**
	 * Initialize the plugin by setting localization and loading public scripts
	 * and styles.
	 *
	 * @since     0.8.1
	 */
	private function __construct() {
		$plugin            = WPB\Plugin::get_instance();
		$this->plugin_slug = $plugin->get_plugin_slug();
	}

	/**
	 * Set up WordPress hooks and filters
	 *
	 * @return void
	 */
	public function do_hooks() {
		add_action( 'rest_api_init', [ $this, 'register_routes' ] );
	}

	/**
	 * Return an instance of this class.
	 *
	 * @since     0.8.1
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
	 * Register the routes for the objects of the controller.
	 */
	public function register_routes() {
		$version   = '1';
		$namespace = $this->plugin_slug . '/v' . $version;
		$endpoint  = '/part/';

		register_rest_route( $namespace, $endpoint, [
			[
				'methods'             => \WP_REST_Server::READABLE,
				'callback'            => [ $this, 'get_part' ],
				'permission_callback' => [ $this, 'part_permissions_check' ],
				'args'                => [],
			],
		] );

		register_rest_route( $namespace, $endpoint, [
			[
				'methods'             => \WP_REST_Server::CREATABLE,
				'callback'            => [ $this, 'update_part' ],
				'permission_callback' => [ $this, 'part_permissions_check' ],
				'args'                => [],
			],
		] );

		register_rest_route( $namespace, $endpoint, [
			[
				'methods'             => \WP_REST_Server::EDITABLE,
				'callback'            => [ $this, 'update_part' ],
				'permission_callback' => [ $this, 'part_permissions_check' ],
				'args'                => [],
			],
		] );

		register_rest_route( $namespace, $endpoint, [
			[
				'methods'             => \WP_REST_Server::DELETABLE,
				'callback'            => [ $this, 'delete_part' ],
				'permission_callback' => [ $this, 'part_permissions_check' ],
				'args'                => [],
			],
		] );

	}

	/**
	 * Get Example
	 *
	 * @param WP_REST_Request $request Full data about the request.
	 *
	 * @return \WP_REST_Response
	 */
	public function get_part( $request ) {
		$args = [ 'ID' => $request->get_param( 'id' ) ];
		//$args = [ 'post_title' => $request->get_param( 'title' ), 'ID' => $request->get_param( 'id' ) ];
		$post = get_post( $args );
		//$post = new WP_Post( $args );

		// Don't return false if there is no option
		if ( isset( $post ) ) {
			return new \WP_REST_Response( [
				'success' => true,
				'value'   => '',
			], 200 );
		}

		return new \WP_REST_Response( [
			'success' => true,
			'value'   => $post,
		], 200 );
	}

	/**
	 * Create OR Update Example
	 *
	 * @param WP_REST_Request $request Full data about the request.
	 *
	 * @return \WP_REST_Response
	 */
	public function update_part( $request ) {

		$args = [ 'post_title' => $request->get_param( 'title' ), 'ID' => $request->get_param( 'id' ) ];
		//$args = [ 'post_title' => $request->get_param( 'title' ), 'ID' => $request->get_param( 'id' ) ];
		$post = get_post( $args );
		$post2 = new WP_Post( $args );

		return new \WP_REST_Response( [
			'success' => $post2,
			'value'   => $request->get_param( 'part_setting' ),
		], 200 );
	}

	/**
	 * Delete Example
	 *
	 * @param WP_REST_Request $request Full data about the request.
	 *
	 * @return \WP_REST_Response
	 */
	public function delete_part( $request ) {
		$args = [ 'post_title' => $request->get_param( 'title' ), 'ID' => $request->get_param( 'id' ) ];
		//$args = [ 'post_title' => $request->get_param( 'title' ), 'ID' => $request->get_param( 'id' ) ];
		$post = get_post( $args );
		$post2 = new WP_Post( $args );

		$trashed = wp_trash_post( $request->get_param( 'id' ) );

		return new \WP_REST_Response( [
			'success' => $trashed,
			'value'   => '',
		], 200 );
	}

	/**
	 * Check if a given request has access to update a setting
	 *
	 * @param WP_REST_Request $request Full data about the request.
	 *
	 * @return WP_Error|bool
	 */
	public function part_permissions_check( $request ) {
		return current_user_can( 'edit_post' );
	}
}
