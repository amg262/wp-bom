<?php
/**
 * Created by PhpStorm.
 * User: mint
 * Date: 10/16/18
 * Time: 1:19 PM
 */

namespace Netraa\WPB;

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
	public function __construct( $post_id ) {

		PostObject::__construct( $post_id );
		$this->post_id = $this->setPostId($post_id);
		$this->post = $this->setPost($post_id);

		$this->post = PostObject::__construct( $post_id );

	}


}