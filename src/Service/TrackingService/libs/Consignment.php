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
     * EXCEPTION
     * There is an issue affecting the consignment. 
     * More details in the status descriptions or from calling your local TNT
     * customer services centre. 
     */
    const CODE_EXC = 'EXC';
    
    /**
     * IN TRANSIT
     * The consignment is being processed by TNT 
     */
    const CODE_INT = 'INT';
    
    /**
     * DELIVERED
     * The consignment has been delivered
     */
    const CODE_DEL = 'DEL';
    
    /**
     * CONSIGNMENT NOT FOUND
     * The search request resulted in no results
     */
    const CODE_CNF = 'CNF';
    
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
       
        if(is_array($this->xml->attributes) === true) {
            
            return $this->xml->attributes;
            
        }
        
        return array();
        
    }
    
    /**
     * Get consignment number
     * 
     * @return string
     */
    public function getConsignmentNumber()
    {
        
        if(isset($this->xml->ConsignmentNumber) === true) {
            
            return $this->xml->ConsignmentNumber;
            
        }
        
        return null;
        
    }
    
    /** 
     * Get origin depot code
     * 
     * @return string
     */
    public function getOriginDepotCode()
    {
        
        if(isset($this->xml->OriginDepot) === true) {
            
            return $this->xml->OriginDepot;
            
        }
        
        return null;
        
    }
    
    /**
     * Get origin depot name
     * 
     * @return string
     */
    public function getOriginDepotName()
    {
        
        if(isset($this->xml->OriginDepotName) === true) {
            
            return $this->xml->OriginDepotName;
            
        }
        
        return null;
        
    }
    
    /**
     * Get customer referenc
     * 
     * @return string
     */
    public function getCustomerReference()
    {
        
        if(isset($this->xml->CustomerReference) === true) {
            
            return $this->xml->CustomerReference;
            
        }
        
        return null;
        
    }
    
    /**
     * Get collection date
     * 
     * @return string
     */
    public function getCollectionDate()
    {
        
        if(isset($this->xml->CollectionDate) === true) {
            
            return $this->xml->CollectionDate;
            
        }
        
        return null;
        
    }
    
    /**
     * Get delivery town
     * 
     * @return string
     */
    public function getDeliveryTown()
    {
        
        if(isset($this->xml->DeliveryTown) === true) {
            
            return $this->xml->DeliveryTown;
            
        }
        
        return null;
        
    }
    
    /**
     * Get summary code
     * 
     * @return string
     */
    public function getSummaryCode()
    {
        
        if(isset($this->xml->SummaryCode) === true) {
            
            return $this->xml->SummaryCode;
            
        }
        
        return Consignment::CODE_CNF;
        
    }
    
    /**
     * Get destination country code
     * 
     * @return string
     */
    public function getDestinationCountryCode()
    {
        
        if(isset($this->xml->DestinationCountry) === true) {
            
            return $this->xml->DestinationCountry->CountryCode;
            
        }
        
        return null;
        
    }
    
    /**
     * Get destination country name
     * 
     * @return string
     */
    public function getDestinationCountryName()
    {
        
        if(isset($this->xml->DestinationCountry) === true) {
            
            return $this->xml->DestinationCountry->CountryName;
            
        }
        
        return null;
        
    }
    
    /**
     * Get origin country code
     * 
     * @return string
     */
    public function getOriginCountryCode()
    {
        
        if(isset($this->xml->OriginCountry) === true) {
            
            return $this->xml->OriginCountry->CountryCode;
            
        }
        
        return null;
        
    }
    
    /**
     * Get origin country name
     * 
     * @return string
     */
    public function getOriginCountryName()
    {
        
        if(isset($this->xml->OriginCountry) === true) {
            
            return $this->xml->OriginCountry->CountryName;
            
        }
        
        return null;
        
    }
    
    /**
     * Get piece quantity
     * 
     * @return int
     */
    public function getPieceQuantity()
    {
        
        if(isset($this->xml->PieceQuantity) === true) {
            
            return (int) $this->xml->PieceQuantity;
            
        }
        
        return 0;
        
    }
    
    /**
     * Get statuses (item activity)
     * 
     * @return StatusData[]
     */
    public function getStatuses()
    {
        
        return array();
        
    }
    
}
