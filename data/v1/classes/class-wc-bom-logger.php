<?php
/**
 * Created by PhpStorm.
 * User: andy
 * Date: 5/12/17
 * Time: 2:02 AM
 */

namespace WooBom;

class WC_Bom_Logger {

	private $file, $filedata, $log, $path;
	private $filename, $filepath, $filedir, $output, $unzipped;

	public function __construct() {
		//add_action('admin_init', [$this, 'init']);
		//$this->init();

	}

	public function init() {
		//$this->logger_write();

		$this->make_dir( WC_BOM_LOGS );
		//$this->write_file( date( 'mdy' ) . '_wcbom.log', " SSSBOOBS" );

		$this->write_file( 'beta.key', $this->keygen(), WC_BOM_LOGS, true );

	}

	public function make_dir( $dir ) {
		if ( mkdir( WC_BOM_LOGS ) ) {
			return true;
		}

		return false;
	}

	/**
	 * @param $filename
	 * @param $data
	 *
	 * @return bool|int|void
	 */
	public function write_file( $filename, $data, $dir = WC_BOM_LOGS, $overwrite = false ) {

		$this->filename = $filename;
		$this->filedir  = WC_BOM_LOGS;
		$this->filepath = WC_BOM_LOGS . $filename;
		$this->filedata = $data;
		$flag           = 'a+';

		if ( $overwrite === true || ! file_exists( $this->filepath ) ) {
			$flag = 'w+';
		}

		//$t = tmpfile();

		$this->file = fopen( $this->filepath, $flag );
		//fseek($f, SEEK_END);
		fwrite( $this->file, $this->filedata );
		fclose( $this->file );

	}

	public function keygen() {//$hashed_password = crypt( 'mypassword' ); // let the salt be automatically generated

		return md5( WC_BOM_BETA_KEY );

	}

	public function return_file( $filename, $array = false ) {

		$this->filename = $filename;
		$this->filedir  = WC_BOM_LOGS;
		$this->filepath = WC_BOM_LOGS . $filename;

		if ( $array !== true ) {
			$this->output = file_get_contents( $this->filepath );

		} else {
			$this->output = file( $this->filepath,
				FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES );
		}

		return $this->output;
	}

	public function generate_key() {
		$string1 = substr( md5( uniqid( mt_rand(), true ) ), - 5, 5 );
		$string2 = substr( md5( uniqid( mt_rand(), true ) ), - 5, 5 );
		$string3 = substr( md5( uniqid( mt_rand(), true ) ), - 5, 5 );
		$string4 = substr( md5( uniqid( mt_rand(), true ) ), - 5, 5 );
		$serial  = sprintf( '%s-%s-%s-%s', $string1, $string2, $string3, $string4 );

		return $serial;
	}

	public function send_email( $message ) {
		$current_user = wp_get_current_user();

		$headers     = [
			'Reply-To: ' . WC_BOM_ADMIN . ' <' . WC_BOM_ADMIN_EMAIL . '>',
		];
		$subject     = 'WooBOM - ' . date( 'dmy H:i:s' );
		$attachments = [ WC_BOM_LOGS . '/license.key' ];
		wp_mail( 'andrewmgunn26@gmail.com', $subject, $message );
	}

	public
	function compare_data() {

	}

	public
	function get_filepath() {
		return $this->filepath;
	}

	public
	function get_filename() {
		return $this->filename;
	}

	public
	function get_filedata() {
		return $this->filedata;
	}

	public
	function get_file() {
		return $this->file;
	}

	public
	function get_output() {
		return $this->output;
	}

	public
	function scramble(
		$data
	) {
		return base64_encode( str_rot13( base64_encode( $data ) ) );
	}

	public
	function unscramble(
		$data
	) {
		return base64_decode( str_rot13( base64_decode( $data ) ) );
	}

	public
	function crunch(
		$data
	) {
		return gzdeflate( base64_encode( str_rot13( $data ) ) );
	}

	public
	function uncrunch(
		$data
	) {
		return str_rot13( base64_decode( gzinflate( $data ) ) );
	}
}

$log = new WC_Bom_Logger();
