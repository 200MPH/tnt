<?php

/* Minimal request that has to be send to TNT */

use thm\tnt_ec\service\ShippingService\ShippingService;

$shipping = new ShippingService('User ID', 'Password');

$shipping->setAccountNumber('') // will be provided by your TNT representative.
         ->createOptionalActivities() // this will generate <ACTIVITY> optional elements automatically.
         ->setSender()->setCompanyName('')
                      ->setAddressLine('')
                      ->setCity('')
                      ->setPostcode('')
                      ->setCountry('')
                      ->setContactName('')
                      ->setContactDialCode('')
                      ->setContactPhone('')
                      ->setContactEmail('');

$shipping->setCollection()->useSenderAddress() // use same addres as is for sender
                          ->setShipDate('19/01/2018')
                          ->setPrefCollectTime('10:00', '12:00')
                          ->setCollectInstruction('');

$c1 = $shipping->addConsignment()->setConReference('')
                                 ->setCustomerRef('')
                                 ->setContype('N')
                                 ->setPaymentind('S')
                                 ->setItems(0)
                                 ->setTotalWeight(0)
                                 ->setTotalVolume(0.00)
                                 ->setService('15N') // will be provided by your TNT representative.
                                 ->setDescription('')
                                 ->setDeliveryInstructions('');

$c1->setReceiver()->setCompanyName('')
                  ->setAddressLine('')
                  ->setAddressLine('')
                  ->setCity('')
                  ->setPostcode('')
                  ->setCountry('')
                  ->setContactName('')
                  ->setContactDialCode('')
                  ->setContactPhone('')
                  ->setContactEmail('');

$c1->useReceiverAddressForDelivery(); // make delivery address same as receiver

print_r($shipping);
print_r($shipping->getXmlContent());