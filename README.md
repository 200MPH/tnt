# tnt
TNT ExpressConnect PHP client

This client is still under development therfore support tracking facility for now.

Simple Usage:

```
use thm\tnt_ec\Service\TrackingService\TrackingService;

$ts = new TrackingService('login', 'password');

$response = $ts->searchByConsignment(array('12345678'));

print_r($response->getErrors());

foreach($response->getConsignments() as $consignment) {

  print_r($consignment);

  foreach($consignment->getStatuses as $status) {
  
    var_dump($status->getStatusCode());
    var_dump($status->getStatusDescription);
    var_dump($status->getLocalEventDate());
    var_dump($status->getLocalEventTime());
    var_dump($status->getDepotCode());
    var_dump($status->getDepotName());
  
  }

}

```
