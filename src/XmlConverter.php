<?php

/**
 * XML Converter.
 * Convert XML string into other formats.
 *
 * @author Wojciech Brozyna <http://vobro.systems>
 * @license https://github.com/200MPH/tnt/blob/master/LICENCE MIT
 */

namespace thm\tnt_ec;

use SimpleXMLElement;

class XmlConverter {
    
    /**
     * @var string
     */
    private $xml;
    
    /**
     * Construct object
     * 
     * @param string $xml
     */
    public function __construct(string $xml) 
    {
            
        $this->xml = $xml;
        
    }
    
    /**
     * If treated as object return given XML string.
     */
    public function __toString() {
        
        return $this->toString();
        
    }
    
    /**
     * Get as string
     * 
     * @return string
     */
    public function toString()
    {
        
        return $this->xml;
        
    }
    
    /**
     * Get as XML object
     * 
     * @return SimpleXMLElement
     */
    public function toXml()
    {
        
        return new SimpleXMLElement($this->xml);
                
    }
    
}
