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
                      ->setWeight(0)
                      ->addArticle();

.... if you need add details for customs

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

