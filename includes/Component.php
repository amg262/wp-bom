<?php
/**
 * Created by PhpStorm.
 * User: mint
 * Date: 10/11/18
 * Time: 6:49 PM
 */

namespace Netraa\WPB;

/**
 * Class Component
 *
 * @package Netraa\WPB
 */
class Component {

	/**
	 * @var
	 */
	private $part_no;
	/**
	 * @var
	 */
	private $assembly_id;
	/**
	 * @var
	 */
	private $post_type;
	/**
	 * @var
	 */
	private $cost;
	/**
	 * @var
	 */
	private $post_id;
	/**
	 * @var
	 */
	private $post;
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
	/**
	 * @var
	 */
	private $image;
	/**
	 * @var
	 */
	private $description;
	/**
	 * @var
	 */
	private $po_num;
	/**
	 * @var
	 */
	private $date;
	/**
	 * @var
	 */
	private $key;
	/**
	 * @var
	 */
	private $value;
	/**
	 * @var
	 */
	private $custom_field;
	/**
	 * @var
	 */
	private $acf_field;
	/**
	 * @var array
	 */
	private $items = [];
	/**
	 * @var array
	 */
	private $sub_items = [];
	/**
	 * @var array
	 */
	private $part_items = [];

	private $obj;

	private $parent_post;
	private $child_post;

	private $cf_items = [];
	private $cf_items_labels = [ 'level', 'type', 'quantity', 'item' ];


	private $cf_assem_subitems = [];
	private $cf_assem_parts = [];
	private $cf_assem_items = [];
	private $cf_prod_items = [];
	private $cf_req_items = [];


	private $item_level;
	private $item_type;
	private $item_qty;
	private $item_post = [];

	/**
	 * Component constructor.
	 */
	public function __construct( $post_id ) {
		$this->post_id  = $post_id;
		$this->meta_key = $this->setPost( $this->getPostId() );
	}

	/**
	 * @return array
	 */
	public function getCfItems(): array {
		return $this->cf_items;
	}

	/**
	 * @param array $cf_items
	 *
	 * @return Component
	 */
	public function setCfItems( array $cf_items ): Component {
		$this->cf_items = $cf_items;

		return $this;
	}

	/**
	 * @return array
	 */
	public function getCfAssemSubitems(): array {
		return $this->cf_assem_subitems;
	}

	/**
	 * @param array $cf_assem_subitems
	 *
	 * @return Component
	 */
	public function setCfAssemSubitems( array $cf_assem_subitems ): Component {
		$this->cf_assem_subitems = $cf_assem_subitems;

		return $this;
	}

	/**
	 * @return array
	 */
	public function getCfAssemParts(): array {
		return $this->cf_assem_parts;
	}

	/**
	 * @param array $cf_assem_parts
	 *
	 * @return Component
	 */
	public function setCfAssemParts( array $cf_assem_parts ): Component {
		$this->cf_assem_parts = $cf_assem_parts;

		return $this;
	}

	/**
	 * @return array
	 */
	public function getCfAssemItems(): array {
		return $this->cf_assem_items;
	}


	public function setCfAssemItems( $post_id ) {


		if ( have_rows( 'items', $post_id ) ) {

			$i                 = 0;
			$j                 = 0;
			$this->parent_post = get_post( $post_id );

			while ( have_rows( 'items', $post_id ) ) : the_row();
				$i ++;

				$type     = get_sub_field( 'type' );
				$level    = get_sub_field( 'level' );
				$quantity = get_sub_field( 'quantity' );
				$item     = get_sub_field( 'item' );

				$obj = get_post( $item );

				$args = [ $obj->post_title, $level, $quantity, $type, $item ];

				if ( strtolower( $type ) !== strtolower( $obj->post_type ) ) {
					update_sub_field( 'type', $obj->post_type );
				}

				if ( $this->parent_post->post_type === 'assembly' && $obj->post_type === 'assembly' ) {
					$this->cf_assem_subitems[] = $args;
					$this->cf_assem_items[]    = $args;

				}


				if ( $obj->post_type === 'part' ) {
					$this->cf_assem_parts[] = $args;
					$this->cf_assem_items[] = $args;

				}


				//$pos = get_post( $ass );

			endwhile;

			return $this->cf_assem_items;

		}

		return false;
	}

	public function get_item_data( $assembly_id ) {
		if ( have_rows( 'items', $assembly_id ) ) {

			$i = 0;
			$j = 0;
			while ( have_rows( 'items', $assembly_id ) ) : the_row();
				$i ++;

				$type     = get_sub_field( 'type' );
				$level    = get_sub_field( 'level' );
				$quantity = get_sub_field( 'quantity' );
				$item     = get_sub_field( 'item' );


				$sub_item = new \WP_Post( $item );

				if ( strtolower( $type ) !== strtolower( $sub_item->post_type ) ) {
					update_sub_field( 'type', $sub_item->post_type );
				}


				//$this->handle_type( $assembly_id, $sub_item->post_type );

				$this->item_parts[] = [
					'id'    => $sub_item,
					'qty'   => $quantity,
					'level' => $level,
					'type'  => get_sub_field( 'type' ),
				];

				if ( $sub_item->post_type === 'assembly' ) {
					$this->item_assem[] = [
						'id'    => $sub_item,
						'qty'   => $quantity,
						'level' => $level,
						'type'  => get_sub_field( 'type' ),
					];

				} elseif ( $sub_item->post_type === 'part' ) {
					$this->item_parts[] = [
						'id'    => $sub_item,
						'qty'   => $quantity,
						'level' => $level,
						'type'  => get_sub_field( 'type' ),
					];
				}


				//$pos = get_post( $ass );

			endwhile;

			echo $i . $j;

			return [ 'ASSEM' => $this->item_assem ];
		}
	}


	/**
	 * @return mixed
	 */
	public function getAcfField() {
		return $this->acf_field;

	}

	public function build_object() {

	}

	/**
	 * @param $acf_field
	 *
	 * @return
	 */
	public function setAcfField( $key, $post_ID ) {
		$this->acf_field = get_field( $key, $post_ID );

		return $this->acf_field;
	}

	/**
	 * @return mixed
	 */
	public function getMetaKey() {
		return $this->key;

	}


	/**
	 * @param $key
	 *
	 * @return mixed
	 */
	public function setMetaKey( $key ) {
		$this->key = $key;

		return $this->key;

	}

	/**
	 * @return mixed
	 */
	public function getAssemblyId() {
		return $this->assembly_id;
	}

	/**
	 * @param mixed $assembly_id
	 *
	 * @return Component
	 */
	public function setAssemblyId( $assembly_id ) {
		$this->assembly_id = $assembly_id;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getPostType() {
		return $this->post_type;
	}

	/**
	 * @param mixed $post_type
	 *
	 * @return Component
	 */
	public function setPostType( $post_type ) {
		$this->post_type = $post_type;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getPartNo() {
		return $this->part_no;
	}

	/**
	 * @param mixed $part_no
	 *
	 * @return Component
	 */
	public function setPartNo( $part_no ) {
		$this->part_no = $part_no;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getCost() {
		return $this->cost;
	}

	/**
	 * @param mixed $cost
	 *
	 * @return Component
	 */
	public function setCost( $cost ) {
		$this->cost = $cost;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getPost() {
		return;
	}

	/**
	 * @param mixed $post_id
	 *
	 * @return Component
	 */
	public function setPost( $post_id ) {
		$this->post = get_post( $post_id );

		return $this->post;
	}

	/**
	 * @return mixed
	 */
	public function getPostId() {
		return $this->post_id;
	}

	/**
	 * @param mixed $post_id
	 *
	 * @return Component
	 */
	public function setPostId( $post_id ) {
		$this->post_id = $post_id;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getPartName() {
		return $this->part_name;
	}

	/**
	 * @param mixed $part_name
	 *
	 * @return Component
	 */
	public function setPartName( $part_name ) {
		$this->part_name = $part_name;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getVendor() {
		return $this->vendor;
	}

	/**
	 * @param mixed $vendor
	 *
	 * @return Component
	 */
	public function setVendor( \WP_Taxonomy $vendor ) {
		$this->vendor = $vendor;

		return $this;
	}

	/**
	 * @return array
	 */
	public function getCats(): array {
		return $this->cats;
	}

	/**
	 * @param array $cats
	 *
	 * @return Component
	 */
	public function setCats( array $cats ): Component {
		$this->cats = $cats;

		return $this;
	}

	/**
	 * @return array
	 */
	public function getTags(): array {
		return $this->tags;
	}

	/**
	 * @param array $tags
	 *
	 * @return Component
	 */
	public function setTags( array $tags ): Component {
		$this->tags = $tags;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getSku() {
		return $this->sku;
	}

	/**
	 * @param mixed $sku
	 *
	 * @return Component
	 */
	public function setSku( $sku ) {
		$this->sku = $sku;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getWeight() {
		return $this->weight;
	}

	/**
	 * @param mixed $weight
	 *
	 * @return Component
	 */
	public function setWeight( $weight ) {
		$this->weight = $weight;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getDimensions() {
		return $this->dimensions;
	}

	/**
	 * @param mixed $dimensions
	 *
	 * @return Component
	 */
	public function setDimensions( $dimensions ) {
		$this->dimensions = $dimensions;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getImage() {
		return $this->image;
	}

	/**
	 * @param mixed $image
	 *
	 * @return Component
	 */
	public function setImage( $image ) {
		$this->image = $image;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getDescription() {
		return $this->description;
	}

	/**
	 * @param mixed $description
	 *
	 * @return Component
	 */
	public function setDescription( $description ) {
		$this->description = $description;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getPoNum() {
		return $this->po_num;
	}

	/**
	 * @param mixed $po_num
	 *
	 * @return Component
	 */
	public function setPoNum( $po_num ) {
		$this->po_num = $po_num;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getDate() {
		return $this->date;
	}

	/**
	 * @param mixed $date
	 *
	 * @return Component
	 */
	public function setDate( $date ) {
		$this->date = $date;

		return $this;
	}

	/**
	 * @return array
	 */
	public function getItems(): array {
		return $this->items;
	}

	/**
	 * @param array $items
	 *
	 * @return Component
	 */
	public function setItems( array $items ): Component {
		$this->items = $items;

		return $this;
	}

	/**
	 * @return array
	 */
	public function getSubItems(): array {
		return $this->sub_items;
	}

	/**
	 * @param array $sub_items
	 *
	 * @return Component
	 */
	public function setSubItems( array $sub_items ): Component {
		$this->sub_items = $sub_items;

		return $this;
	}

	/**
	 * @return array
	 */
	public function getPartItems(): array {
		return $this->part_items;
	}

	/**
	 * @param array $part_items
	 *
	 * @return Component
	 */
	public function setPartItems( array $part_items ): Component {
		$this->part_items = $part_items;

		return $this;
	}


}