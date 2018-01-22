<?php

require_once __DIR__ . '/../vendor/autoload.php';

$xml = new thm\tnt_ec\MyXMLWriter();
$xml->openMemory();
$xml->setIndent(true);
$xml->writeElementCData('TEST', 'Wrapped');
$xml->writeElementCData('PLAIN', 'Unwrapped', false);

print_r($xml->flush());
