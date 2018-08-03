<?php

/**
 * TNT Tests
 *
 * @author Wojciech Brozyna <http://vobro.systems>
 */

namespace thm\tnt_ec\test\unit;

use thm\tnt_ec\service\TrackingService\TrackingService;
use thm\tnt_ec\Service\TrackingService\TrackingResponse;

class TrackingRequestTest extends \PHPUnit_Framework_TestCase {
    
    private $ts;
        
    public function setUp()
    {
        
        parent::setUp();
        
        $this->ts = new TrackingService('user', 'password');
                
    }
    
    public function testOK() 
    {
    
        $this->assertTrue(true);
        
    }
        
    /**
     * SearchByConsignment return XmlReader
     */
    public function testSearchByConsignmentReturnTrackingResponse()
    {
        
        $response = $this->ts->searchByConsignment(array('12345'));
        
        $state = $response instanceof TrackingResponse;
        
        $this->assertTrue($state);
        
    }
    
    /**
     * Is XML valid
     */
    public function testIsXmlValid()
    {
        
        $this->ts->setLevelOfDetails()
             ->setComplete()
             ->setDestinationAddress()
             ->setOriginAddress()
             ->setPackage()
             ->setShipment()
             ->setPod();
        
        $response = $this->ts->searchByConsignment(array('12345'));
        
        $state = simplexml_load_string($response->getRequestXml());
           
        $assert = ($state === false) ? false : true;
        
        $this->assertTrue( $assert );
        
    }
    
}
