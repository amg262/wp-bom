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

/**
 * @subpackage Plugin
 */
class Data {

	/**
	 * Instance of this class.
	 *
	 * @since    1.0.0
	 *
	 * @var      object
	 */
	protected static $instance = null;


	private $options;

	private $settings;

	private $post_cache;

	private $cache;

	private $db;

	private $part_cache;
	private $assem_cache;
	private $req_cache;


	/**
	 * Setup instance attributes
	 *
	 * @since     1.0.0
	 */
	private function __construct() {
		$this->setOptions();
		$this->setPartCache();

		wp_cache_set( 'parts', get_posts( [ 'posts_per_page' => - 1, 'post_type' => 'part' ] ) );


		add_action( 'admin_init', [ $this, 'getOptions' ] );

//
//		echo json_encode( $this->getOptions() );
//		echo json_encode( wp_cache_get( 'parts' ) );

	}

	/**
	 * @return mixed
	 */
	public function getOptions() {
		return $this->options;
	}

	/**
	 * @param mixed $options
	 *
	 * @return Data
	 */
	public function setOptions() {


		$this->settings = [
			[
				'id'   => 'wpb_settings',
				'data' => [],
			],
			[
				'id'   => 'wpb_advanced',
				'data' => [],
			],
			[
				'id'   => 'wpb_others',
				'data' => [],
			],
			[
				'id'   => 'wpb_io',
				'data' => [],
			],
			[
				'id'   => 'wpb_support',
				'data' => [],
			],
			[
				'id'   => 'wp_bom_data',
				'data' => [],
			],
			[
				'id'   => 'wp_bom',
				'data' => [],
			],
		];


		foreach ( $this->settings as $setting ) {
			$opt             = get_option( $setting['id'] );
			$setting['data'] = $opt;
			$this->options[] = [ $setting['id'] => $opt ];
		}


		return $this->options;
	}

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
		}

		return self::$instance;
	}

	/**
	 * @return mixed
	 */
	public function getPartCache() {
		return $this->part_cache;
	}

	/**
	 * @param mixed $part_cache
	 */
	public function setPartCache() {


		$parts = get_posts( [ 'posts_per_page' => - 1, 'post_type' => 'part' ] );

		if ( $parts !== null ) {
			wp_cache_set( 'parts', $parts, 'wp_bom_posts', 0 );
		}

		$this->part_cache = wp_cache_get( 'parts' );
	}

	/**
	 * @return mixed
	 */
	public function getSettings() {
		return $this->settings;
	}

	/**
	 * @param mixed $settings
	 *
	 * @return Data
	 */
	public function setSettings( $settings ) {
		$this->settings = $settings;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getPostCache() {
		return $this->post_cache;
	}

	/**
	 * @param mixed $post_cache
	 *
	 * @return Data
	 */
	public function setPostCache( $post_cache ) {

		$types = get_post_types();


		$parts = get_posts( [ 'posts_per_page' => - 1, 'post_type' => 'part' ] );
		$assem = get_posts( [ 'posts_per_page' => - 1, 'post_type' => 'assembly' ] );
		$req   = get_posts( [ 'posts_per_page' => - 1, 'post_type' => 'requisition' ] );

		wp_cache_set( 'parts', $parts, 'wp_bom_posts', 0 );
		wp_cache_set( 'assembly', $assem, 'wp_bom_posts', 0 );
		wp_cache_set( 'requisition', $req, 'wp_bom_posts', 0 );


		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getCache() {
		return $this->cache;
	}

	/**
	 * @param mixed $cache
	 *
	 * @return Data
	 */
	public function setCache( $cache ) {

		wp_cache_get( $cache );

		$this->cache = $cache;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getDb() {
		return $this->db;
	}

	/**
	 * @param mixed $db
	 *
	 * @return Data
	 */
	public function setDb( $db ) {
		$this->db = $db;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getAssemCache() {
		return $this->assem_cache;
	}

	/**
	 * @param mixed $assem_cache
	 */
	public function setAssemCache( $assem_cache ): void {
		$this->assem_cache = $assem_cache;
	}

	/**
	 * @return mixed
	 */
	public function getReqCache() {
		return $this->req_cache;
	}

	/**
	 * @param mixed $req_cache
	 */
	public function setReqCache( $req_cache ): void {
		$this->req_cache = $req_cache;
	}


}
