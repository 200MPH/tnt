<?php

/* TNT Tracking RAW test */

require_once __DIR__ . '/../../vendor/autoload.php';
use thm\tnt_ec\service\TrackingService\TrackingService;

$ts = new TrackingService('user', 'password');

$response = $ts->searchByConsignment(array('37148969'));

if($response->hasError() === true) {
    
    print_r($response->getErrors());
    
} 
    
foreach($response->getConsignments() as $consignment) {

    print_r($consignment->getStatuses());
    
}

