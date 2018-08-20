<?php

/**
 * TNT Tests
 *
 * @author Wojciech Brozyna <http://vobro.systems>
 */

namespace thm\tnt_ec\test\unit;

use thm\tnt_ec\service\ShippingService\ShippingService;

class ShippingRequestTest extends \PHPUnit_Framework_TestCase {

    /**
     * @var ShippingService
     */
    protected $shipping;

    public function setUp() {

        parent::setUp();

        $this->shipping = new ShippingService('user', 'password');

        $this->shipping
                ->createOptionalActivities()
                ->setGroupCode('123456789')
                ->setAccountNumber('A1234')
                ->setSender()
                ->setCompanyName('Test Company')
                ->setAddressLine('Address line 1')
                ->setAddressLine('Address line 2')
                ->setAddressLine('Address line 3')
                ->setCity('City')
                ->setProvince('Province')
                ->setPostcode('Post code')
                ->setCountry('Country')
                ->setVat('123123')
                ->setContactName('Aren')
                ->setContactDialCode('Dial code')
                ->setContactPhone('Contact phone')
                ->setContactEmail('Email');

        $this->shipping->setCollection()->useSenderAddress()
                ->setShipDate('16/01/2018')
                ->setPrefCollectTime('10:00', '12:00')
                ->setAltCollectionTime('12:00', '14:00')
                ->setCollectInstruction('Collection instruction');

        $c1 = $this->shipping->addConsignment()->setConReference('GB123456789')
                ->setCustomerRef('123456789')
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
                ->setDescription('Description')
                ->setDeliveryInstructions('Del. instruction')
                ->hazardous(1234);

        $c1->setReceiver()->setCompanyName('Company name')
                ->setAddressLine('Address 1')
                ->setAddressLine('Address 2')
                ->setAddressLine('Address 3')
                ->setCity('City')
                ->setProvince('Province')
                ->setPostcode('12345')
                ->setCountry('GB')
                ->setVat('123456')
                ->setContactName('Name')
                ->setContactDialCode('+48')
                ->setContactPhone('123456789')
                ->setContactEmail('email@email');

        $c1->setReceiverAsDelivery();

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
                ->setInvoiceDescription('Desc')
                ->setHts(0)
                ->setCountry('GB')
                ->setEmrn('EMRN');
    }

    public function testXmlOutput()
    {
        
        $xml = '<?xml version="1.0" encoding="UTF-8" standalone="no"?>
<ESHIPPER>
 <LOGIN>
  <COMPANY>user</COMPANY>
  <PASSWORD>password</PASSWORD>
  <APPID>IN</APPID>
  <APPVERSION>3.0</APPVERSION>
 </LOGIN>
 <CONSIGNMENTBATCH>
  <GROUPCODE>123456789</GROUPCODE>
  <SENDER><COMPANYNAME><![CDATA[Test Company]]></COMPANYNAME>
<STREETADDRESS1><![CDATA[Address line 1]]></STREETADDRESS1>
<STREETADDRESS2><![CDATA[Address line 2]]></STREETADDRESS2>
<STREETADDRESS3><![CDATA[Address line 3]]></STREETADDRESS3>
<CITY><![CDATA[City]]></CITY>
<PROVINCE><![CDATA[Province]]></PROVINCE>
<POSTCODE><![CDATA[Post code]]></POSTCODE>
<COUNTRY><![CDATA[Country]]></COUNTRY>
<VAT><![CDATA[123123]]></VAT>
<CONTACTNAME><![CDATA[Aren]]></CONTACTNAME>
<CONTACTDIALCODE><![CDATA[Dial code]]></CONTACTDIALCODE>
<CONTACTTELEPHONE><![CDATA[Contact phone]]></CONTACTTELEPHONE>
<CONTACTEMAIL><![CDATA[Email]]></CONTACTEMAIL>
   <COLLECTION><COLLECTIONADDRESS><COMPANYNAME><![CDATA[Test Company]]></COMPANYNAME>
<STREETADDRESS1><![CDATA[Address line 1]]></STREETADDRESS1>
<STREETADDRESS2><![CDATA[Address line 2]]></STREETADDRESS2>
<STREETADDRESS3><![CDATA[Address line 3]]></STREETADDRESS3>
<CITY><![CDATA[City]]></CITY>
<PROVINCE><![CDATA[Province]]></PROVINCE>
<POSTCODE><![CDATA[Post code]]></POSTCODE>
<COUNTRY><![CDATA[Country]]></COUNTRY>
<VAT><![CDATA[123123]]></VAT>
<CONTACTNAME><![CDATA[Aren]]></CONTACTNAME>
<CONTACTDIALCODE><![CDATA[Dial code]]></CONTACTDIALCODE>
<CONTACTTELEPHONE><![CDATA[Contact phone]]></CONTACTTELEPHONE>
<CONTACTEMAIL><![CDATA[Email]]></CONTACTEMAIL>
</COLLECTIONADDRESS>
<SHIPDATE><![CDATA[16/01/2018]]></SHIPDATE>
<PREFCOLLECTTIME>
 <FROM><![CDATA[10:00]]></FROM>
 <TO><![CDATA[12:00]]></TO>
</PREFCOLLECTTIME>
<ALTCOLLECTTIME>
 <FROM><![CDATA[12:00]]></FROM>
 <TO><![CDATA[14:00]]></TO>
</ALTCOLLECTTIME>
<COLLINSTRUCTIONS><![CDATA[Collection instruction]]></COLLINSTRUCTIONS>
</COLLECTION>
  </SENDER>
  <CONSIGNMENT><CONREF>GB123456789</CONREF>
<DETAILS>
 <RECEIVER><COMPANYNAME><![CDATA[Company name]]></COMPANYNAME>
<STREETADDRESS1><![CDATA[Address 1]]></STREETADDRESS1>
<STREETADDRESS2><![CDATA[Address 2]]></STREETADDRESS2>
<STREETADDRESS3><![CDATA[Address 3]]></STREETADDRESS3>
<CITY><![CDATA[City]]></CITY>
<PROVINCE><![CDATA[Province]]></PROVINCE>
<POSTCODE><![CDATA[12345]]></POSTCODE>
<COUNTRY><![CDATA[GB]]></COUNTRY>
<VAT><![CDATA[123456]]></VAT>
<CONTACTNAME><![CDATA[Name]]></CONTACTNAME>
<CONTACTDIALCODE><![CDATA[+48]]></CONTACTDIALCODE>
<CONTACTTELEPHONE><![CDATA[123456789]]></CONTACTTELEPHONE>
<CONTACTEMAIL><![CDATA[email@email]]></CONTACTEMAIL>
</RECEIVER>
 <DELIVERY><COMPANYNAME><![CDATA[Company name]]></COMPANYNAME>
<STREETADDRESS1><![CDATA[Address 1]]></STREETADDRESS1>
<STREETADDRESS2><![CDATA[Address 2]]></STREETADDRESS2>
<STREETADDRESS3><![CDATA[Address 3]]></STREETADDRESS3>
<CITY><![CDATA[City]]></CITY>
<PROVINCE><![CDATA[Province]]></PROVINCE>
<POSTCODE><![CDATA[12345]]></POSTCODE>
<COUNTRY><![CDATA[GB]]></COUNTRY>
<VAT><![CDATA[123456]]></VAT>
<CONTACTNAME><![CDATA[Name]]></CONTACTNAME>
<CONTACTDIALCODE><![CDATA[+48]]></CONTACTDIALCODE>
<CONTACTTELEPHONE><![CDATA[123456789]]></CONTACTTELEPHONE>
<CONTACTEMAIL><![CDATA[email@email]]></CONTACTEMAIL>
</DELIVERY>
<CUSTOMERREF><![CDATA[123456789]]></CUSTOMERREF>
<CONTYPE><![CDATA[N]]></CONTYPE>
<PAYMENTIND><![CDATA[S]]></PAYMENTIND>
<ITEMS><![CDATA[0]]></ITEMS>
<TOTALWEIGHT><![CDATA[0]]></TOTALWEIGHT>
<TOTALVOLUME><![CDATA[0]]></TOTALVOLUME>
<CURRENCY><![CDATA[GBP]]></CURRENCY>
<GOODSVALUE><![CDATA[0]]></GOODSVALUE>
<INSURANCEVALUE><![CDATA[0]]></INSURANCEVALUE>
<INSURANCECURRENCY><![CDATA[GBP]]></INSURANCECURRENCY>
<SERVICE><![CDATA[15N]]></SERVICE>
<OPTION><![CDATA[PR]]></OPTION>
<DESCRIPTION><![CDATA[Description]]></DESCRIPTION>
<DELIVERYINST><![CDATA[Del. instruction]]></DELIVERYINST>
<HAZARDOUS><![CDATA[Y]]></HAZARDOUS>
<UNNUMBER><![CDATA[1234]]></UNNUMBER>
<PACKINGGROUP><![CDATA[II]]></PACKINGGROUP>
 <PACKAGE><ITEMS><![CDATA[0]]></ITEMS>
<DESCRIPTION><![CDATA[]]></DESCRIPTION>
<LENGTH><![CDATA[0]]></LENGTH>
<HEIGHT><![CDATA[0]]></HEIGHT>
<WIDTH><![CDATA[0]]></WIDTH>
<WEIGHT><![CDATA[0]]></WEIGHT>
<ARTICLE><ITEMS><![CDATA[0]]></ITEMS>
<DESCRIPTION><![CDATA[]]></DESCRIPTION>
<WEIGHT><![CDATA[0]]></WEIGHT>
<INVOICEVALUE><![CDATA[0]]></INVOICEVALUE>
<INVOICEDESC><![CDATA[Desc]]></INVOICEDESC>
<HTS><![CDATA[0]]></HTS>
<COUNTRY><![CDATA[GB]]></COUNTRY>
<EMRN><![CDATA[EMRN]]></EMRN>
</ARTICLE>
</PACKAGE>
</DETAILS>
</CONSIGNMENT>
 </CONSIGNMENTBATCH>
<ACTIVITY><CREATE>
 <CONREF><![CDATA[GB123456789]]></CONREF>
</CREATE>
<BOOK ShowBookingRef="Y">
 <CONREF><![CDATA[GB123456789]]></CONREF>
</BOOK>
<SHIP>
 <CONREF><![CDATA[GB123456789]]></CONREF>
</SHIP>
 <PRINT><REQUIRED>
 <CONREF><![CDATA[GB123456789]]></CONREF>
</REQUIRED>
</PRINT>
 <SHOW_GROUPCODE/>
</ACTIVITY>
</ESHIPPER>';
        
        $xml1 = new \SimpleXMLElement($xml);
        $xml2 = new \SimpleXMLElement($this->shipping->getXmlContent());
       
        $this->assertEquals($xml1->asXML(), $xml2->asXML());
                        
    }
            
}
