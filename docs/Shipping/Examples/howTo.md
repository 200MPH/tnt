# Shipping Service Usage Examples

## 1. Minimal request
**NOTE!** You cannot skip any of below code, otherwise you will get a TNT errors.
Sender address must be real. Must match the details assigned to TNT account number.
TNT validation is very accurate. Put real postcode and country code, otherwise your request will be rejected and you will receive errors :)
Read the comments in the below code and PHP documentor. Each method functionality is described.

    use thm\tnt_ec\service\ShippingService\ShippingService;
    
    $shipping = new ShippingService('User ID', 'Password');
    
    $shipping->setAccountNumber('') // TNT account number assigned to your company
             ->autoActivity() // this will generate <ACTIVITY> element autmatically.
             ->setSender()->setCompanyName('Your company')
                          ->setAddressLine('Address 1')
                          ->setAddressLine('Address 2')
                          ->setCity('')
                          ->setPostcode('')
                          ->setCountry('')
                          ->setContactName('')
                          ->setContactDialCode('')
                          ->setContactPhone('')
                          ->setContactEmail('');
    
    $shipping->setCollection()->useSenderAddress() // use same addres as is for sender, this makes your life easier :)
                              ->setShipDate('19/01/2018') // must have DD/MM/YYYY 
                              ->setPrefCollectTime('10:00', '12:00')
                              ->setCollectInstruction(''); // no instruction? leave empty
    
    $c1 = $shipping->addConsignment()->setConReference('') // if your app generate consignment number use setConNumber('GB123456789') instead
                                     ->setCustomerRef('Weborder_123456')
                                     ->setContype('N')
                                     ->setPaymentind('S') // who pays for shipping S-sender, R-receiver
                                     ->setItems(0)
                                     ->setTotalWeight(0)
                                     ->setTotalVolume(0.00)
                                     ->setService('15N')
                                     ->setDescription('')
                                     ->setDeliveryInstructions('');
    
    $c1->setReceiver()->setCompanyName('Receiver address. NOT DELIVERY!')
                      ->setAddressLine('')
                      ->setAddressLine('')
                      ->setCity('')
                      ->setPostcode('')
                      ->setCountry('')
                      ->setContactName('')
                      ->setContactDialCode('')
                      ->setContactPhone('')
                      ->setContactEmail('');
    
    $c1->setReceiverAsDelivery(); // make delivery address same as receiver
 That's it.

## 2. Non EU shipping

 For shipping outside EU you need to add package details.
 Here is the code:

     $c1->addPackage()->setItems(0)
                      ->setDescription('')
                      ->setLength(0.00)
                      ->setHeight(0.00)
                      ->setWidth(0.00)
                      ->setWeight(0);

.... and something extra for customs ...

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

## 3. Hazardous goods
If you sending hazardous goods, add this code:

    $c1 = $shipping->hazardous(uncode);

## 4. Full request

    Here is full request, all options that you can send to TNT database.
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
  
    print_r($shipping->getXmlContent());

## 5. Response
OK, we have to send prepared request first.

    $response = $shipping->send();
Catch the result ...

    if($response->hasError() === true) {
        
        print_r( $response->getErrors() );
        
    } else {
       
        print_r($response->getResults());
        
        // get label
        //$response->getLabel();
        
        // get manifest
        //$response->getManifest();
        
        // get consignment note
        //$response->getConsignmentNote();
        
        // get invoice
        //$response->getInvoice();
        
    }

## 6. SSL certificate problem
In case when you experienced SSL certificate issue try disable SSL verification.

    $shipping->disableSSLVerify();

Problem may occur on DEV machine.

## 7. TNT Documentation

For more details please read TNT documentation
[https://github.com/200MPH/tnt/blob/develop/docs/Shipping/ExpressConnect%20Shipping%20Integration%20Guide%20v3.8.pdf](https://github.com/200MPH/tnt/blob/develop/docs/Shipping/ExpressConnect%20Shipping%20Integration%20Guide%20v3.8.pdf)
 
