<?php
/**
 * Created by PhpStorm.
 * User: mint
 * Date: 10/16/18
 * Time: 1:19 PM
 */

namespace Netraa\WPB;

use Netraa\WPB\PostObject;
use WP_Post;

class PartObject extends PostObject {


	/**
	 * @var
	 */
	private $part_no;
	/**
	 * @var
	 */
	private $cost;
	/**
	 * @var
	 */
	private $post;
	private $post_id;
	/**
	 * @var
	 */
	private $part_name;
	/**
	 * @var
	 */
	private $vendor;
	/**
	 * @var array
	 */
	private $cats = [];
	/**
	 * @var array
	 */
	private $tags = [];
	/**
	 * @var
	 */
	private $sku;
	/**
	 * @var
	 */
	private $weight;
	/**
	 * @var
	 */
	private $dimensions;


	private $key;
	/**
	 * @var
	 */
	private $value;



	private $meta;

	


	/**
	 * PartObject constructor.
	 */
	public function __construct() {
		$post = PostObject::__construct();

	}


	/**
	 * @return mixed
	 */
	public function getPostId() {
		return $this->post_id;
	}

	public function setPostId( $post_id ) {
		$this->post_id = $post_id;

		return $this->post_id;
	}

	public function getMeta() {
		return $this->meta;
	}

	public function setMeta( $key, $post_id ) {
		$this->meta = get_field( $key, $post_id );

		return $this->meta;
	}

	/**
	 * @return mixed
	 */
	public function getPost() {
		return $this->post;
	}


	public function setPost( $post ) {

		if ( is_int( $post ) ) {
			$this->post = get_post( $post );
		} else {
			$this->post = new WP_Post( $post );
		}

		return $this->post;
	}


}