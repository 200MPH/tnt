<?php

/* TNT Tracking RAW test with POD file */

require_once __DIR__ . '/../../vendor/autoload.php';
use thm\tnt_ec\service\TrackingService\TrackingService;

$ts = new TrackingService('', '');

// add this line to get POD in response
$ts->setLevelOfDetails()->setComplete()->setPod();

$response = $ts->searchByConsignment(array('37148969'));

if($response->hasError() === true) {
    
    print_r($response->getErrors());
    
} 
    
foreach($response->getConsignments() as $consignment) {

    // get POD URL
    // URL is valid for 2 hours only !
    print_r($consignment->getPod());
    
    // get file content
    print_r($consignment->getPod(true));
    
}

