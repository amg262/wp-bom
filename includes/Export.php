<?php
/**
 * Created by PhpStorm.
 * User: mint
 * Date: 10/3/18
 * Time: 1:22 PM
 */

namespace Netraa\WPB;


class Export {

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