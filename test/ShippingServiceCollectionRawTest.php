<?php

/* This is a place for testing Shipping functionality */

require_once __DIR__ . '/../vendor/autoload.php';
use thm\tnt_ec\service\ShippingService\ShippingService;

$shipping = new ShippingService('123', '123');

$shipping->setAccountCountryCode('GB')
         ->setAccountNumber('12345')
         ->setSender()->setCompanyName('Company Test')
                      ->setAddressLine('Address line 1')
                      ->setAddressLine('Address line 2')
                      ->setAddressLine('Address line 3')
                      ->setAddressLine('Should be excluded')
                      ->setCity('City')
                      ->setProvince('Province')
                      ->setPostcode('Post code')
                      ->setCountry('Country')
                      ->setVat('VAT')
                      ->setContactName('Contact name')
                      ->setContactDialCode('Dial code')
                      ->setContactPhone('Contact phone')
                      ->setContactEmail('Email');

$colOut = $shipping->setCollection()->useSenderAddress()
                          ->setShipDate('16/01/2018')
                          ->setPrefCollectTime('10:00', '12:00')
                          ->setAltCollectionTime('12:00', '14:00')
                          ->setCollectInstruction('Collection instructions')
                          ->getAsXml();

print_r($colOut);