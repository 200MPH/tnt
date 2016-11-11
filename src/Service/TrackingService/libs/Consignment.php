<?php

/**
 * TNT Consignment entity
 * It's based on wrapper design patter as we wrap the output 
 * to the more user friendly object by giving function for each XML property
 *
 * @author Wojciech Brozyna <wojciech.brozyna@gmail.com>
 */

namespace thm\tnt_ec\Service\TrackingService\libs;

use SimpleXMLElement;

class Consignment {
    
    /**
     * @var SimpleXMLElement
     */
    private $xml;
    
    /**
     * Initialize object
     * 
     * @param SimpleXMLElement Reference to object
     */
    public function __construct(SimpleXMLElement $xml)
    {
     
        $this->xml = $xml;
        
    }
    
    /**
     * Get attributes
     * 
     * @return array
     */
    public function getAttributes()
    {
        
        return $this->attributes;
        
    }
    
    /**
     * Get consignment number
     * 
     * @return string
     */
    public function getConsignmentNumber()
    {
        
        return $this->consignmentNumber;
        
    }
    
    /** 
     * Get origin depot code
     * 
     * @return string
     */
    public function getOriginDepotCode()
    {
        
        return $this->originDepotCode;
        
    }
    
}
