<?php

/**
 * TNT Consignment entity
 * It's based on wrapper design patter as we wrap the output 
 * to the more user friendly object by giving function for each XML property
 *
 * @author Wojciech Brozyna <wojciech.brozyna@gmail.com>
 * @license https://github.com/200MPH/tnt/blob/master/LICENCE MIT
 */

namespace thm\tnt_ec\service\TrackingService\entity;

use SimpleXMLElement;
use thm\tnt_ec\service\TrackingService\entity\AddressParty;
use thm\tnt_ec\service\TrackingService\entity\Package;
use thm\tnt_ec\service\TrackingService\entity\ShipmentSummary;
use thm\tnt_ec\service\TrackingService\entity\StatusData;

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
     * Statuses
     * 
     * @var StatusData[]
     */
    private $statuses = [];
    
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
     * Get access type
     * 
     * @return string
     */
    public function getAccessType()
    {
        
        $attributes = $this->xml->attributes();
        
        if(isset($attributes['access'])) {
            
            return $attributes['access']->__toString();
            
        }
        
        return 'public';
        
    }
    
    /**
     * Get consignment number
     * 
     * @return int
     */
    public function getConsignmentNumber()
    {
        
        if(isset($this->xml->ConsignmentNumber) === true) {
            
            return $this->xml->ConsignmentNumber->__toString();;
            
        }
        
        return null;
        
    }
    
    /**
     * Get alternative consignment number
     * 
     * @return int
     */
    public function getAlternativeConsignmentNumber()
    {
        
        if(isset($this->xml->AlternativeConsignmentNumber) === true) {
            
            return $this->xml->AlternativeConsignmentNumber->__toString();;
            
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
            
            return $this->xml->OriginDepotName->__toString();
            
        }
        
        return null;
        
    }
    
    /**
     * Get customer reference
     * 
     * @return string
     */
    public function getCustomerReference()
    {
        
        if(isset($this->xml->CustomerReference) === true) {
            
            return $this->xml->CustomerReference->__toString();
            
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
            
            return $this->xml->DeliveryTown->__toString();
            
        }
        
        return null;
        
    }
    
    /**
     * Get summary code - status code
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
            
            return $this->xml->DestinationCountry->CountryName->__toString();
            
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
            
            return $this->xml->OriginCountry->CountryName->__toString();
            
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
     * Get delivery date - if delivered
     * 
     * @param $format [optional] Return as customized date format. Default YYYYMMDD
     * @return string
     */
    public function getDeliveredDate($format = false)
    {
        
        if(isset($this->xml->DeliveryDate) === true) {
            
            if($format === false) {
            
                return $this->xml->DeliveryDate;
            
            } else {
                
                $date = \DateTime::createFromFormat('Ymd', $this->xml->DeliveryDate);
                
                return $date->format($format);
                
            }
            
        }
        
        return null;
        
    }
    
    /**
     * Get delivery time - if delivered
     * 
     * @param $format [optional] Return as customized time format. Default HHMM
     * @return string
     */
    public function getDeliveredTime($format = false)
    {
        
        if(isset($this->xml->DeliveryTime) === true) {
            
            if($format === false) {
            
                return $this->xml->DeliveryTime;
            
            } else {
                
                $date = \DateTime::createFromFormat('Hi', $this->xml->DeliveryTime);
                
                return $date->format($format);
                
            }
            
        }
        
        return null;
        
    }
    
    /**
     * Get signatory - if delivered
     * 
     * @return string
     */
    public function getSignatory()
    {
        
        if(isset($this->xml->Signatory)) {
            
            return $this->xml->Signatory->__toString();
            
        }
        
        return null;
        
    }
    
    /**
     * Get payment account number
     * 
     * @return string
     */
    public function getPaymentAccountNumber()
    {
        
        if(isset($this->xml->TermsOfPaymentAccount) === true) {
            
            return $this->xml->TermsOfPaymentAccount->Number;
            
        }
        
        return null;
        
    }
    
    /**
     * Get payment country code
     * 
     * @return $string
     */
    public function getPaymentCountryCode()
    {
        
        if(isset($this->xml->TermsOfPaymentAccount) === true) {
            
            return $this->xml->TermsOfPaymentAccount->CountryCode;
            
        }
        
        return null;
        
    }
    
    /**
     * Get sender account number
     * 
     * @return string
     */
    public function getSenderAccountNumber()
    {
        
        if(isset($this->xml->SenderAccount) === true) {
            
            return $this->xml->SenderAccount->Number->__toString();
            
        }
        
        return null;
        
    }
    
    /**
     * Get sender account country code
     * 
     * @return string
     */
    public function getSenderAccountCountryCode()
    {
        
        if(isset($this->xml->SenderAccount) === true) {
            
            return $this->xml->SenderAccount->CountryCode;
            
        }
        
        return null;
        
    }
    
    /**
     * Get address party
     * 
     * @param string $type Address type: Sender, Collection, Receiver, Delivery
     * @return AddressParty
     */
    public function getAddressParty($type = 'Sender')
    {
        
        if(isset($this->xml->Addresses) === true) {
            
            foreach($this->xml->Addresses->Address as $address) {
                
                $attribute = $address->attributes();
               
                if(isset($attribute['addressParty']) == ucfirst($type)) {
                    
                    return new AddressParty($address);
                    
                }
                
            }
            
        }
        
        // return empty object
        return new AddressParty(new \SimpleXMLElement('<root></root>'));
        
    }
    
    /**
     * Get package summary
     * 
     * @return Package
     */
    public function getPackageSummary()
    {
        
        if(isset($this->xml->PackageSummary) === true) {
            
            return new Package($this->xml->PackageSummary);
            
        }
        
        // return empty object
        return new Package(new \SimpleXMLElement('<root></root>'));
        
    }
    
    /**
     * Get shipment summary
     * 
     * @return ShipmentSummary
     */
    public function getShipmentSummary()
    {
        
        if(isset($this->xml->ShipmentSummary) === true) {
            
            return new ShipmentSummary($this->xml->ShipmentSummary);
            
        }
        
        // return empty object
        return new ShipmentSummary(new \SimpleXMLElement('<root></root>'));
        
    }
    
    /**
     * Get POD image.
     * 
     * @param bool $fileContent [optional] If TRUE will download and return file content
     * @return string URL to the image or file content if $fileContent = TRUE. 
     */
    public function getPod($fileContent = false)
    {
        
        if(isset($this->xml->POD) === true) {
            
            // clean up string
            $url = str_replace(array("\n", ' '), '', $this->xml->POD->__toString());
            
            if($fileContent === true) {
                
                return file_get_contents($url);
                
            } else {
                
                return $url;
                
            }
            
        }
        
        return null;
        
    }
    
    /**
     * Get statuses (item activity)
     * 
     * @return StatusData[]
     */
    public function getStatuses()
    {
        
        if(isset($this->xml->StatusData) === true) {
            
            $this->setStatus();
            
        }
        
        return $this->statuses;
        
    }
    
    /**
     * Set status
     * 
     * @return void
     */
    private function setStatus()
    {
        
        $this->statuses = [];
        
        foreach($this->xml->StatusData as $xml) {
                
            $this->statuses[] = new StatusData($xml);
                
        }
        
    }
    
}
