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

	protected static $instance = null;


	private $key = [
		'JWLjSLgQWae9nC40ba03',
		'EJABkBerVznfSfADbQvj',
		'BoJnxPvcWdOI9tZCLxZ3',
		'lvce7bnWQK9USvHkTZPD',
		'owQIF748mlJPBNoDN7jd',
		'rRpSK1zFqjpHZ78Px0R2',
		'7N5Arm5HQkrkgwQqVDdT',
		'ErfLXa4h9wh0JKS2EXOy',
		'2b02E2B8LFaGnnw0hZD6',
		'8tW4TZXNcoVFo1Vhxa18',
	];
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