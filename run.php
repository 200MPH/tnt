<?php

require_once __DIR__ . '/vendor/autoload.php';

use thm\tnt_ec\Service\TrackingService\TrackingService;
use thm\tnt_ec\TNTException;

try {

    $ts = new TrackingService('ISL-TNT-EC', 'CorvetteC7');
    
    $ts->setLevelOfDetails()->setComplete()->setPod();
    
    $response = $ts->searchByConsignment(array('37114476'));
    print_r($response->getRequestXml());
    print_r($response->getResponseXml());
    foreach($response->getConsignments() as $csg) {
        
        print_r($csg);
        
    }
        
    print_r($response->getErrors());
    
} catch(TNTException $e) {
    
    print($e->getMessage());
    
}
