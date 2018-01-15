<?php

/**
 * Generate XML document based on child object properties.
 *
 * @author Wojciech Brozyna <wojciech.brozyna@gmail.com>
 * @license https://github.com/200MPH/tnt/blob/master/LICENCE MIT
 */

namespace thm\tnt_ec\service\ShippingService\entity;

use XMLWriter;

abstract class AbstractXml {
    
   /**
     * @var XMLWriter
     */
    protected $xml; 
 
    /**
     * Initialise object
     */
    public function __construct()
    {
        
        $this->xml = new \XMLWriter();
        $this->xml->openMemory();
        $this->xml->setIndent(true);
        
    }
    
    /**
     * Flush XML memory when destruct object
     */
    public function __destruct() 
    {
    
        $this->xml->flush();
        
    }
    
    /**
     * Get entire XML as a string
     * 
     * @return string
     */
    public function getAsXml()
    {
        
        return $this->xml->flush(false);
        
    }
    
}