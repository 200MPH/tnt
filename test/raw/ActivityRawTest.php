<?php

/* Place to test Activity class */

require_once __DIR__ . '/../../vendor/autoload.php';
use thm\tnt_ec\service\ShippingService\Activity;

$consignment = '123456789';
$activity = new Activity('test', 'test');
$activity->create($consignment)
         ->book($consignment, true)
         ->rate($consignment)
         ->ship($consignment)
         ->printAll($consignment)
         ->showGroupCode();

print_r($activity->getXmlContent());