<?php 

require_once __DIR__ . '/../vendor/autoload.php';
use thm\tnt_ec\service\ShippingService\ShippingResultService;

$srs = new ShippingResultService('', '');

print_r($srs->getConsignmentNote());