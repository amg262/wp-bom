<?php
/**
 * Created by PhpStorm.
 * User: mint
 * Date: 10/10/18
 * Time: 5:00 PM
 */

namespace Netraa\WPB\Endpoint;
require __DIR__ . '/includes/Endpoint/PartAPI.php';
require __DIR__ . '/includes/Endpoint/Example.php';

$api = PartAPI::get_instance();

function yeah() {
	$yeah = PartAPI::get_instance();
	$yeah->get_part( [ 'id' => 5632 ] );

	return $yeah;
}

echo json_encode( yeah() );