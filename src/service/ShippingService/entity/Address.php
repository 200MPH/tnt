<?php

/**
 * TNT Address for shipping service.
 * 
 * Note that this class may looks very similar to other address class
 * but functions referrer to another XML elements therefore it cannot be extended.
 * Also some address elements maybe different then in other service. 
 *
 * @author Wojciech Brozyna <wojciech.brozyna@gmail.com>
 * @license https://github.com/200MPH/tnt/blob/master/LICENCE MIT
 */

namespace thm\tnt_ec\service\ShippingService\entity;

class Address extends AbstractXml {
    
    /**
     * @var string
     */
    private $company;
    
    /**
     * @var array
     */
    private $address = [];
    
    /**
     * @var string
     */
    private $city;
    
    /**
     * @var string
     */
    private $province;
    
    /**
     * @var string
     */
    private $postcode;
    
    /**
     * @var string
     */
    private $country;
    
    /**
     * @var string
     */
    private $vat;
    
    /**
     * @var string
     */
    private $contactName;
    
    /**
     * @var string
     */
    private $contactDialCode;
    
    /**
     * @var string
     */
    private $contactPhone;
    
    /**
     * @var string
     */
    private $email;
    
    /**
     * @var int
     */
    private $account = 0;
    
    /**
     * @var string
     */
    private $accountCountry;
    
    /**
     * Get company name
     * 
     * @return string
     */
    public function getCompanyName()
    {
        
        return $this->company;
        
    }
    
    /**
     * Get address line
     * 
     * @param int $lineNo Line number between 1-3. Default is 1.
     * If range is out of scope function will return null.
     * 
     * @return string
     */
    public function getAddressLine($lineNo = 1)
    {
        
        // array starts from 0
        $index = $lineNo - 1;
        
        if(isset($this->address[$index]) === true) {
            
            return $this->address[$index];
            
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
        
        return $this->city;
        
    }
    
    /**
     * Get province
     * 
     * @return string
     */
    public function getProvince()
    {
        
        return $this->province;
        
    }
    
    /**
     * Get postcode
     * 
     * @return string
     */
    public function getPostcode()
    {
        
        return $this->postcode;
        
    }
    
    /**
     * Get country code
     * 
     * @return string Country code ISO2 (two characters only)
     */
    public function getCountryCode()
    {
        
        return $this->country;
        
    }
    
    /**
     * Get VAT number
     * 
     * @return string
     */
    public function getVat()
    {
        
        return $this->vat;
        
    }
    
    /**
     * Get contact name
     * 
     * @return string
     */
    public function getContactName()
    {
        
        return $this->contactName;
        
    }
    
    /**
     * Get contact dial code
     * 
     * @return string
     */
    public function getContactDialCode()
    {
        
        return $this->contactDialCode;
        
    }
    
    /**
     * Get contact phone number
     * 
     * @return string
     */
    public function getContactPhoneNumber()
    {
        
        return $this->contactPhone;
        
    }
    
    /**
     * Get contact email address
     * 
     * @return string
     */
    public function getContactEmail()
    {
        
        return $this->email;
        
    }
 
    /**
     * Set company name
     * 
     * @param string $company
     * @return Address
     */
    public function setCompanyName($company) 
    {
        
        if(empty($company) === false) {
        
            $this->company = $company;
            $this->xml->writeElementCData('COMPANYNAME', $company);
            
        }
        
        return $this;
        
    }

    /**
     * Add address line.
     * Each call to this function will add new address line.
     * Maximum 3 lines.
     * 
     * @param string $address
     * @return Address
     */
    public function setAddressLine($address) 
    {
    
        if(empty($address) === false && count($this->address) < 3) {
            
            $this->address[] = $address;
            $lineNo = count($this->address);
            $this->xml->writeElementCData("STREETADDRESS" . $lineNo, $address);
            
        }
        
        return $this;
        
    }

    /**
     * Set city
     * 
     * @param string $city
     * @return Address
     */
    public function setCity($city) 
    {
        
        if(empty($city) === false) {
            
            $this->city = $city;
            $this->xml->writeElementCData('CITY', $city);
            
        }
        
        return $this;
        
    }

    /**
     * Set province
     * 
     * @param string $province
     * @return Address
     */
    public function setProvince($province) 
    {
        
        if(empty($province) === false) {
            
            $this->province = $province;
            $this->xml->writeElementCData('PROVINCE', $province);
            
        }
        
        return $this;
        
    }

    /**
     * Set postcode
     * 
     * @param string $postcode
     * @return Address
     */
    public function setPostcode($postcode) 
    {
        
        if(empty($postcode) === false) {
            
            $this->postcode = $postcode;
            $this->xml->writeElementCData('POSTCODE', $postcode);
            
        }
        
        return $this;
        
    }

    /**
     * Set country
     * 
     * @param string $country
     * @return Address ISO2 country code (two characters only)
     */
    public function setCountry($country) 
    {
        
        if(empty($country) === false) {
            
            $this->country = $country;
            $this->xml->writeElementCData('COUNTRY', $country);
            
            // automatically add account number
            // it has to be exactly in this place
            if($this->account != 0) {
                
                $this->xml->writeElementCData('ACCOUNT', $this->account);
                                
            }
            
        }
        
        return $this;
        
    }

    /**
     * Set VAT number
     * 
     * @param string $vat
     * @return Address
     */
    public function setVat($vat) 
    {
        
        if(empty($vat) === false) {
            
            $this->vat = $vat;        
            $this->xml->writeElementCData('VAT',$vat);
            
        }
        
        return $this;
        
    }

    /**
     * Set contact name
     * 
     * @param string $contactName
     * @return Address
     */
    public function setContactName($contactName) 
    {
    
        if(empty($contactName) === false) {
            
            $this->contactName = $contactName;
            $this->xml->writeElementCData('CONTACTNAME', $contactName);
            
        }
        
        return $this;
        
    }

    /**
     * Set contact dial code
     * 
     * @param string $contactDialCode
     * @return Address
     */
    public function setContactDialCode($contactDialCode) 
    {
        
        if(empty($contactDialCode) === false) {
            
            $this->contactDialCode = $contactDialCode;
            $this->xml->writeElementCData('CONTACTDIALCODE', $contactDialCode);
            
        }
        
        return $this;
        
    }

    /**
     * Set contact phone
     * 
     * @param string $contactPhone
     * @return Address
     */
    public function setContactPhone($contactPhone) 
    {
        
        if(empty($contactPhone) === false) {
            
            $this->contactPhone = $contactPhone;
            $this->xml->writeElementCData('CONTACTTELEPHONE', $contactPhone);
            
        }
        
        return $this;
        
    }

    /**
     * Set contact email
     * 
     * @param string $email
     * @return Address
     */
    public function setContactEmail($email) 
    {
        
        if(empty($email) === false) {
            
            $this->email = $email;
            $this->xml->writeElementCData('CONTACTEMAIL', $email);
            
        }
        
        return $this;
        
    }

    /**
     * Set account
     * 
     * @param int $accountNumber
     * @return Address
     */
    public function setAccountNumber($accountNumber)
    {
        
            $this->account = $accountNumber;      
            return $this;
        
    }
    
    /**
     * Set account country
     * 
     * @param string $accountCountry ISO2 country code
     * @return Address
     */
    public function setAcountCountry($accountCountry)
    {
        
        $this->accountCountry = $accountCountry;        
        return $this;      
        
    }
    
    /**
     * Get account
     * 
     * @return string
     */
    public function getAccount()
    {
        
        return $this->account;
        
    }
    
    /**
     * Get account country code
     * 
     * @return string
     */
    public function getAccountCountryCode()
    {
        
        return $this->accountCountry;
        
    }
    
}