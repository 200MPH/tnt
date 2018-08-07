<?php 

/**
 * TNT Activity Tests
 *
 * @author Wojciech Brozyna <http://vobro.systems>
 */

namespace thm\tnt_ec\test\unit;

use thm\tnt_ec\service\ShippingService\Activity;

class ActivityTest extends \PHPUnit_Framework_TestCase {
    
    /*
     * Single consignment
     */
    public function singleConsignmentTest() {
        
        $consignment = '123456789';
        $activity = new Activity('test', 'test');
        $activity->create($consignment)
                 ->book($consignment)
                 ->rate($consignment)
                 ->ship($consignment)
                 ->printConsignmentNote($consignment)
                 ->printEmail($consignment, 'email@from.com')
                 ->printInvoice($consignment)
                 ->printLabel($consignment)
                 ->printManifest($consignment);
        
        print_r($activity->getXmlContent());
        
    }
    
}