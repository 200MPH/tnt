<?php

use thm\tnt_ec\service\ShippingService\ShippingService;

/* @var $shipping ShippingService */

$shipping = new ShippingService('abc', 'abs');
/*
 * Create ShippingService object first or import from another file
 *  
 *  populate the object .... see MinimalResponse.php
 *   
 */

$response = $shipping->send();

if($response->hasError() === true) {
    
    print_r( $response->getErrors() );
    
} else {
   
    print_r($response->getResults());
    
    // get label
    //$response->getLabel();
    
    // get manifest
    //$response->getManifest();
    
    // get consignment note
    //$response->getConsignmentNote();
    
    // get invoice
    //$response->getInvoice();
    
}