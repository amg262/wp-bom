<?php

namespace Devtech\License;

include_once 'Generator.php';
include_once 'License.php';
include_once 'Validator.php';

/**
 * Description of Test
 *
 * @author jpuchky
 */

/*
 * Generate License KEY
 */

$generator = new Generator();
$license = new License("Juraj Puchký", "10.5.2018", "License Test", "1239", "test.devtech.cz");
$licenseKey = $generator->generate($license);
file_put_contents("license.txt", $licenseKey);

/*
 * Validation of License KEY
 */

$licenseKey = file_get_contents("license.txt");
$license = new License("Juraj Puchký", "10.5.2018", "License Test", "1239", $_SERVER['SERVER_NAME']);
$validator = new Validator();
if($validator->validate($license, $licenseKey)) {
    echo "License is VALID\n";
} else {
    echo "License is not VALID\n";
}