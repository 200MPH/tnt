<?php

/**
 * Abstract Shipping Response
 *
 * @author Wojciech Brozyna <http://vobro.systems>
 */

namespace thm\tnt_ec\service\ShippingService;

use thm\tnt_ec\service\AbstractResponse;

abstract class AbstractShippingResponse extends AbstractResponse {
    
    /**
     * Catch errors
     * 
     * @return void
     */
    protected function catchErrors()
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
        
        $this->validateXml();
        
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
    
}
