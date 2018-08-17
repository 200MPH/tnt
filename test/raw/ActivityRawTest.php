<?php

/* This is a place for testing Activity functionality */

require_once __DIR__ . '/../../vendor/autoload.php';

use thm\tnt_ec\service\ShippingService\Activity;

$activity = new Activity('user', 'password', 0);

print_r($activity->getResults());
print_r($activity->getLabel()->getResponse());
print_r($activity->getInvoice()->getResponse());
print_r($activity->getManifest()->getResponse());
print_r($activity->getConsignmentNote()->getResponse());