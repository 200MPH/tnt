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
     * Get consignment note
     * 
     * @param int $key [optional] Useful when performing <ACTIVITY> request later.
     * @return string
     */
    public function getConsignmentNote()
    {
     
        return $this->rs->getResult($this->key, 'GET_CONNOTE');
        
    }
            
    /**
     * Get activity result
     * 
     * @param int $key [optional] Useful when performing <ACTIVITY> request later.
     * @return string Raw
     */
    public function getActivityResult($key = 0)
    {
        
        if($key === 0) {

            // try local key
            $key = $this->key;

        }
        
        if(isset($this->results[$key]) === false) {
        
            $this->results[$key] = $this->rs->getResult($key, 'GET_RESULT');
            $this->simpleXml = simplexml_load_string($this->results[$key]);
            $this->catchXmlErrors();
            
        }
                
        return $this->results[$key];
        
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
        
        // catch runtime error
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
        
        // catch validation error
        if(isset($this->simpleXml->CODE) === true) {
            
            $this->hasError = true;
            $this->errors[] = $this->simpleXml->CODE->__toString();
            $this->errors[] = $this->simpleXml->DESCRIPTION->__toString();
            $this->errors[] = $this->simpleXml->SOURCE->__toString();
            
        }
        
    }
    
}
