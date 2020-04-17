<?php

/* TNT Tracking RAW test */

require_once __DIR__ . '/../../vendor/autoload.php';
use thm\tnt_ec\service\TrackingService\TrackingService;

$ts = new TrackingService('ISL-TNT-ET', 'CorvetteCT');

$response = $ts->searchByConsignment(array('37148969'));

if ($response->hasError() === true) {
    print('Errors: ' . PHP_EOL);
    print_r($response->getErrors());
}
    
foreach ($response->getConsignments() as $consignment) {
    print_r($consignment->getStatuses());
}
