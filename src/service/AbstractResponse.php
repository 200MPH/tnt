<?php

/**
 * Common Response Object
 *
 * @author Wojciech Brozyna <wojciech.brozyna@gmail.com>
 * @license https://github.com/200MPH/tnt/blob/master/LICENCE MIT
 */

namespace thm\tnt_ec\service;

use SimpleXMLElement;

abstract class AbstractResponse {
    
    /**
     * @var SimpleXMLElement
     */
    protected $simpleXml;
    
    /**
     * Has error flag
     * 
     * @var bool
     */
    protected $hasError = false;
    
    /**
     * Errors
     * 
     * @var array
     */
    protected $errors = [];
    
    /**
     * @var string
     */
    protected $response;
    
    /**
     * Request XML
     * 
     * @var string
     */
    private $requestXml;
    
    /**
     * Catch concrete response error
     * Useful when error handling has to be customized for specific response type.
     * 
     * @return void
     */
    abstract protected function catchConcreteResponseError();
    
    /**
     * Initialize object
     * 
     * @param string $response
     * @param string $requestXml
     */
    public function __construct($response, $requestXml)
    {
        
        $this->response = $response;     
        $this->requestXml = $requestXml;
        $this->catchErrors();
        
    }
    
    /**
     * Get RAW response
     * 
     * @return string
     */
    public function getResponse()
    {
        
        return $this->response;
        
    }
    
    /**
     * Get request XML
     * 
     * @return string
     */
    public function getRequestXml()
    {
        
        return $this->requestXml;
        
    }
    
    /**
     * Has error
     * 
     * @return bool
     */
    public function hasError()
    {
        
        return $this->hasError;
        
    }

    /**
     * Get errors
     * 
     * @return array
     */
    public function getErrors()
    {
        
        return $this->errors;
        
    }
    
    /**
     * Check if XML document is valid, if not set errors.
     * This function also create SimpleXMLElement object on success.
     * 
     * @return void
     */
    protected function validateXml()
    {
        
        $doc = simplexml_load_string($this->response);
        
        if($doc === false) {
            
            $this->hasError = true;
            $this->errors[] = "Response XML document is not valid or empty";
                        
        } else {
            
            $this->simpleXml = $doc;
                        
        }
        
    }
    
    /**
     * Catch errors
     * 
     * @return void
     */
    private function catchErrors()
    {
        
        $this->catchErrorsFromHttpResponseHeader();
        
        if($this->hasError() === false) {
            
            $this->catchConcreteResponseError();
            
        }
                
    }
    
    /**
     * Check response from HTTP response header
     * 
     * @return void
     */
    private function catchErrorsFromHttpResponseHeader()
    {
             
        if(empty(HTTPHeaders::$headers) === false) {
            
            switch(HTTPHeaders::$headers[0]) {
                
                case 'HTTP/1.1 401 Unauthorized':
                    
                    $this->hasError = true;
                    $this->errors[] = "Unauthorized connection! Please check your credentials";
                    break;
                
                case 'HTTP/1.1 500':
                    
                    $this->hasError = true;
                    $this->errors[] = "Internal server error";
                    break;
                
            }
            
        }
        
    }
    
}
