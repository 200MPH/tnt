<?php

require_once __DIR__ . '/vendor/autoload.php';

use thm\tnt_ec\Service\TrackingService\TrackingService;
use thm\tnt_ec\TNTException;

try {

    $ts = new TrackingService('abc', '123');
    
    $ts->setLevelOfDetails()
       ->setComplete()
       ->setDestinationAddress()
       ->setOriginAddress()
       ->setPackage()
       ->setShipment()
       ->setPod();
    
    $response1 = $ts->searchByDate('111111', '222222', 3);
    //$response2 = $ts->searchByConsignment(array('1234567890'));
    
    print_r($response1->getErrors());
    //print_r($response2->getRequestXml());
    
} catch(TNTException $e) {
    
    print($e->getMessage());
    
}
