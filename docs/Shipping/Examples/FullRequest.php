<?php

/**
 * FULL REQUEST - all fields populate
 */

use thm\tnt_ec\service\ShippingService\ShippingService;

$shipping = new ShippingService('User ID', 'Password');

$shipping->setAccountNumber('')
         ->autoActivity() // this will generate <ACTIVITY> element autmatically.
         ->setSender()->setCompanyName('')
                      ->setAddressLine('')
                      ->setAddressLine('')
                      ->setAddressLine('')
                      ->setAddressLine('')
                      ->setCity('')
                      ->setProvince('')
                      ->setPostcode('')
                      ->setCountry('')
                      ->setVat('')
                      ->setContactName('')
                      ->setContactDialCode('')
                      ->setContactPhone('')
                      ->setContactEmail('');

$shipping->setCollection()->useSenderAddress() // use same addres as is for sender
                          ->setShipDate('19/01/2018')
                          ->setPrefCollectTime('10:00', '12:00')
                          ->setAltCollectionTime('12:00', '14:00')
                          ->setCollectInstruction('');

$c1 = $shipping->addConsignment()->setConReference('')
                           ->setCustomerRef('')
                           ->setContype('N')
                           ->setPaymentind('S')
                           ->setItems(0)
                           ->setTotalWeight(0.00)
                           ->setTotalVolume(0.00)
                           ->setCurrency('GBP')
                           ->setGoodsValue(0.00)
                           ->setInsuranceValue(0.00)
                           ->setInsuranceCurrency('GBP')
                           ->setService('15N')
                           ->addOption('PR')
                           ->setDescription('')
                           ->setDeliveryInstructions('');
                           //->hazardous(1234);

$c1->setReceiver()->setCompanyName('')
                  ->setAddressLine('')
                  ->setAddressLine('')
                  ->setAddressLine('')
                  ->setAddressLine('')
                  ->setCity('')
                  ->setProvince('')
                  ->setPostcode('')
                  ->setCountry('')
                  ->setVat('')
                  ->setContactName('')
                  ->setContactDialCode('')
                  ->setContactPhone('')
                  ->setContactEmail('');

$c1->setReceiverAsDelivery(); // make delivery address same as receiver

$c1->addPackage()->setItems(0)
                 ->setDescription('')
                 ->setLength(0.00)
                 ->setHeight(0.00)
                 ->setWidth(0.00)
                 ->setWeight(0)
                 ->addArticle()->setItems(0)
                               ->setDescription('')
                               ->setWeight(0.00)
                               ->setInvoiceValue(0.00)
                               ->setInvoiceDescription('')
                               ->setHts(0)
                               ->setCountry('GB')
                               ->setEmrn('');

//print_r($shipping);
//print_r($shipping->getXmlContent());
