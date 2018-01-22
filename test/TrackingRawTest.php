<?php

/* TNT Tracking RAW test */

require_once __DIR__ . '/../vendor/autoload.php';
use thm\tnt_ec\service\TrackingService\TrackingService;

$ts = new TrackingService('User ID', 'Password');

$response = $ts->searchByConsignment(array('37115170'));

print_r($response->getErrors());

foreach($response->getConsignments() as $consignment) {

  print_r($consignment);
 
  foreach($consignment->getStatuses() as $status) {
      
      print(PHP_EOL);
      
      print($status->getStatusCode() . PHP_EOL);
      print($status->getStatusDescription() . PHP_EOL);
      print($status->getLocalEventDate() . PHP_EOL);
      print($status->getLocalEventTime() . PHP_EOL);
      print($status->getDepotCode() . PHP_EOL);
      print($status->getDepotName() . PHP_EOL);
  
  }

}


