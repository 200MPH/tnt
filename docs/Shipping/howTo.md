## 1. Minimal request
**NOTE!** You cannot skip any of below code, otherwise you will get a TNT errors.
Sender address must be real. Must match the details assigned to TNT account number.
TNT validation is very accurate. Put real postcode and country code, otherwise your request will be rejected and you will receive errors :)
Read the comments in the below code and PHP documentor. Each method functionality is described.
**This version is not compatible with previous one and support PHP 7. The way to obtain activity data has also changed.**

    use thm\tnt_ec\service\ShippingService\ShippingService;
    
    $shipping = new ShippingService('User ID', 'Password');
    
    $shipping->setAccountNumber('') // TNT account number assigned to your company
             ->createOptionalActivities() // this will create <ACTIVITY> optional element automatically. For basic request, call this method all the time.
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
    
    $shipping->setCollection()->useSenderAddress() // use same address as is for sender, this makes your life easier :)
                              ->setShipDate('19/01/2018') // must have DD/MM/YYYY 
                              ->setPrefCollectTime('10:00', '12:00')
                              ->setCollectInstruction(''); // no instruction? leave empty
    
    $c1 = $shipping->addConsignment()->setConReference('') // if your application generate consignment number use setConNumber('GB123456789') instead
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

You can add multiple consignments to the request

    $c2 = $shipping->addConsignment();
    $c3 = $shipping->addConsignment();
    ... and so on.

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

## 4. Raw request.

You can also send raw XML, without using object setters.
    
    $shipping = new ShippingService('User ID', 'Password');
    $shipping->setXmlContent($your_xml);
    $response = $shipping->send();

## 5. Full request

    Here is full request, all options that you can send to TNT API.
    use thm\tnt_ec\service\ShippingService\ShippingService;
    
    $shipping = new ShippingService('User ID', 'Password');
    
    $shipping->setAccountNumber('')
             ->createOptionalActivities() // this will create <ACTIVITY> optional element automatically. For basic request, call this method all the time.
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

    $c1->setDelivery()->setCompanyName('')
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
    
    /* If delivery address is the same as receiver, simply use $c1->setReceiverAsDelivery() instead */
    
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

## 6. Response

There is two ways to obtain data.
- INSTANT - Will return response data (Activities) instantly after success request
- LAZY - You can get Activity data later by using received key received after success request. Key is valid for 26 days.

**INSTANT method**

You must send the shipping request first.

    $response = $shipping->send(); 

... now you can process TNT response
	
    // below method is good to check what activities are available to process
    print_r($response->getActivity()->getResults());
    // get label
    print_r($response->getActivity()->getLabel());
    // get manifest
    print_r($response->getActivity()->getManifest());
    // get invoice
    print_r($response->getActivity()->getInvoice());
    // get consignment note
    print_r($response->getActivity()->getConsignmentNote());
Above methods returns ActivityResponse object instance. 
Most likely you would need to call getErrors(), getResponse() or getResponseXml() to obtain specific data.
Example: 
	
    print_r( $response->getActivity()->getLabel()->getErrors() );
    print_r( $response->getActivity()->getLabel()->getRequestXml() );

**LAZY method**
You must send the shipping request first.

    $response = $shipping->send(); 

Catch the KEY code and store it in your database.

    $key = $response->getKey();

Use previously obtained key.
The key must be pass as a constructor parameter to Activity object.

    use thm\tnt_ec\service\ShippingService\Activity;
    $activity = Activity('user', 'password', $key);

Now you can call activity method.

    print_r($response->getActivity()->getResults());
    // get label
    print_r($response->getActivity()->getLabel());
    // get manifest
    print_r($response->getActivity()->getManifest());
    // get invoice
    print_r($response->getActivity()->getInvoice());
    // get consignment note
    print_r($response->getActivity()->getConsignmentNote());
## 7. GROUP functionality 
TNT provide facilities for group shipments (described in TNT documentation).
In my opinion working with "single" shipments is faster than grouped ones, therefore I'm not going to describe step by step GROUP functionality here.
However if you would like give a try with this package then please create a ticket or drop me an e-mail so I will update this section.
## 8. XML Conversion
This package comes with simple XML conversion tool which let you convert XML to other formats.
The format list will be extended in the future.

    use thm\tnt_ec\XmlConverter;
    $xml = new XmlConverter( $xml_string );
    $xml->toString();
    $xml->toXml();
    print($xml); //produce string output

## 9. SSL certificate problem
In case when you experienced SSL certificate issue try disable SSL verification.

    $shipping->disableSSLVerify();

Problem may occur on development environment.

## 10. TNT Documentation

For more details please read TNT documentation.
[https://github.com/200MPH/tnt/blob/develop/docs/Shipping/ExpressConnect%20Shipping%20Integration%20Guide%20v3.8.pdf](https://github.com/200MPH/tnt/blob/develop/docs/Shipping/ExpressConnect%20Shipping%20Integration%20Guide%20v3.8.pdf)
 