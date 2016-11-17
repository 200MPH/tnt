<?php

/**
 * XMLTools Test
 *
 * @author Wojciech Brozyna <wojciech.brozyna@gmail.com>
 */

namespace thm\tnt_ec\tests;

use thm\tnt_ec\XMLTools;

class XMLToolsTest  extends \PHPUnit_Framework_TestCase {
    
    /**
     * Merging test
     */
    public function testMerge()
    {
        
        $xml[] = '';
        $xml[] = '';
        $result = '';
        
        $this->assertEquals($result, XMLTools::mergeXml($xml));
        
    }
        
}
