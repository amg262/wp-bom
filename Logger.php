<?php
/**
 * Copyright (c) 2018. | WP Bill of Materials
 * andrewmgunn26@gmail.com | https://github.com/amg262/wp-bom
 */

/**
 * Created by PhpStorm.
 * User: mint
 * Date: 10/3/18
 * Time: 10:21 PM
 */

namespace Netraa\WPB;


class Logger {

	private $data = array();
	private $file;




	public function __construct($logger) {
	}

	protected function init() {

	}

	/**
	 * @return array
	 */
	public function getData(): array {
		return $this->data;
	}

	/**
	 * @param array $data
	 *
	 * @return Logger
	 */
	public function setData( array $data ): Logger {
		$this->data = $data;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getFile() {
		return $this->file;
	}

	/**
	 * @param mixed $file
	 *
	 * @return Logger
	 */
	public function setFile( $file ) {
		$this->file = $file;

		return $this;
	}




}