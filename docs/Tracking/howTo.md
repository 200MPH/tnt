

# Tracking Service Usage:

## 1. Minimal

    use thm\tnt_ec\service\TrackingService\TrackingService;
    
    $ts = new TrackingService('login', 'password');
    
    $response = $ts->searchByConsignment(array('12345678'));
    
    // simple error handling
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

[Here is full TNT documentation https://express.tnt.com/expresswebservices-website/docs/ExpressConnect_Tracking_V3_1.pdf](Here%20is%20full%20TNT%20documentation%20https://express.tnt.com/expresswebservices-website/docs/ExpressConnect_Tracking_V3_1.pdf)

