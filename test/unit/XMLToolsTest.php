<?php

/**
 * XMLTools Test
 *
 * @author Wojciech Brozyna <http://vobro.systems>
 */

namespace thm\tnt_ec\test\unit;

use thm\tnt_ec\XMLTools;

class XMLToolsTest  extends \PHPUnit_Framework_TestCase {
    
    /**
     * Merging test
     */
    public function testMerge()
    {
        
        $xml[] = '<?xml version="1.0"?><track><consignment><item>1</item></consignment><consignment><item>2</item></consignment></track>';
        $xml[] = '<?xml version="1.0"?><track><consignment><item>3</item></consignment><consignment><item>4</item></consignment></track>';
        $xml[] = null; // this must be skipped by function
        $xml[] = '<?xml version="1.0"?><track><consignment><item>5</item></consignment><consignment><item>6</item></consignment></track>';
        
        $result = '<?xml version="1.0"?><track><consignment><item>1</item></consignment><consignment><item>2</item></consignment><consignment><item>3</item></consignment><consignment><item>4</item></consignment><consignment><item>5</item></consignment><consignment><item>6</item></consignment></track>';
        
        $this->assertEquals($result, XMLTools::mergeXml($xml));
        
    }
    
}
