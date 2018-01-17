<?php 

/* This is a place for testing Shipping functionality - request */

require_once __DIR__ . '/../vendor/autoload.php';
include_once 'ShippingServiceRawTests.php';

use thm\tnt_ec\service\ShippingService\ShippingService;

/* @var $shipping ShippingService */

$response = $shipping->send();

if($response->hasError() === true) {
    
    print_r( $response->getErrors() );
    
} else {
   
    print_r($response->getRequestXml() . PHP_EOL);
    print_r($response->getKey() . PHP_EOL);
    print_r($response->getActivityResult() . PHP_EOL);
    //print_r($response->getConsignmentNote() . PHP_EOL);
   
    
    if($response->hasError() === true) {
    
        print_r( $response->getErrors() );
    
    }
    
}

