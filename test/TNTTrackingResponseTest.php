<?php

/**
 * TNT Tracking Response Tests
 *
 * @author Wojciech Brozyna <wojciech.brozyna@gmail.com>
 */

namespace thm\tnt_ec\tests;

require_once __DIR__ . '/../vendor/autoload.php';

use thm\tnt_ec\Service\TrackingService\libs\TrackingResponse;
use thm\tnt_ec\Service\TrackingService\libs\Consignment;
use thm\tnt_ec\Service\TrackingService\libs\StatusData;
use thm\tnt_ec\Service\TrackingService\libs\AddressParty;

class TNTTrackingResponseTest extends \PHPUnit_Framework_TestCase {
    
    /**
     *
     * @var TrackingResponse
     */
    private $response;
        
    /**
     * @var string
     */
    private $xml;
    
    public function setUp()
    {
        
        parent::setUp();
        
        $this->xml = '<?xml version="1.0" encoding="utf-8"?>
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
                   <ShipmentSummary> 
                    <TermsOfPayment>Sender</TermsOfPayment> 
                    <DueDate format="YYYYMMDD" >20060508</DueDate> 
                    <Service><![CDATA[12:00 Express]]></Service> 
                   </ShipmentSummary>
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
        
        $this->response = new TrackingResponse($this->xml, null);
        
    }
    
    /**
     * GetConsignmnets is array
     */
    public function testGetConsignmentsIsArray()
    {
        
        $state = is_array($this->response->getConsignments());
        
        $this->assertTrue($state);
        
    }
 
    /**
     * GetConsignment is Consignment[] collection if not empty
     */
    public function testGetConsignmentsIsConsignmentCollection()
    {
        
        $c = $this->response->getConsignments();
        
        if(empty($c) === false) {
            
            foreach($c as $obj) {
                
                $state = $obj instanceof Consignment;
            
                $this->assertTrue($state);
                
            }
            
        }
        
        $this->assertTrue(true);
        
    }
    
    /**
     * getAttributes() is always array
     */
    public function testIsGetAttributesArray()
    {
        
        $c = new Consignment(new \SimpleXMLElement($this->xml));
        
        $state = is_array($c->getAttributes());

        $this->assertTrue($state);
        
    }
    
    /**
     * getSummaryCode return CNF if not set
     */
    public function testGetSummaryCodeReturnsCNFCode()
    {
        
        $c = new Consignment(new \SimpleXMLElement('<root></root>'));
        
        $this->assertEquals('CNF', $c->getSummaryCode());
                
    }
    
    /**
     * getPieceQuantuty Returnz Integer
     */
    public function testGetPieceQuantityReturnsInt()
    {
        
        $c = new Consignment(new \SimpleXMLElement('<root><PieceQuantity>99</PieceQuantity></root>'));
        
        $int1 = $c->getPieceQuantity();
        
        $stat1 = is_int($int1);
        
        $this->assertTrue($stat1);
        
        $this->assertEquals(99, $int1);
        
        $c2 = new Consignment(new \SimpleXMLElement('<root></root>'));
        
        $int2 = $c2->getPieceQuantity();
        
        $stat2 = is_int($int2);
        
        $this->assertTrue($stat2);
        
        $this->assertEquals(0, $int2);
        
    }
    
    /**
     * getStatuses returns array
     */
    public function testGetStatusesIsArray()
    {
        
        $c = new Consignment(new \SimpleXMLElement('<root></root>'));
        
        $state = is_array($c->getStatuses());
        
        $this->assertTrue($state);
        
    }
    
    /**
     * getLocalEvenDate returns formated date
     */
    public function testGetLocalEventDateReturnsDate()
    {
        
        $sd = new StatusData(new \SimpleXMLElement('<root><LocalEventDate>20161114</LocalEventDate></root>'));
        
        $this->assertEquals('20161114', $sd->getLocalEventDate());
        
        $this->assertEquals('2016-11-14', $sd->getLocalEventDate('Y-m-d'));
        
    }
    
    /**
     * getLocalEvenDate returns formated time
     */
    public function testGetLocalEventTimeReturnsTime()
    {
        
        $sd = new StatusData(new \SimpleXMLElement('<root><LocalEventTime>1011</LocalEventTime></root>'));
        
        $this->assertEquals('1011', $sd->getLocalEventTime());
        
        $this->assertEquals('10:11', $sd->getLocalEventTime('H:i'));
        
    }
    
    /**
     * getDeliveryDate returns formated date
     */
    public function testGetDeliveryDateReturnsTime()
    {
        
        $c = new Consignment(new \SimpleXMLElement('<root><DeliveryDate>20161114</DeliveryDate></root>'));
        
        $this->assertEquals('20161114', $c->getDeliveredDate());
        
        $this->assertEquals('2016-11-14', $c->getDeliveredDate('Y-m-d'));
        
    }
    
    /**
     * getDeliveryTime returns formated time
     */
    public function testGetDeliveryTimeReturnsTime()
    {
        
        $c = new Consignment(new \SimpleXMLElement('<root><DeliveryTime>1011</DeliveryTime></root>'));
        
        $this->assertEquals('1011', $c->getDeliveredTime());
        
        $this->assertEquals('10:11', $c->getDeliveredTime('H:i'));
        
    }
    
    /**
     * getStatuses returns StatusData[] collection
     */
    public function testGetStatusesReturnsStatusDataCollection()
    {
    
        $xml = new \SimpleXMLElement($this->xml);
        
        $c = new Consignment($xml->Consignment[1]);
        
        foreach($c->getStatuses() as $status) {
            
            $state = $status instanceof StatusData;
            
            $this->assertTrue($state);
        
        }
        
    }
        
    /**
     * AddressParty return values
     */
    public function testAddressPartyReturnValues()
    {
        
        $xml = '<Address> 
                    <Name><![CDATA[TEST CON]]></Name> 
                    <AddressLine><![CDATA[TEST 1]]></AddressLine> 
                    <AddressLine><![CDATA[TEST 2]]></AddressLine> 
                    <AddressLine><![CDATA[TEST 3]]></AddressLine> 
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
                </Address>';
        
        $address = new AddressParty(new \SimpleXMLElement($xml));
        
        $this->assertEquals('TEST CON', $address->getName());
        $this->assertEquals('TEST 1', $address->getAddressLine());
        $this->assertEquals('TEST 1', $address->getAddressLine(1));
        $this->assertEquals('TEST 2', $address->getAddressLine(2));
        $this->assertEquals('TEST 3', $address->getAddressLine(3));
        $this->assertEquals('AMSTERDAM', $address->getCity());
        $this->assertEquals('NOORD-HOLLAND', $address->getProvince());
        $this->assertEquals('1100 AA', $address->getPostcode());
        $this->assertEquals('NL', $address->getCountryCode());
        $this->assertEquals('Netherlands', $address->getCountryName());
        $this->assertEquals('020 511111', $address->getPhoneNumber());
        $this->assertEquals('OTTE', $address->getContactName());
        $this->assertEquals('020 111111', $address->getContactPhoneNumber());
        $this->assertEquals('000180454', $address->getAccountNumber());
        $this->assertEquals('FB834343432432', $address->getVatNumber());
        
    }
 
    /*
     * Test all functions output. 
     */
    public function testOutput()
    {
        
        
        
    }
    
}