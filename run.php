<?php

//require_once __DIR__ . '/vendor/autoload.php';
//
//use thm\tnt_ec\Service\TrackingService\TrackingService;
//use thm\tnt_ec\TNTException;
//
//try {
//
//    $ts = new TrackingService('abc', '123');
//    
//    $ts->setLevelOfDetails()
//       ->setComplete()
//       ->setDestinationAddress()
//       ->setOriginAddress()
//       ->setPackage()
//       ->setShipment()
//       ->setPod();
//    
//    $response1 = $ts->searchByDate('111111', '222222', 3);
//    //$response2 = $ts->searchByConsignment(array('1234567890'));
//    
//    print_r($response1->getErrors());
//    //print_r($response2->getRequestXml());
//    
//} catch(TNTException $e) {
//    
//    print($e->getMessage());
//    
//}

$xml = '<?xml version="1.0" encoding="utf-8"?>
<TrackResponse>
  <Consignment access="public">
    <ConsignmentNumber>123456782</ConsignmentNumber>
    <OriginDepot>AMS</OriginDepot>
    <OriginDepotName>
      <![CDATA[Amsterdam]]>
    </OriginDepotName>
    <CollectionDate format="YYYYMMDD">20161014</CollectionDate>
    <DeliveryTown>
      <![CDATA[HEMELUM]]>
    </DeliveryTown>
    <SummaryCode>EXC</SummaryCode>
    <DestinationCountry>
      <CountryCode>NL</CountryCode>
      <CountryName>
        <![CDATA[Netherlands]]>
      </CountryName>
    </DestinationCountry>
    <OriginCountry>
      <CountryCode>KR</CountryCode>
      <CountryName>
        <![CDATA[South Korea]]>
      </CountryName>
    </OriginCountry>
    <PieceQuantity>1</PieceQuantity>
    <StatusData>
      <StatusCode>AA</StatusCode>
      <StatusDescription>
        <![CDATA[Duplicate Or Non-existent Consignment Record In System]]>
      </StatusDescription>
      <LocalEventDate format="YYYYMMDD">20161014</LocalEventDate>
      <LocalEventTime format="HHMM">1417</LocalEventTime>
      <Depot>SP8</Depot>
      <DepotName>
        <![CDATA[Amsterdam Depot]]>
      </DepotName>
    </StatusData>
  </Consignment>
  <Consignment access="public">
    <ConsignmentNumber>123456782</ConsignmentNumber>
    <OriginDepot>LGE</OriginDepot>
    <OriginDepotName>
      <![CDATA[Liege]]>
    </OriginDepotName>
    <CustomerReference>
      <![CDATA[2016012659]]>
    </CustomerReference>
    <CollectionDate format="YYYYMMDD">20160905</CollectionDate>
    <DeliveryTown>
      <![CDATA[BERTRANGE]]>
    </DeliveryTown>
    <DeliveryDate format="YYYYMMDD">20160908</DeliveryDate>
    <DeliveryTime format="HHMM">1436</DeliveryTime>
    <Signatory>
      <![CDATA[]]>
    </Signatory>
    <SummaryCode>DEL</SummaryCode>
    <DestinationCountry>
      <CountryCode>LU</CountryCode>
      <CountryName>
        <![CDATA[Luxembourg]]>
      </CountryName>
    </DestinationCountry>
    <OriginCountry>
      <CountryCode>BE</CountryCode>
      <CountryName>
        <![CDATA[Belgium]]>
      </CountryName>
    </OriginCountry>
    <PieceQuantity>2</PieceQuantity>
    <StatusData>
      <StatusCode>PA</StatusCode>
      <StatusDescription>
        <![CDATA[Delivery By Mail. Delivery Confirmation Available On Request]]>
      </StatusDescription>
      <LocalEventDate format="YYYYMMDD">20160908</LocalEventDate>
      <LocalEventTime format="HHMM">1436</LocalEventTime>
      <Depot>ZRH</Depot>
      <DepotName>
        <![CDATA[Zurich]]>
      </DepotName>
    </StatusData>
    <StatusData>
      <StatusCode>NR</StatusCode>
      <StatusDescription>
        <![CDATA[Shipment Delayed In Transit Recovery Actions Underway]]>
      </StatusDescription>
      <LocalEventDate format="YYYYMMDD">20160907</LocalEventDate>
      <LocalEventTime format="HHMM">0954</LocalEventTime>
      <Depot>LUX</Depot>
      <DepotName>
        <![CDATA[Luxembourg]]>
      </DepotName>
    </StatusData>
  </Consignment>
  <Consignment access="public">
    <ConsignmentNumber>123456782</ConsignmentNumber>
    <OriginDepot>MAD</OriginDepot>
    <OriginDepotName>
      <![CDATA[Madrid]]>
    </OriginDepotName>
    <CollectionDate format="YYYYMMDD">20161020</CollectionDate>
    <DeliveryTown>
      <![CDATA[SWADLINCOTE]]>
    </DeliveryTown>
    <DeliveryDate format="YYYYMMDD">20161025</DeliveryDate>
    <DeliveryTime format="HHMM">1003</DeliveryTime>
    <Signatory>
      <![CDATA[jones]]>
    </Signatory>
    <SummaryCode>DEL</SummaryCode>
    <DestinationCountry>
      <CountryCode>GB</CountryCode>
      <CountryName>
        <![CDATA[United Kingdom]]>
      </CountryName>
    </DestinationCountry>
    <OriginCountry>
      <CountryCode>ES</CountryCode>
      <CountryName>
        <![CDATA[Spain]]>
      </CountryName>
    </OriginCountry>
    <PieceQuantity>2</PieceQuantity>
    <StatusData>
      <StatusCode>OK</StatusCode>
      <StatusDescription>
        <![CDATA[Shipment Delivered In Good Condition.]]>
      </StatusDescription>
      <LocalEventDate format="YYYYMMDD">20161025</LocalEventDate>
      <LocalEventTime format="HHMM">1003</LocalEventTime>
      <Depot>LC4</Depot>
      <DepotName>
        <![CDATA[Leicester]]>
      </DepotName>
    </StatusData>
    <StatusData>
      <StatusCode>OD</StatusCode>
      <StatusDescription>
        <![CDATA[Out For Delivery.]]>
      </StatusDescription>
      <LocalEventDate format="YYYYMMDD">20161025</LocalEventDate>
      <LocalEventTime format="HHMM">0730</LocalEventTime>
      <Depot>LC4</Depot>
      <DepotName>
        <![CDATA[Leicester]]>
      </DepotName>
    </StatusData>
    <StatusData>
      <StatusCode>IR</StatusCode>
      <StatusDescription>
        <![CDATA[Shipment Received At Tnt Location]]>
      </StatusDescription>
      <LocalEventDate format="YYYYMMDD">20161025</LocalEventDate>
      <LocalEventTime format="HHMM">0330</LocalEventTime>
      <Depot>LC4</Depot>
      <DepotName>
        <![CDATA[Leicester]]>
      </DepotName>
    </StatusData>
    <StatusData>
      <StatusCode>AS</StatusCode>
      <StatusDescription>
        <![CDATA[Shipment Received At Transit Point.]]>
      </StatusDescription>
      <LocalEventDate format="YYYYMMDD">20161024</LocalEventDate>
      <LocalEventTime format="HHMM">1850</LocalEventTime>
      <Depot>NXH</Depot>
      <DepotName>
        <![CDATA[Northampton Hub]]>
      </DepotName>
    </StatusData>
    <StatusData>
      <StatusCode>TR</StatusCode>
      <StatusDescription>
        <![CDATA[Shipment In Transit.]]>
      </StatusDescription>
      <LocalEventDate format="YYYYMMDD">20161024</LocalEventDate>
      <LocalEventTime format="HHMM">1753</LocalEventTime>
      <Depot>NXH</Depot>
      <DepotName>
        <![CDATA[Northampton Hub]]>
      </DepotName>
    </StatusData>
    <StatusData>
      <StatusCode>LAA</StatusCode>
      <StatusDescription>
        <![CDATA[Delay Due To Authorities. Recovery Action Underway]]>
      </StatusDescription>
      <LocalEventDate format="YYYYMMDD">20161024</LocalEventDate>
      <LocalEventTime format="HHMM">1618</LocalEventTime>
      <Depot>NXH</Depot>
      <DepotName>
        <![CDATA[Northampton Hub]]>
      </DepotName>
    </StatusData>
    <StatusData>
      <StatusCode>LAC</StatusCode>
      <StatusDescription>
        <![CDATA[Delay Due To Congestion En Route. Recovery Action Underway.]]>
      </StatusDescription>
      <LocalEventDate format="YYYYMMDD">20161024</LocalEventDate>
      <LocalEventTime format="HHMM">1545</LocalEventTime>
      <Depot>NXH</Depot>
      <DepotName>
        <![CDATA[Northampton Hub]]>
      </DepotName>
    </StatusData>
    <StatusData>
      <StatusCode>OS</StatusCode>
      <StatusDescription>
        <![CDATA[Shipment In Transit.]]>
      </StatusDescription>
      <LocalEventDate format="YYYYMMDD">20161021</LocalEventDate>
      <LocalEventTime format="HHMM">1119</LocalEventTime>
      <Depot>MAD</Depot>
      <DepotName>
        <![CDATA[Madrid]]>
      </DepotName>
    </StatusData>
    <StatusData>
      <StatusCode>AS</StatusCode>
      <StatusDescription>
        <![CDATA[Shipment Received At Transit Point.]]>
      </StatusDescription>
      <LocalEventDate format="YYYYMMDD">20161020</LocalEventDate>
      <LocalEventTime format="HHMM">1905</LocalEventTime>
      <Depot>MAD</Depot>
      <DepotName>
        <![CDATA[Madrid]]>
      </DepotName>
    </StatusData>
    <StatusData>
      <StatusCode>TR</StatusCode>
      <StatusDescription>
        <![CDATA[Shipment In Transit.]]>
      </StatusDescription>
      <LocalEventDate format="YYYYMMDD">20161020</LocalEventDate>
      <LocalEventTime format="HHMM">1905</LocalEventTime>
      <Depot>MAD</Depot>
      <DepotName>
        <![CDATA[Madrid]]>
      </DepotName>
    </StatusData>
    <StatusData>
      <StatusCode>PU</StatusCode>
      <StatusDescription>
        <![CDATA[Shipment Collected From Customer]]>
      </StatusDescription>
      <LocalEventDate format="YYYYMMDD">20161020</LocalEventDate>
      <LocalEventTime format="HHMM">1620</LocalEventTime>
      <Depot>MAD</Depot>
      <DepotName>
        <![CDATA[Madrid]]>
      </DepotName>
    </StatusData>
  </Consignment>
  <Consignment access="public">
    <ConsignmentNumber>123456782</ConsignmentNumber>
    <OriginDepot>OPO</OriginDepot>
    <OriginDepotName>
      <![CDATA[Porto]]>
    </OriginDepotName>
    <CollectionDate format="YYYYMMDD">20160920</CollectionDate>
    <DeliveryTown>
      <![CDATA[ROMA]]>
    </DeliveryTown>
    <DeliveryDate format="YYYYMMDD">20161020</DeliveryDate>
    <DeliveryTime format="HHMM">0824</DeliveryTime>
    <Signatory>
      <![CDATA[]]>
    </Signatory>
    <SummaryCode>DEL</SummaryCode>
    <DestinationCountry>
      <CountryCode>IT</CountryCode>
      <CountryName>
        <![CDATA[Italy]]>
      </CountryName>
    </DestinationCountry>
    <OriginCountry>
      <CountryCode>PT</CountryCode>
      <CountryName>
        <![CDATA[Portugal]]>
      </CountryName>
    </OriginCountry>
    <PieceQuantity>1</PieceQuantity>
    <StatusData>
      <StatusCode>PA</StatusCode>
      <StatusDescription>
        <![CDATA[Delivery By Mail. Delivery Confirmation Available On Request]]>
      </StatusDescription>
      <LocalEventDate format="YYYYMMDD">20161020</LocalEventDate>
      <LocalEventTime format="HHMM">0824</LocalEventTime>
      <Depot>ZRH</Depot>
      <DepotName>
        <![CDATA[Zurich]]>
      </DepotName>
    </StatusData>
    <StatusData>
      <StatusCode>PA</StatusCode>
      <StatusDescription>
        <![CDATA[Delivery By Mail. Delivery Confirmation Available On Request]]>
      </StatusDescription>
      <LocalEventDate format="YYYYMMDD">20161019</LocalEventDate>
      <LocalEventTime format="HHMM">1455</LocalEventTime>
      <Depot>ZRH</Depot>
      <DepotName>
        <![CDATA[Zurich]]>
      </DepotName>
    </StatusData>
    <StatusData>
      <StatusCode>PA</StatusCode>
      <StatusDescription>
        <![CDATA[Delivery By Mail. Delivery Confirmation Available On Request]]>
      </StatusDescription>
      <LocalEventDate format="YYYYMMDD">20161019</LocalEventDate>
      <LocalEventTime format="HHMM">1420</LocalEventTime>
      <Depot>ZRH</Depot>
      <DepotName>
        <![CDATA[Zurich]]>
      </DepotName>
    </StatusData>
    <StatusData>
      <StatusCode>CDB</StatusCode>
      <StatusDescription>
        <![CDATA[Packaging Damaged. Repacked And Forwarded For Delivery]]>
      </StatusDescription>
      <LocalEventDate format="YYYYMMDD">20161014</LocalEventDate>
      <LocalEventTime format="HHMM">0850</LocalEventTime>
      <Depot>LIS</Depot>
      <DepotName>
        <![CDATA[Lisbon]]>
      </DepotName>
    </StatusData>
    <StatusData>
      <StatusCode>CDB</StatusCode>
      <StatusDescription>
        <![CDATA[Packaging Damaged. Repacked And Forwarded For Delivery]]>
      </StatusDescription>
      <LocalEventDate format="YYYYMMDD">20161013</LocalEventDate>
      <LocalEventTime format="HHMM">1457</LocalEventTime>
      <Depot>LIS</Depot>
      <DepotName>
        <![CDATA[Lisbon]]>
      </DepotName>
    </StatusData>
    <StatusData>
      <StatusCode>CDB</StatusCode>
      <StatusDescription>
        <![CDATA[Packaging Damaged. Repacked And Forwarded For Delivery]]>
      </StatusDescription>
      <LocalEventDate format="YYYYMMDD">20161013</LocalEventDate>
      <LocalEventTime format="HHMM">1223</LocalEventTime>
      <Depot>LIS</Depot>
      <DepotName>
        <![CDATA[Lisbon]]>
      </DepotName>
    </StatusData>
    <StatusData>
      <StatusCode>CDB</StatusCode>
      <StatusDescription>
        <![CDATA[Packaging Damaged. Repacked And Forwarded For Delivery]]>
      </StatusDescription>
      <LocalEventDate format="YYYYMMDD">20161012</LocalEventDate>
      <LocalEventTime format="HHMM">1213</LocalEventTime>
      <Depot>LIS</Depot>
      <DepotName>
        <![CDATA[Lisbon]]>
      </DepotName>
    </StatusData>
    <StatusData>
      <StatusCode>FDB</StatusCode>
      <StatusDescription>
        <![CDATA[Packaging Damaged. Repacked And Forwarded For Delivery]]>
      </StatusDescription>
      <LocalEventDate format="YYYYMMDD">20161012</LocalEventDate>
      <LocalEventTime format="HHMM">1132</LocalEventTime>
      <Depot>LIS</Depot>
      <DepotName>
        <![CDATA[Lisbon]]>
      </DepotName>
    </StatusData>
    <StatusData>
      <StatusCode>CDB</StatusCode>
      <StatusDescription>
        <![CDATA[Packaging Damaged. Repacked And Forwarded For Delivery]]>
      </StatusDescription>
      <LocalEventDate format="YYYYMMDD">20161012</LocalEventDate>
      <LocalEventTime format="HHMM">1058</LocalEventTime>
      <Depot>LIS</Depot>
      <DepotName>
        <![CDATA[Lisbon]]>
      </DepotName>
    </StatusData>
    <StatusData>
      <StatusCode>CDB</StatusCode>
      <StatusDescription>
        <![CDATA[Packaging Damaged. Repacked And Forwarded For Delivery]]>
      </StatusDescription>
      <LocalEventDate format="YYYYMMDD">20161012</LocalEventDate>
      <LocalEventTime format="HHMM">1023</LocalEventTime>
      <Depot>LIS</Depot>
      <DepotName>
        <![CDATA[Lisbon]]>
      </DepotName>
    </StatusData>
    <StatusData>
      <StatusCode>CI</StatusCode>
      <StatusDescription>
        <![CDATA[Shipment Received At Origin Depot.]]>
      </StatusDescription>
      <LocalEventDate format="YYYYMMDD">20160920</LocalEventDate>
      <LocalEventTime format="HHMM">1858</LocalEventTime>
      <Depot>OPO</Depot>
      <DepotName>
        <![CDATA[Porto]]>
      </DepotName>
    </StatusData>
  </Consignment>
  <Consignment access="public">
    <ConsignmentNumber>123456782</ConsignmentNumber>
    <OriginDepot>QAR</OriginDepot>
    <OriginDepotName>
      <![CDATA[Arnhem Hub]]>
    </OriginDepotName>
    <CollectionDate format="YYYYMMDD">20160825</CollectionDate>
    <DeliveryTown>
      <![CDATA[DUBLIN 17]]>
    </DeliveryTown>
    <DeliveryDate format="YYYYMMDD">20160908</DeliveryDate>
    <DeliveryTime format="HHMM">1436</DeliveryTime>
    <Signatory>
      <![CDATA[]]>
    </Signatory>
    <SummaryCode>DEL</SummaryCode>
    <DestinationCountry>
      <CountryCode>IE</CountryCode>
      <CountryName>
        <![CDATA[Ireland]]>
      </CountryName>
    </DestinationCountry>
    <OriginCountry>
      <CountryCode>NL</CountryCode>
      <CountryName>
        <![CDATA[Netherlands]]>
      </CountryName>
    </OriginCountry>
    <StatusData>
      <StatusCode>PA</StatusCode>
      <StatusDescription>
        <![CDATA[Delivery By Mail. Delivery Confirmation Available On Request]]>
      </StatusDescription>
      <LocalEventDate format="YYYYMMDD">20160908</LocalEventDate>
      <LocalEventTime format="HHMM">1436</LocalEventTime>
      <Depot>ZRH</Depot>
      <DepotName>
        <![CDATA[Zurich]]>
      </DepotName>
    </StatusData>
    <StatusData>
      <StatusCode>NR</StatusCode>
      <StatusDescription>
        <![CDATA[Shipment Delayed In Transit Recovery Actions Underway]]>
      </StatusDescription>
      <LocalEventDate format="YYYYMMDD">20160826</LocalEventDate>
      <LocalEventTime format="HHMM">0905</LocalEventTime>
      <Depot>DUB</Depot>
      <DepotName>
        <![CDATA[Dublin]]>
      </DepotName>
    </StatusData>
    <StatusData>
      <StatusCode>NR</StatusCode>
      <StatusDescription>
        <![CDATA[Shipment Delayed In Transit Recovery Actions Underway]]>
      </StatusDescription>
      <LocalEventDate format="YYYYMMDD">20160826</LocalEventDate>
      <LocalEventTime format="HHMM">0848</LocalEventTime>
      <Depot>DUB</Depot>
      <DepotName>
        <![CDATA[Dublin]]>
      </DepotName>
    </StatusData>
    <StatusData>
      <StatusCode>CI</StatusCode>
      <StatusDescription>
        <![CDATA[Shipment Received At Origin Depot.]]>
      </StatusDescription>
      <LocalEventDate format="YYYYMMDD">20160825</LocalEventDate>
      <LocalEventTime format="HHMM">1033</LocalEventTime>
      <Depot>QAR</Depot>
      <DepotName>
        <![CDATA[Arnhem Hub]]>
      </DepotName>
    </StatusData>
  </Consignment>
  <Consignment access="public">
    <ConsignmentNumber>123456782</ConsignmentNumber>
    <OriginDepot>ZMU</OriginDepot>
    <OriginDepotName>
      <![CDATA[Munich]]>
    </OriginDepotName>
    <CustomerReference>
      <![CDATA[TESTSENDUNG]]>
    </CustomerReference>
    <CollectionDate format="YYYYMMDD">20161024</CollectionDate>
    <DeliveryTown>
      <![CDATA[HALLBERGMOOS]]>
    </DeliveryTown>
    <SummaryCode>EXC</SummaryCode>
    <DestinationCountry>
      <CountryCode>DE</CountryCode>
      <CountryName>
        <![CDATA[Germany]]>
      </CountryName>
    </DestinationCountry>
    <OriginCountry>
      <CountryCode>DE</CountryCode>
      <CountryName>
        <![CDATA[Germany]]>
      </CountryName>
    </OriginCountry>
    <PieceQuantity>99</PieceQuantity>
    <StatusData>
      <StatusCode>AA</StatusCode>
      <StatusDescription>
        <![CDATA[Duplicate Or Non-existent Consignment Record In System]]>
      </StatusDescription>
      <LocalEventDate format="YYYYMMDD">20161024</LocalEventDate>
      <LocalEventTime format="HHMM">1252</LocalEventTime>
      <Depot>ZMU</Depot>
      <DepotName>
        <![CDATA[Munich]]>
      </DepotName>
    </StatusData>
    <StatusData>
      <StatusCode>CI</StatusCode>
      <StatusDescription>
        <![CDATA[Shipment Received At Origin Depot.]]>
      </StatusDescription>
      <LocalEventDate format="YYYYMMDD">20161024</LocalEventDate>
      <LocalEventTime format="HHMM">0952</LocalEventTime>
      <Depot>ZMU</Depot>
      <DepotName>
        <![CDATA[Munich]]>
      </DepotName>
    </StatusData>
  </Consignment>
</TrackResponse>';

$simple = new SimpleXMLElement($xml);

print_r($simple);
