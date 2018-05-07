

# Tracking Service Usage

## 1. Search criteria

You can search by: 
- consignment number which looks like GB123456789
  **searchByConsignment(array)**
 - customer reference number, your reference number **searchByCustomerReference(array)**
 - by date
 **searchByDate()**
 
## 2. Minimal request example

    use thm\tnt_ec\service\TrackingService\TrackingService;
    
    $ts = new TrackingService('login', 'password');
    
    $response = $ts->searchByConsignment(array('12345678'));
    
    if($response->hasError() === true) {
        
        foreach($response->getErrors() as $error) {
            
            print_r($error);
            
        }
        
    } 
    
    foreach ($response->getConsignments() as $consignment) {
    
        // you can output entire Consignment object for testing purpose
        print_r($consignment);
    
        foreach ($consignment->getStatuses() as $status) {
    
            // here is a tracking details
            var_dump($status->getStatusCode());
            var_dump($status->getStatusDescription());
            var_dump($status->getLocalEventDate());
            var_dump($status->getLocalEventTime());
            var_dump($status->getDepotCode());
            var_dump($status->getDepotName());
            
        }
    }

## 3. More detailed request

    use thm\tnt_ec\service\TrackingService\TrackingService;
    
    $ts = new TrackingService('login', 'password');
    
    // this will return more detailed response
    // for more details please read TNT documentation (link below)
    $ts->setLevelOfDetails()->setComplete()->setDestinationAddress()
                                           ->setOriginAddress()
                                           ->setPackage()
                                           ->setPod()
                                           ->setShipment();
    
    $response = $ts->searchByConsignment(array('12345678'));
    
    if($response->hasError() === true) {
        
        foreach($response->getErrors() as $error) {
            
            print_r($error);
            
        }
        
    } 
    
    foreach ($response->getConsignments() as $consignment) {
    
        // you can output entire Consignment object for testing purpose
        print_r($consignment);
    
        foreach ($consignment->getStatuses() as $status) {
    
            // here is a tracking details
            var_dump($status->getStatusCode());
            var_dump($status->getStatusDescription());
            var_dump($status->getLocalEventDate());
            var_dump($status->getLocalEventTime());
            var_dump($status->getDepotCode());
            var_dump($status->getDepotName());
            
        }
    }

## 4. International parcel tracking

For international tracking use this option:

    $ts->setMarketTypeInternational();

## 5. Output translations

Tracking information can be translated to some languages.
Use option:

    $ts->setLocale('DE');
Country code is a code of country you want translate to.

## 6. SSL certificate problem

In case when you experienced SSL certificate issue try disable SSL verification.

    $ts->disableSSLVerify();

Problem may occur on DEV machine.

## 7. TNT Documentation
For more details please read TNT documentation in the link below.
[https://github.com/200MPH/tnt/blob/develop/docs/Tracking/ExpressConnect_Tracking_V3_1.pdf](https://github.com/200MPH/tnt/blob/develop/docs/Tracking/ExpressConnect_Tracking_V3_1.pdf)
