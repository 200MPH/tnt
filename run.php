<?php

require_once __DIR__ . '/vendor/autoload.php';

use thm\tnt_ec\Service\TrackingService\TrackingService;
use thm\tnt_ec\TNTException;

try {

    $ts = new TrackingService('ISL-TNT-EC', 'CorvetteC7');
    
    $response = $ts->searchByConsignment(array('37115206'));
    
    foreach($response->getConsignments() as $csg) {
        
        foreach($csg->getStatuses() as $status) {
            
            print_r($status);
            
        }
        
    }
        
} catch(TNTException $e) {
    
    print($e->getMessage());
    
}
