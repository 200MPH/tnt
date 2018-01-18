<?php 

/* This is a place for testing Shipping functionality - request */

require_once __DIR__ . '/../vendor/autoload.php';
include_once 'CliniTest.php';

use thm\tnt_ec\service\ShippingService\ShippingService;

/* @var $shipping ShippingService */


//$xml = simplexml_load_file('./ShippingResponseXml.xml');
//print_r($xml);

$response = $shipping->send();

if($response->hasError() === true) {
    
    print_r( $response->getErrors() );
    
} else {
   
    //print_r($response->getResponse() . PHP_EOL);
    print_r($response->getResults());
          
}

