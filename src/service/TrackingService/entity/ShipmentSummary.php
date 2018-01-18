<?php

/**
 * TNT Shipment Summary entity
 *
 * @author Wojciech Brozyna <wojciech.brozyna@gmail.com>
 * @license https://github.com/200MPH/tnt/blob/master/LICENCE MIT
 */

namespace thm\tnt_ec\service\TrackingService\entity;

use SimpleXMLElement;

class ShipmentSummary {
    
    /**
     * @var SimpleXMLElements
     */
    private $xml;
    
    /**
     * Initialize object
     * 
     * @param SimpleXMLElement $xml
     */
    public function __construct(SimpleXMLElement $xml)
    {
        
        $this->xml = $xml;
        
    }
    
    /**
     * Get terms of payment
     * 
     * @return string
     */
    public function getTermsOfPayment()
    {
        
        if(isset($this->xml->TermsOfPayment) === true) {
            
            return $this->xml->TermsOfPayment;
            
        }
        
        return null;
        
    }
    
    /**
     * Get due date
     * 
     * @param $format [optional] Return as customized date format. Default YYYYMMDD
     * @return string
     */
    public function getDueDate($format = false)
    {
        
        if(isset($this->xml->DueDate) === true) {
            
            if($format === false) {
            
                return $this->xml->DueDate;
            
            } else {
                
                $date = \DateTime::createFromFormat('Ymd', $this->xml->DueDate);
                
                return $date->format($format);
                
            }
            
        }
        
        return null;
        
    }
    
    /**
     * Get service name
     * 
     * @return string
     */
    public function getService()
    {
        
        if(isset($this->xml->Service) === true) {
            
            return $this->xml->Service->__toString();
            
        }
        
        return null;
        
    }
    
}
