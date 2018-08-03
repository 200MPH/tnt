<?php

/**
 * Activity Results. It's a wrapper for ActivityResponde
 *
 * @author Wojciech Brozyna <http://vobro.systems>
 * @license https://github.com/200MPH/tnt/blob/master/LICENCE MIT
 */

namespace thm\tnt_ec\service\ShippingService;

use thm\tnt_ec\XmlConverter;

class ActivityResult {    
    
    /**
     * @var ActivityResponse
     */
    private $response;


    /**
     * @var array
     */
    private $results = [];
            
    /**
     * Activity Response Constructor
     * 
     * @param ActivityResponse & $ar
     */
    public function __construct(ActivityResponse & $ar)
    {
             
        $this->response = $ar;
        $this->init();
        
    }
    
    /**
     * Has errors
     * 
     * @return bool
     */
    public function hasError()
    {
        
        return $this->response->hasError();
        
    }
    
    /**
     * Get errors
     * 
     * @return array
     */
    public function getErrors()
    {
        
        return $this->response->getErrors();
        
    }
    
    /**
     * Get results.
     * Returns consignment numbers 
     * and document print availability  information.
     * 
     * @return array
     */
    public function getResults()
    {
        
        return $this->results;
        
    }
    
    /**
     * Get consignment note
     * 
     * @return XmlConverter
     */
    public function getConsignmentNote()
    {
        
        if($this->results['PRINT']['CONNOTE'] === 'Y') {
        
            $xml = $this->srs->getResult($this->key, 'GET_CONNOTE');
            return new XmlConverter($xml);
            
        }
        
        return '';
        
    }
    
    /**
     * Get label
     * 
     * @return XmlConverter
     */
    public function getLabel()
    {
        
        if($this->results['PRINT']['LABEL'] === 'Y') {
        
            $xml = $this->srs->getResult($this->key, 'GET_LABEL');
            return new XmlConverter($xml);
            
        }
        
        return '';
        
    }
    
    /**
     * Get manifest
     * 
     * @return XmlConverter
     */
    public function getManifest()
    {
        
        if($this->results['PRINT']['MANIFEST'] === 'Y') {
        
            $xml = $this->srs->getResult($this->key, 'GET_MANIFEST');
            return new XmlConverter($xml);
            
        }
        
        return '';
        
    }
    
    /**
     * Get invoice
     * 
     * @return XMLConverter
     */
    public function getInvoice()
    {
        
        if($this->results['PRINT']['MANIFEST'] === 'Y') {
        
            $xml = $this->srs->getResult($this->key, 'GET_INVOICE');
            return new XmlConverter($xml);
            
        }
        
        return '';
        
    }
    
    /**
     * Set activity result
     * 
     * @return void
     */
    private function init()
    {
        
        if($this->hasError() === true) { return array(); }
        
        $this->results['PRINT']['CONNOTE']  = 'N';
        $this->results['PRINT']['LABEL']    = 'N';
        $this->results['PRINT']['MANIFEST'] = 'N';
        $this->results['PRINT']['INVOICE']  = 'N';
        
        $this->simpleXml = simplexml_load_string($this->response->getResponse());
        
        $this->setFromCreateElement();
        $this->setFromElement('BOOK');
        $this->setFromElement('SHIP');
        $this->setFromPrint();
                
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