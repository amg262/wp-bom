<?php
/**
 * Copyright (c) 2018. | WP Bill of Materials
 * andrewmgunn26@gmail.com | https://github.com/amg262/wp-bom
 */

/**
 * Created by PhpStorm.
 * User: mint
 * Date: 10/3/18
 * Time: 1:28 PM
 */

namespace Netraa\WPB;


class Cache {

	protected static $instance = null;

	private function __construct() {
	}

	protected function init() {

	}

	public static function get_instance() {

		if ( static::$instance === null ) {
			static::$instance = new static;
		}

		return static::$instance;
	}


}