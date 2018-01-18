<?php

/* This is a place for testing Shipping functionality */

require_once __DIR__ . '/../vendor/autoload.php';
use thm\tnt_ec\service\ShippingService\ShippingService;

$shipping = new ShippingService('CLINICHA_T', 'tnt12345');

$shipping->setAccountNumber('085061203')
         ->autoActivity()
         ->setSender()->setCompanyName('Company name')
                      ->setAddressLine('Address line 1')
                      ->setAddressLine('Address line 2')
                      ->setAddressLine('Address line 3')
                      ->setAddressLine('Should be exxluded')
                      ->setCity('City')
                      ->setProvince('Province')
                      ->setPostcode('Post code')
                      ->setCountry('Country')
                      ->setVat('123123')
                      ->setContactName('Aren')
                      ->setContactDialCode('Dial code')
                      ->setContactPhone('Contact phone')
                      ->setContactEmail('Email');

$shipping->setCollection()->useSenderAddress()
                          ->setShipDate('16/01/2018')
                          ->setPrefCollectTime('10:00', '12:00')
                          ->setAltCollectionTime('12:00', '14:00')
                          ->setCollectInstruction('Collection instructions');

$c1 = $shipping->addConsignment()->setConReference('CON 123')
                           ->setCustomerRef('Custome ref')
                           ->setContype('N')
                           ->setPaymentind('S')
                           ->setItems(1)
                           ->setTotalWeight(7)
                           ->setTotalVolume(0.02)
                           ->setCurrency('GBP')
                           ->setGoodsValue(100.00)
                           ->setInsuranceValue(100.00)
                           ->setInsuranceCurrency('GBP')
                           ->setService('15N')
                           ->addOption('PR')
                           ->setDescription('Computer parts')
                           ->setDeliveryInstructions('To reception please');
                           //->hazardous(1234);

$c1->setReceiver()->setCompanyName('RCV Company Name')
                  ->setAddressLine('RCV Address line 1')
                  ->setAddressLine('RCV Address line 2')
                  ->setAddressLine('RCV Address line 3')
                  ->setAddressLine('RCV Should be exxluded')
                  ->setCity('RCV City')
                  ->setProvince('RCV Province')
                  ->setPostcode('RCV Post code')
                  ->setCountry('RCV Country')
                  ->setVat('RCV VAT')
                  ->setContactName('RCV Contact name')
                  ->setContactDialCode('RCV Dial code')
                  ->setContactPhone('RCV Contact phone')
                  ->setContactEmail('RCV Email');

$c1->setReceiverAsDelivery();

$c1->addPackage()->setItems(1)
                 ->setDescription('Computer parts - mtb')
                 ->setLength(0.30)
                 ->setHeight(0.20)
                 ->setWidth(0.15)
                 ->setWeight(7)
                 ->addArticle()->setItems(1)
                               ->setDescription('Item desc')
                               ->setWeight(0.6)
                               ->setInvoiceValue(55.45)
                               ->setInvoiceDescription('GTFR345')
                               ->setHts(123)
                               ->setCountry('GB')
                               ->setEmrn('abc');

//print_r($shipping);
//print_r($shipping->getXmlContent());
