<?php

/**
 * TNT Consignment Status Data entity
 *
 * @author Wojciech Brozyna <wojciech.brozyna@gmail.com>
 * @license https://github.com/200MPH/tnt/blob/master/LICENCE MIT
 */

namespace thm\tnt_ec\service\TrackingService\entity;

use SimpleXMLElement;

class StatusData {
    
    /**
     * @var SimpleXMLElement
     */
    private $xml;
    
    /**
     * Initialize StatusData object
     * 
     * @param SimpleXMLElement $xml
     */
    public function __construct(SimpleXMLElement $xml)
    {
        
        $this->xml = $xml;
        
    }
    
    /**
     * Get status code
     * 
     * @return string
     */
    public function getStatusCode()
    {
        
        if(isset($this->xml->StatusCode) === true) {
            
            return $this->xml->StatusCode;
            
        }
        
        return null;
        
    }
    
    /**
     * Get status description
     * 
     * @return string
     */
    public function getStatusDescription()
    {
        
        if(isset($this->xml->StatusDescription) === true) {
            
            return $this->xml->StatusDescription->__toString();
            
        }
        
        return null;
        
    }
    
    /**
     * Get local event date
     * 
     * @param $format [optional] Return as customized date format. Default YYYYMMDD
     * @return string
     */
    public function getLocalEventDate($format = false)
    {
        
        if(isset($this->xml->LocalEventDate) === true) {
            
            if($format === false) {
            
                return $this->xml->LocalEventDate;
            
            } else {
                
                $date = \DateTime::createFromFormat('Ymd', $this->xml->LocalEventDate);
                
                return $date->format($format);
                
            }
            
        }
        
        return null;
        
    }
    
    /**
     * Get local event time
     *
     * @param format [optional] Return as customized time format. Default HHMM 
     * @return string
     */
    public function getLocalEventTime($format = false)
    {
        
        if(isset($this->xml->LocalEventTime) === true) {
            
            if($format === false) {
            
                return $this->xml->LocalEventTime;
            
            } else {
                
                $date = \DateTime::createFromFormat('Hi', $this->xml->LocalEventTime);
                
                return $date->format($format);
                
            }
            
        }
        
        return null;
        
    }
    
    /**
     * Get depot code
     * 
     * @return string
     */
    public function getDepotCode()
    {
        
        if(isset($this->xml->Depot)) {
            
            return $this->xml->Depot;
            
        }
     
        return null;
        
    }
    
    /**
     * Get depot name
     * 
     * @return string
     */
    public function getDepotName()
    {
        
        if(isset($this->xml->DepotName)) {
            
            return $this->xml->DepotName->__toString();
            
        }
        
        return null;
        
    }
    
}
