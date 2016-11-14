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
                  <Addresses> 
                    <Address addressParty="Sender" > 
                        <Name><![CDATA[TEST CON]]></Name> 
                        <AddressLine><![CDATA[TEST 1 ]]></AddressLine> 
                        <AddressLine><![CDATA[TEST 2 ]]></AddressLine> 
                        <AddressLine><![CDATA[TEST 3 ]]></AddressLine> 
                        <City><![CDATA[AMSTERDAM]]></City> 
                        <Province><![CDATA[NOORD-HOLLAND]]></Province> 
                        <Postcode><![CDATA[1100 AA]]></Postcode> 
                        <Country> 
                        <CountryCode>NL</CountryCode> 
                        <CountryName><![CDATA[Netherlands]]></CountryName> 
                        </Country> 
                        <PhoneNumber><![CDATA[020 511111]]></PhoneNumber> 
                        <ContactName><![CDATA[OTTE]]></ContactName> 
                        <ContactPhoneNumber><![CDATA[020 111111]]></ContactPhoneNumber> 
                        <AccountNumber><![CDATA[000180454]]></AccountNumber> 
                        <VATNumber><![CDATA[FB834343432432]]></VATNumber> 
                    </Address>
                    <Address addressParty="Collection" > 
                        <Name><![CDATA[TEST CON]]></Name> 
                        <AddressLine><![CDATA[TEST 1 ]]></AddressLine> 
                        <AddressLine><![CDATA[TEST 2 ]]></AddressLine> 
                        <AddressLine><![CDATA[TEST 3 ]]></AddressLine> 
                        <City><![CDATA[AMSTERDAM]]></City> 
                        <Province><![CDATA[NOORD-HOLLAND]]></Province> 
                        <Postcode><![CDATA[1100 AA]]></Postcode> 
                        <Country> 
                        <CountryCode>NL</CountryCode> 
                        <CountryName><![CDATA[Netherlands]]></CountryName> 
                        </Country> 
                        <PhoneNumber><![CDATA[020 511111]]></PhoneNumber> 
                        <ContactName><![CDATA[OTTE]]></ContactName> 
                        <ContactPhoneNumber><![CDATA[020 111111]]></ContactPhoneNumber> 
                    </Address>
                    <Address addressParty="Receiver" > 
                        <Name><![CDATA[TEST CON]]></Name> 
                        <AddressLine><![CDATA[TEST 23 ]]></AddressLine> 
                        <AddressLine></AddressLine> 
                        <AddressLine></AddressLine> 
                        <City><![CDATA[AMSTERDAM]]></City> 
                        <Province><![CDATA[NOORD-HOLLAND]]></Province> 
                        <Postcode><![CDATA[1100 AA]]></Postcode> 
                        <Country> 
                        <CountryCode>NL</CountryCode> 
                        <CountryName><![CDATA[Netherlands]]></CountryName> 
                        </Country> 
                        <PhoneNumber><![CDATA[020 511111]]></PhoneNumber> 
                        <ContactName><![CDATA[OTTE]]></ContactName> 
                        <ContactPhoneNumber><![CDATA[020 111111]]></ContactPhoneNumber> 
                    </Address>
                    <Address addressParty="Delivery" > 
                        <Name><![CDATA[TEST CON]]></Name> 
                        <AddressLine><![CDATA[TEST 23 ]]></AddressLine> 
                        <AddressLine></AddressLine> 
                        <AddressLine></AddressLine> 
                        <City><![CDATA[AMSTERDAM]]></City> 
                        <Province><![CDATA[NOORD-HOLLAND]]></Province> 
                        <Postcode><![CDATA[1100 AA]]></Postcode> 
                        <Country> 
                        <CountryCode>NL</CountryCode> 
                        <CountryName><![CDATA[Netherlands]]></CountryName> 
                        </Country> 
                        <PhoneNumber><![CDATA[020 511111]]></PhoneNumber> 
                        <ContactName><![CDATA[OTTE]]></ContactName> 
                        <ContactPhoneNumber><![CDATA[020 111111]]></ContactPhoneNumber> 
                    </Address>
                   </Addresses>
                   <PackageSummary> 
                    <NumberOfPieces>1</NumberOfPieces> 
                    <Weight units="kgs" >6.700</Weight> 
                    <PackageDescription><![CDATA[CARTON]]></PackageDescription> 
                    <GoodsDescription><![CDATA[TURBO CHARGER]]></GoodsDescription> 
                    <InvoiceAmount currency="EUR" >200.50</InvoiceAmount> 
                   </PackageSummary> 
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
