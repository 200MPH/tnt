<?php

/* This is a place for testing Shipping functionality */

require_once __DIR__ . '/../vendor/autoload.php';
use thm\tnt_ec\service\ShippingService\ShippingService;

$shipping = new ShippingService('CLINICHA_T', 'tnt12345');

$shipping->setAccountNumber('085061203')
         ->autoActivity()
         ->setSender()->setCompanyName('Clinichain')
                      ->setAddressLine('Draaibrugweg 19')
                      ->setCity('Almere')
                      ->setPostcode('1332 AB')
                      ->setCountry('NL')
                      ->setContactName('Aren')
                      ->setContactDialCode('123')
                      ->setContactPhone('123')
                      ->setContactEmail('support@clinichain.com');

$shipping->setCollection()->useSenderAddress()
                          ->setShipDate('19/01/2018')
                          ->setPrefCollectTime('10:00', '12:00')
                          ->setAltCollectionTime('14:00', '16:00')
                          ->setCollectInstruction('');

$c1 = $shipping->addConsignment()->setConReference('CC123456789')
                                 ->setCustomerRef('WEB543467')
                                 ->setContype('N')
                                 ->setPaymentind('S')
                                 ->setItems(1)
                                 ->setTotalWeight(7)
                                 ->setTotalVolume(0.02)
                                 ->setCurrency('EUR')
                                 ->setGoodsValue(100.00)
                                 ->setInsuranceValue(100.00)
                                 ->setInsuranceCurrency('EUR')
                                 ->setService('15N')
                                 ->addOption('PR')
                                 ->setDescription('Computer parts')
                                 ->setDeliveryInstructions('To reception please');

$c1->setReceiver()->setCompanyName('Mr. W Brozyna')
                  ->setAddressLine("Flat 9")
                  ->setAddressLine("17 Mansel Road East")
                  ->setCity('Southampton')
                  ->setPostcode('SO16 9DN')
                  ->setCountry('GB')
                  ->setContactName('Wojtek')
                  ->setContactDialCode('0044')
                  ->setContactPhone('07554825907')
                  ->setContactEmail('wojciech.brozyna@gmail.com');

$c1->setReceiverAsDelivery();

$c1->addPackage()->setItems(1)
                 ->setDescription('Computer parts - mtb')
                 ->setLength(0.30)
                 ->setHeight(0.20)
                 ->setWidth(0.15)
                 ->setWeight(7);

//print_r($shipping);
//print_r($shipping->getXmlContent());
