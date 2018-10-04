<?php
/**
 * Copyright (c) 2018. | WP Bill of Materials
 * andrewmgunn26@gmail.com | https://github.com/amg262/wp-bom
 */

/**
 * Created by PhpStorm.
 * User: mint
 * Date: 10/3/18
 * Time: 3:23 PM
 */

namespace Netraa\WPB;


class Auth {

//	protected static $instance = null;

	private $is_auth = false;

	public function __construct() {
	}

	protected function init() {

	}
//
//	public static function get_instance() {
//
//		if ( static::$instance === null ) {
//			static::$instance = new static;
//		}
//
//		return static::$instance;
//	}

	public function parse_key($key) {
		if ($key === 'boobs') {
			$this->is_auth = true;
		}
		return $this->is_auth;
	}

}