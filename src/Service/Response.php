<?php

/**
 * Common Response Object
 *
 * @author Wojciech Brozyna <wojciech.brozyna@gmail.com>
 */

namespace thm\tnt_ec\Service;

use SimpleXMLElement;

class Response {
    
    /**
     * Response HTTP headers
     * 
     * @var array
     */
    static public $headers = [];
    
    /**
     * @var SimpleXMLElement
     */
    protected $simpleXml;
    
    /**
     * @var string
     */
    private $responseXml;
    
    /**
     * Request XML
     * 
     * @var string
     */
    private $requestXml;
    
    /**
     * Has error flag
     * 
     * @var bool
     */
    private $hasError = false;
    
    /**
     * Errors
     * 
     * @var array
     */
    private $errors = [];
    
    /**
     * Initialize object
     * 
     * @param string $responseXml
     * @param string $requestXml
     */
    public function __construct($responseXml, $requestXml)
    {
        
        $this->responseXml = $responseXml;
        
        $this->requestXml = $requestXml;
        
        $this->catchErrors();
        
    }
    
    /**
     * Get RAW XML response
     * 
     * @return string
     */
    public function getResponseXml()
    {
        
        return $this->responseXml;
        
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
     * Get response as array
     * 
     * @return array
     */
    public function getResponseAsArray()
    {
        
        /** @todo Finish it */
        return array();
        
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
     * Catch errors
     * 
     * @return void
     */
    private function catchErrors()
    {
        
        $this->catchErrorsFromHttpResponseHeader();
        $this->isXmlValid();
        $this->catchErrorsFromXmlResponse();
                
    }
 
    /**
     * Check response from HTTP response header
     * 
     * @return void
     */
    private function catchErrorsFromHttpResponseHeader()
    {
                
        if(empty(Response::$headers) === false) {
            
            switch(Response::$headers[0]) {
                
                case 'HTTP/1.1 401 Unauthorized':
                    
                    $this->hasError = true;
                    $this->errors[] = "Unauthorized connection! Please check your credentials";
                
            }
            
        }
        
    }
    
    /**
     * Catch errors from XML response
     * 
     * @return void
     */
    private function catchErrorsFromXmlResponse()
    {
        
        if($this->hasError === false) {
            
            if(isset($this->simpleXml->Error) === true) {
                
                $this->hasError = true;
                $this->errors[] = $this->simpleXml->Error->Message->__toString();
                
            }
            
        }
        
    }
    
    /**
     * Check if XML document is valid, if not set errors.
     * This function also create SimpleXMLElement object on success.
     * 
     * @return void
     */
    private function isXmlValid()
    {
        
        $doc = simplexml_load_string($this->responseXml);
        
        if($doc === false) {
            
            $this->hasError = true;
            $this->errors[] = "Response XML document is not valid or empty";
            
        } else {
            
            $this->simpleXml = $doc;
            
        }
        
    }
    
}
