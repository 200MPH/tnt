<?php

/**
 * TNT Tests
 *
 * @author Wojciech Brozyna <http://vobro.systems>
 */

namespace thm\tnt_ec\test\unit;

use thm\tnt_ec\service\ShippingService\ShippingResponse;

class ShippingResponseTest extends \PHPUnit_Framework_TestCase {
    
    /**
     * Test runtime error
     */
    public function testRuntimeError()
    {
        
        $response = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?><runtime_error><error_reason>The request to ExpressConnect Shipping has failed. Please contact your local service centre for further assistance</error_reason><error_srcText>Error persisting the shipping request and response to the database.</error_srcText></runtime_error>';
        
        $sr = new ShippingResponse($response, '', '', '');
        
        $this->assertTrue(is_array($sr->getErrors()));
        $this->assertTrue($sr->hasError());
        $err = $sr->getErrors();
        $this->assertEquals('The request to ExpressConnect Shipping has failed. Please contact your local service centre for further assistance', $err[0]);
        $this->assertEquals('Error persisting the shipping request and response to the database.', $err[1]);
        
        
    }
    
    
    
}
