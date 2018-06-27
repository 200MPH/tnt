<?php

/**
 * TNT Tests
 *
 * @author Wojciech Brozyna <wojciech.brozyna@gmail.com>
 */

namespace thm\tnt_ec\tests\unit;

require_once __DIR__ . '/../../vendor/autoload.php';

use thm\tnt_ec\service\ShippingService\ShippingService;

class ShippingTest extends \PHPUnit_Framework_TestCase {
    
    /**
     * @var ShippingService
     */
    private $shipping;
    
    public function setUp()
    {
        
        parent::setUp();
        
        $this->shipping = new ShippingService('user', 'password');
                
    }
    
}
