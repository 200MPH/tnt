<?php

/**
 * Activity Response
 *
 * @author Wojciech Brozyna <http://vobro.systems>
 * @license https://github.com/200MPH/tnt/blob/master/LICENCE MIT
 */

namespace thm\tnt_ec\service\ShippingService;

use thm\tnt_ec\service\AbstractResponse;

class ActivityResponse extends AbstractResponse {
    
    /**
     * Catch errors from Activity service
     * 
     * @return void
     */
    protected function catchConcreteResponseError()
    {
                
        $complete = explode(':', $this->getResponse());
        
        if(isset($complete[0]) && $complete[0] === 'COMPLETE') {
        
            $key = (int) $complete[1];
            $this->activity = new Activity($this->user, $this->password, $key);
            
        } else {
            
            $this->catchXmlErrors();
            
        }
        
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
    
}
