<?php

/**
 * TNT Package summary entity
 *
 * @author Wojciech Brozyna <wojciech.brozyna@gmail.com>
 * @license https://github.com/200MPH/tnt/blob/master/LICENCE MIT
 */

namespace thm\tnt_ec\service\TrackingService\entity;

use SimpleXMLElement;

class Package {
    
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
     * Get number of pieces
     * 
     * @return int
     */
    public function getNumberOfPieces()
    {
        
        if(isset($this->xml->NumberOfPieces) === true) {
            
            return (int)$this->xml->NumberOfPieces;
            
        }
        
        return 0;
        
    }
    
    /**
     * Get weight
     * 
     * @return float
     */
    public function getWeight()
    {
        
        if(isset($this->xml->Weight) === true) {
            
            return (float)$this->xml->Weight;
            
        }
        
        return 0.00;
        
    }
    
    /**
     * Get package description
     * 
     * @return string
     */
    public function getPackageDescription()
    {
        
        if(isset($this->xml->PackageDescription) === true) {
            
            return $this->xml->PackageDescription->__toString();
            
        }
        
        return null;
        
    }
    
    /**
     * Get goods description
     * 
     * @return string
     */
    public function getGoodsDescription()
    {
        
        if(isset($this->xml->GoodsDescription) === true) {
            
            return $this->xml->GoodsDescription->__toString();
            
        }
        
        return null;
        
    }
    
    /**
     * Get invoice amount
     * 
     * @return float
     */
    public function getInvoiceAmount()
    {
        
        if(isset($this->xml->InvoiceAmount) === true) {
            
            return (float)$this->xml->InvoiceAmount->__toString();
            
        }
        
        return 0.00;
        
    }
    
    /**
     * Get invoice currency
     * 
     * @return string
     */
    public function getInvoiceCurrency()
    {
        
        if(isset($this->xml->InvoiceAmount) === true) {
            
            $attributes = $this->xml->InvoiceAmount->attributes();
            
            if(isset($attributes['currency']) === true) {
                
                return $attributes['currency'];
                
            }
            
        }
        
        return null;
        
    }
    
}
