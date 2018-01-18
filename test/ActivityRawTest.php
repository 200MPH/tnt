<?php

/* Place to test Activity class */

require_once __DIR__ . '/../vendor/autoload.php';
use thm\tnt_ec\service\ShippingService\Activity;

$a = new Activity(123, 123);

$a->book('123')
  ->create('123')
  ->ship('123')
  ->printConsignmentNote('123')
  ->printLabel('123')
  ->printManifest('123');

print_r($a->getXmlContent(false));
