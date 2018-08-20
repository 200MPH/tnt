<?php 

/**
 * TNT Activity Tests
 *
 * @author Wojciech Brozyna <http://vobro.systems>
 */

namespace thm\tnt_ec\test\unit;

use thm\tnt_ec\service\ShippingService\Activity;
use thm\tnt_ec\service\ShippingService\ActivityResponse;

class ActivityTest extends \PHPUnit_Framework_TestCase {
    
    /**
     * Test runtime error
     */
    public function testRuntimeError()
    {
        
        $response = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?><runtime_error><error_reason>The request to ExpressConnect Shipping has failed. Please contact your local service centre for further assistance</error_reason><error_srcText>Error persisting the shipping request and response to the database.</error_srcText></runtime_error>';
        
        $sr = new ActivityResponse($response, '', '', '');
        
        $this->assertTrue(is_array($sr->getErrors()));
        $this->assertTrue($sr->hasError());
        $err = $sr->getErrors();
        $this->assertEquals('The request to ExpressConnect Shipping has failed. Please contact your local service centre for further assistance', $err[0]);
        $this->assertEquals('Error persisting the shipping request and response to the database.', $err[1]);
                
    }
    
    /*
     * Single consignment
     */
    public function testBasicRequest() {
        
        $consignment = '123456789';
        $activity = new Activity('test', 'test');
        $activity->create($consignment)
                 ->book($consignment, true)
                 ->rate($consignment)
                 ->ship($consignment);
        
        $xml = '<?xml version="1.0" encoding="UTF-8" standalone="no"?>
<ACTIVITY><CREATE>
 <CONREF><![CDATA[123456789]]></CONREF>
</CREATE>
<BOOK EMAILREQD="Y" ShowBookingRef="Y">
 <CONREF><![CDATA[123456789]]></CONREF>
</BOOK>
<RATE>
 <CONREF><![CDATA[123456789]]></CONREF>
</RATE>
<SHIP>
 <CONREF><![CDATA[123456789]]></CONREF>
</SHIP>
</ACTIVITY>';
        
        $xml1 = new \SimpleXMLElement($xml);
        $xml2 = new \SimpleXMLElement($activity->getXmlContent());
        
        $this->assertEquals($xml1, $xml2);
        
    }
    
    /*
     * Single consignment
     */
    public function testBasicMultiRequest() {
        
        $consignment = array('123456789', '12323342324');
        $activity = new Activity('test', 'test');
        $activity->create($consignment)
                 ->book($consignment, true)
                 ->rate($consignment)
                 ->ship($consignment);
        
        $xml = '<?xml version="1.0" encoding="UTF-8" standalone="no"?>
<ACTIVITY><CREATE>
 <CONREF><![CDATA[123456789]]></CONREF>
 <CONREF><![CDATA[12323342324]]></CONREF>
</CREATE>
<BOOK EMAILREQD="Y" ShowBookingRef="Y">
 <CONREF><![CDATA[123456789]]></CONREF>
 <CONREF><![CDATA[12323342324]]></CONREF>
</BOOK>
<RATE>
 <CONREF><![CDATA[123456789]]></CONREF>
 <CONREF><![CDATA[12323342324]]></CONREF>
</RATE>
<SHIP>
 <CONREF><![CDATA[123456789]]></CONREF>
 <CONREF><![CDATA[12323342324]]></CONREF>
</SHIP>
</ACTIVITY>';
        
        $xml1 = new \SimpleXMLElement($xml);
        $xml2 = new \SimpleXMLElement($activity->getXmlContent());
        
        $this->assertEquals($xml1, $xml2);
        
    }
    
    /*
     * Single consignment
     */
    public function testPrintAllRequest() {
        
        $consignment = '123456789';
        $activity = new Activity('test', 'test');
        $activity->create($consignment)
                 ->book($consignment)
                 ->rate($consignment)
                 ->ship($consignment)
                 ->printAll($consignment);
        
        $xml = '<?xml version="1.0" encoding="UTF-8" standalone="no"?>
<ACTIVITY><CREATE>
 <CONREF><![CDATA[123456789]]></CONREF>
</CREATE>
<BOOK ShowBookingRef="Y">
 <CONREF><![CDATA[123456789]]></CONREF>
</BOOK>
<RATE>
 <CONREF><![CDATA[123456789]]></CONREF>
</RATE>
<SHIP>
 <CONREF><![CDATA[123456789]]></CONREF>
</SHIP>
 <PRINT><REQUIRED>
 <CONREF><![CDATA[123456789]]></CONREF>
</REQUIRED>
</PRINT>
</ACTIVITY>';
        
        $xml1 = new \SimpleXMLElement($xml);
        $xml2 = new \SimpleXMLElement($activity->getXmlContent());
        
        $this->assertEquals($xml1, $xml2);
        
    }
    
    /*
     * Single consignment
     */
    public function testAdvancedRequest() {
        
        $consignment = '123456789';
        $activity = new Activity('test', 'test');
        $activity->create($consignment)
                 ->book($consignment)
                 ->rate($consignment)
                 ->ship($consignment)
                 ->printConsignmentNote($consignment)
                 ->printEmail('email@to', 'email@from')
                 ->printInvoice($consignment)
                 ->printLabel($consignment)
                 ->printManifest($consignment);
        
        $xml = '<?xml version="1.0" encoding="UTF-8" standalone="no"?>
<ACTIVITY><CREATE>
 <CONREF><![CDATA[123456789]]></CONREF>
</CREATE>
<BOOK ShowBookingRef="Y">
 <CONREF><![CDATA[123456789]]></CONREF>
</BOOK>
<RATE>
 <CONREF><![CDATA[123456789]]></CONREF>
</RATE>
<SHIP>
 <CONREF><![CDATA[123456789]]></CONREF>
</SHIP>
 <PRINT><CONNOTE>
 <CONREF><![CDATA[123456789]]></CONREF>
</CONNOTE>
<EMAILTO><![CDATA[email@to]]></EMAILTO>
<EMAILFROM><![CDATA[email@from]]></EMAILFROM>
<INVOICE>
 <CONREF><![CDATA[123456789]]></CONREF>
</INVOICE>
<LABEL>
 <CONREF><![CDATA[123456789]]></CONREF>
</LABEL>
<MANIFEST>
 <CONREF><![CDATA[123456789]]></CONREF>
</MANIFEST>
</PRINT>
</ACTIVITY>';
        
        $xml1 = new \SimpleXMLElement($xml);
        $xml2 = new \SimpleXMLElement($activity->getXmlContent());
        
        $this->assertEquals($xml1, $xml2);
        
    }
    
    /*
     * Single consignment
     */
    public function testGroupCodeRequest() {
        
        $consignment = '123456789';
        $activity = new Activity('test', 'test');
        $activity->setGroupCode(12345)
                 ->showGroupCode()
                 ->create($consignment)
                 ->book($consignment)
                 ->rate($consignment)
                 ->ship($consignment)
                 ->printConsignmentNote($consignment)
                 ->printEmail('email@to', 'email@from')
                 ->printInvoice($consignment)
                 ->printLabel($consignment)
                 ->printManifest($consignment);
        
        $xml = '<?xml version="1.0" encoding="UTF-8" standalone="no"?>
<ACTIVITY><CREATE>
 <GROUPCODE>12345</GROUPCODE>
</CREATE>
<BOOK ShowBookingRef="Y">
 <GROUPCODE>12345</GROUPCODE>
</BOOK>
<RATE>
 <GROUPCODE>12345</GROUPCODE>
</RATE>
<SHIP>
 <GROUPCODE>12345</GROUPCODE>
</SHIP>
 <PRINT><CONNOTE>
 <CONREF><![CDATA[123456789]]></CONREF>
</CONNOTE>
<EMAILTO><![CDATA[email@to]]></EMAILTO>
<EMAILFROM><![CDATA[email@from]]></EMAILFROM>
<INVOICE>
 <CONREF><![CDATA[123456789]]></CONREF>
</INVOICE>
<LABEL>
 <CONREF><![CDATA[123456789]]></CONREF>
</LABEL>
<MANIFEST>
 <CONREF><![CDATA[123456789]]></CONREF>
</MANIFEST>
</PRINT>
 <SHOW_GROUPCODE/>
</ACTIVITY>';
        
        $xml1 = new \SimpleXMLElement($xml);
        $xml2 = new \SimpleXMLElement($activity->getXmlContent());
        
        $this->assertEquals($xml1, $xml2);
        
    }
    
    public function testReturnsObject()
    {
             
        $consignment = '123456789';
        $activity = new Activity('test', 'test');
        $activity->create($consignment)
                 ->book($consignment, true)
                 ->rate($consignment)
                 ->ship($consignment);
        
        $this->assertTrue($activity->send() instanceof ActivityResponse);
        
    }
    
}