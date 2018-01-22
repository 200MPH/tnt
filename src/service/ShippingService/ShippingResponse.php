<?php

/**
 * Shipping Response
 *
 * @author Wojciech Brozyna <wojciech.brozyna@gmail.com>
 * @license https://github.com/200MPH/tnt/blob/master/LICENCE MIT
 */

namespace thm\tnt_ec\service\ShippingService;

use thm\tnt_ec\service\AbstractResponse;

class ShippingResponse extends AbstractResponse {    
    
    /**
     * @var int
     */
    private $key = 0;
    
    /**
     * @var string
     */
    private $userId;
    
    /**
     * @var ResultService
     */
    private $rs;
    
    /**
     * @var array
     */
    private $results = [];
            
    /**
     * 
     * @param string $response
     * @param string $requestXml
     * @param string $userId
     * @param string $password
     */
    public function __construct($response, $requestXml, $userId, $password)
    {
        
        $this->userId = $userId;
        $this->password = $password;
        $this->rs = new ResultService($userId, $password);
        
        //init PRINT array
        $this->results['PRINT']['CONNOTE'] = 'N';
        $this->results['PRINT']['LABEL']    = 'N';
        $this->results['PRINT']['MANIFEST'] = 'N';
        $this->results['PRINT']['INVOICE']  = 'N';
        
        parent::__construct($response, $requestXml);
        
    }
    
    /**
     * Get key - response key
     * 
     * @return int
     */
    public function getKey()
    {
        
        return $this->key;
        
    }
    
    /**
     * Set key.
     * Useful when documents need to re-download.
     * Note, TNT keeps files up to 26 days after consignment create.
     * 
     * @param int $key
     * @return ShippingResponse
     */
    public function setKey($key) 
    {
        
        $this->key = $key;
        return $this;
        
    }
    
    /**
     * Get results
     * 
     * @return array
     */
    public function getResults()
    {
        
        if($this->hasError() === true) { return array(); }
        
        $this->setFromCreateElement();
        $this->setFromElement('BOOK');
        $this->setFromElement('SHIP');
        $this->setFromPrint();
        
        return $this->results;
        
    }
    
    /**
     * Get consignment note
     * 
     * @return string
     */
    public function getConsignmentNote()
    {
        
        if($this->results['PRINT']['CONNOTE'] === 'Y') {
        
            return $this->rs->getResult($this->key, 'GET_CONNOTE');
        
        }
        
        return '';
        
    }
    
    /**
     * Get label
     * 
     * @return string
     */
    public function getLabel()
    {
        
        if($this->results['PRINT']['LABEL'] === 'Y') {
        
            return $this->rs->getResult($this->key, 'GET_LABEL');
        
        }
        
        return '';
        
    }
    
    /**
     * Get manifest
     * 
     * @return string
     */
    public function getManifest()
    {
        
        if($this->results['PRINT']['MANIFEST'] === 'Y') {
        
            return $this->rs->getResult($this->key, 'GET_MANIFEST');
        
        }
        
        return '';
        
    }
    
    /**
     * Get invoice
     * 
     * @return string
     */
    public function getInvoice()
    {
        
        if($this->results['PRINT']['MANIFEST'] === 'Y') {
        
            return $this->rs->getResult($this->key, 'GET_INVOICE');
        
        }
        
        return '';
        
    }
    
    /**
     * Catch errors for shipping service
     * 
     * @return void
     */
    protected function catchConcreteResponseError()
    {
                
        $complete = explode(':', $this->getResponse());
        
        if(isset($complete[0]) && $complete[0] === 'COMPLETE') {
        
            $this->key = (int) $complete[1];
            $this->setActivityResult();
            
        } else {
            
            $this->catchXmlErrors();
            
        }
        
    }

    /**
     * Set activity result
     * 
     * @return void
     */
    private function setActivityResult()
    {
        
        $this->response = $this->rs->getResult($this->key, 'GET_RESULT');
        $this->simpleXml = simplexml_load_string($this->response);
        $this->catchXmlErrors();
        
    }
    
    /**
     * Catch XML errors
     * 
     * @return void
     */
    private function catchXmlErrors()
    {
        
        $this->catchRuntimeErrors();
        $this->catchValidationErrors();
                
    }
    
    /**
     * Catch runtime errors
     * 
     * @return void
     */
    private function catchRuntimeErrors()
    {
        
        if(isset($this->simpleXml->error_reason) === true) {
            
            $this->hasError = true;
            $this->errors[] = $this->simpleXml->error_reason->__toString();
                        
            if(isset($this->simpleXml->error_line) === true) {
                
                $this->errors[] = "Line: {$this->simpleXml->error_line}";
                
            }
            
            if(empty($this->simpleXml->error_srcText->__toString()) === false) {
                
                $this->errors[] = $this->simpleXml->error_srcText->__toString();
                
            }
                        
        }
        
    }
    
    /**
     * Catch validation errors
     * 
     * @return void
     */
    private function catchValidationErrors()
    {
          
        if(isset($this->simpleXml->ERROR) === false) { return null; }
        
        $this->hasError = true;

        if(is_array($this->simpleXml->ERROR) === true) {

            foreach($this->simpleXml->ERROR as $xml) {

                $this->errors[] = $xml->CODE->__toString();
                $this->errors[] = $xml->DESCRIPTION->__toString();
                $this->errors[] = $xml->SOURCE->__toString();

            }

        } else {
            
            $this->errors[] = $this->simpleXml->ERROR->CODE->__toString();
            $this->errors[] = $this->simpleXml->ERROR->DESCRIPTION->__toString();
            $this->errors[] = $this->simpleXml->ERROR->SOURCE->__toString();

        }

    } 
    
    /**
     * Set result from <CREATE> element
     * 
     * @void
     */
    private function setFromCreateElement()
    {
        
        if(isset($this->simpleXml->CREATE) === false) { return null; }
        
        if(is_array($this->simpleXml->CREATE) === true) {

            foreach($this->simpleXml->CREATE as $xml) {
                
                $consignmentRef = $xml->CONREF->__toString();
                $consignmentNumber = $xml->CONNUMBER->__toString();
                
                $this->results[$consignmentRef]['NUMBER'] = $consignmentNumber;
                $this->results[$consignmentRef]['CREATE'] = $xml->SUCCESS->__toString();
                
            }

        } else {

            $consignmentRef = $this->simpleXml->CREATE->CONREF->__toString();
            $consignmentNumber = $this->simpleXml->CREATE->CONNUMBER->__toString();
            
            $this->results[$consignmentRef]['NUMBER'] = $consignmentNumber;
            $this->results[$consignmentRef]['CREATE'] = $this->simpleXml->CREATE->SUCCESS->__toString();

        }
        
    }
    
    /**
     * Set result from selected element name
     * 
     * @param string $element Element name to get data from
     * @void
     */
    private function setFromElement($element)
    {
        
        if(isset($this->simpleXml->{$element}) === false) { return null; }
        
        if(is_array($this->simpleXml->{$element}->CONSIGNMENT) === true) {

            foreach($this->simpleXml->{$element}->CONSIGNMENT as $xml) {

                $consignmentRef = $xml->CONREF->__toString();
                $this->results[$consignmentRef][$element] = $xml->SUCCESS->__toString();
                $this->setBookingRef($consignmentRef, $xml);
                
            }

        } else {

            $consignmentRef = $this->simpleXml->{$element}->CONSIGNMENT->CONREF->__toString();
            $this->results[$consignmentRef][$element] = $this->simpleXml->{$element}->CONSIGNMENT->SUCCESS->__toString();
            $this->setBookingRef($consignmentRef, $this->simpleXml->CONSIGNMENT);
            
        }
        
    }
    
    /**
     * Set from <PRINT>
     * 
     * @return void
     */
    private function setFromPrint()
    {
        
        if(isset($this->simpleXml->PRINT) === false) { return null; }
        
        if(isset($this->simpleXml->PRINT->CONNOTE) === true 
           && $this->simpleXml->PRINT->CONNOTE == 'CREATED') {
            
            $this->results['PRINT']['CONNOTE'] = 'Y';
            
        }
        
        if(isset($this->simpleXml->PRINT->LABEL) === true 
           && $this->simpleXml->PRINT->LABEL == 'CREATED') {
            
            $this->results['PRINT']['LABEL'] = 'Y';
            
        }
        
        if(isset($this->simpleXml->PRINT->MANIFEST) === true 
           && $this->simpleXml->PRINT->MANIFEST == 'CREATED') {
            
            $this->results['PRINT']['MANIFEST'] = 'Y';
            
        }
        
        if(isset($this->simpleXml->PRINT->INVOICE) === true 
           && $this->simpleXml->PRINT->INVOICE == 'CREATED') {
            
            $this->results['PRINT']['INVOICE'] = 'Y';
            
        }
        
    }
    
    /**
     * Set booking reference
     * 
     * @param string $consignmentRef
     * @param \SimpleXMLElement & $xml
     * @return void
     */
    private function setBookingRef($consignmentRef, \SimpleXMLElement & $xml)
    {
        
        if(isset($xml->BOOKINGREF) === true) {
            
            $this->results[$consignmentRef]['BOOKINGREF'] = $xml->BOOKINGREF->__toString();
            
        }
        
    }
    
}
