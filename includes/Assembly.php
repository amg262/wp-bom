<?php
/**
 * Created by PhpStorm.
 * User: mint
 * Date: 10/18/18
 * Time: 8:17 PM
 */

namespace Netraa\WPB;


class Assembly extends PostObject {


	private $meta_cfs = [ 'assembly_id', 'levels', 'object_list', 'related_assemblies' ];

	private $post_obj;


	/**
	 * Assembly constructor.
	 */
	public function __construct( $post_id ) {
		$this->post_obj = PostObject::__construct( $post_id );
	}


}