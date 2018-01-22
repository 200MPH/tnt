<?php

/**
 * TNT Address Party for tracking service.
 * 
 * Note that this class may looks very similar to other address class
 * but functions referrer to another XML elements therefore it cannot be extended.
 * Or just partially extended.
 *
 * @author Wojciech Brozyna <wojciech.brozyna@gmail.com>
 * @license https://github.com/200MPH/tnt/blob/master/LICENCE MIT
 */

namespace thm\tnt_ec\service\TrackingService\entity;

use SimpleXMLElement;

class AddressParty {
    
    /* Address types */
    const T_SENDER      = 'Sender';
    const T_COLLECTION  = 'Collection';
    const T_RECEIVER    = 'Receiver';
    const T_DELIVERY    = 'Delivery';
    
    /**
     * @var SimpleXMLElement
     */
    protected $xml;
    
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
     * Get name
     * 
     * @return string
     */
    public function getName()
    {
        
        if(isset($this->xml->Name) === true) {
            
            return $this->xml->Name->__toString();
            
        }
        
        return null;
        
    }
    
    /**
     * Get address line
     * 
     * @param int $lineNo Line number between 1-3. Default is 1.
     * If range is out of scope function will return null value.
     * 
     * @return string
     */
    public function getAddressLine($lineNo = 1)
    {
        
        // array starts from 0
        $index = $lineNo - 1;
        
        if(isset($this->xml->AddressLine[$index]) === true) {
            
            return $this->xml->AddressLine[$index]->__toString();
            
        }
        
        return null;
        
    }
    
    /**
     * Get city
     * 
     * @return string
     */
    public function getCity()
    {
        
        if(isset($this->xml->City) === true) {
            
            return $this->xml->City->__toString();
            
        }
     
        return null;
        
    }
    
    /**
     * Get province
     * 
     * @return string
     */
    public function getProvince()
    {
        
        if(isset($this->xml->Province) === true) {
            
            return $this->xml->Province->__toString();
            
        }
     
        return null;
        
    }
    
    /**
     * Get postcode
     * 
     * @return string
     */
    public function getPostcode()
    {
        
        if(isset($this->xml->Postcode) === true) {
            
            return $this->xml->Postcode->__toString();
            
        }
     
        return null;
        
    }
    
    /**
     * Get country code
     * 
     * @return string
     */
    public function getCountryCode()
    {
        
        if(isset($this->xml->Country) === true) {
            
            return $this->xml->Country->CountryCode;
            
        }
     
        return null;
        
    }
    
    /**
     * Get country name
     * 
     * @return string
     */
    public function getCountryName()
    {
        
        if(isset($this->xml->Country->CountryName) === true) {
            
            return $this->xml->Country->CountryName->__toString();
            
        }
     
        return null;
        
    }
    
    /**
     * Get phone number
     * 
     * @return string
     */
    public function getPhoneNumber()
    {
        
        if(isset($this->xml->PhoneNumber) === true) {
            
            return $this->xml->PhoneNumber->__toString();
            
        }
     
        return null;
        
    }
    
    /**
     * Get contact name
     * 
     * @return string
     */
    public function getContactName()
    {
        
        if(isset($this->xml->ContactName) === true) {
            
            return $this->xml->ContactName->__toString();
            
        }
     
        return null;
        
    }
    
    /**
     * Get contact phone number
     * 
     * @return string
     */
    public function getContactPhoneNumber()
    {
        
        if(isset($this->xml->ContactPhoneNumber) === true) {
            
            return $this->xml->ContactPhoneNumber->__toString();
            
        }
     
        return null;
        
    }
    
    /**
     * Get account number.
     * Please not this might be populated only for SENDER address.
     * 
     * @return string
     */
    public function getAccountNumber()
    {
        
        if(isset($this->xml->AccountNumber) === true) {
            
            return $this->xml->AccountNumber->__toString();
            
        }
     
        return null;
        
    }
    
    /**
     * Get VAT number.
     * Please not this might be populated only for SENDER address.
     * 
     * @return string
     */
    public function getVatNumber()
    {
        
        if(isset($this->xml->VATNumber) === true) {
            
            return $this->xml->VATNumber->__toString();
            
        }
     
        return null;
        
    }
    
}
