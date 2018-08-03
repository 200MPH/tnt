<?php

/**
 * Shipping Response
 *
 * @author Wojciech Brozyna <http://vobro.systems>
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
     * @var string
     */
    private $password;
                
    /**
     * Response constructor
     * 
     * @param string $response
     * @param string $requestXml
     * @param string $userId
     * @param string $password
     */
    public function __construct(string $response, 
                                string $requestXml, 
                                string $userId, 
                                string $password)
    {
        
        $this->userId = $userId;
        $this->password = $password;       
               
        parent::__construct($response, $requestXml);
        
    }
    
    /**
     * Get key - response key. 0 usually means fail.
     * 
     * @return int
     */
    public function getKey()
    {
        
        return $this->key;
        
    }
    
    /**
     * Get activity
     *  
     * @return ActivityResponse
     */
    public function getActivity()
    {
        
        
        
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
        
}
