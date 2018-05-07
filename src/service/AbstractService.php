<?php

/**
 * Abstract Service
 *
 * @author Wojciech Brozyna <wojciech.brozyna@gmail.com>
 * @license https://github.com/200MPH/tnt/blob/master/LICENCE MIT
 */

namespace thm\tnt_ec\service;

use thm\tnt_ec\MyXMLWriter;
use thm\tnt_ec\TNTException;

abstract class AbstractService {
    
    /**
     * XML Request
     * 
     * @var XMLWriter
     */
    protected $xml;
    
    /**
     * Account number
     * 
     * @var int
     */
    protected $account = 0;
    
    /**
     * Account country code
     * 
     * @var string
     */
    protected $accountCountryCode = 'GB';
    
    /**
     * Origin (destination) country code
     * 
     * @var string
     */
    protected $originCountryCode = 'GB';
            
    /**
     * User ID
     * 
     * @var string
     */
    protected $userId;
    
    /**
     * Password
     * 
     * @var string
     */
    protected $password;
    
    /**
     * Disable SSL verification
     * 
     * @var bool
     */
    private $verifySSL = true;
    
    /**
     * Get TNT service URL
     * 
     * @var string
     */
    abstract public function getServiceUrl();
    
    /**
     * Initialise service
     * 
     * @param string $userId
     * @param string $password
     * @throw TNTException
     */
    public function __construct($userId, $password)
    {
        
        if(empty($userId) === true) {
            
            throw new TNTException(TNTException::USERNAME_EMPTY);
            
        }
        
        if(empty($password) === true) {
            
            throw new TNTException(TNTException::PASS_EMPTY);
            
        }
        
        $this->userId = $userId;
        $this->password = $password;
        
        $this->xml = new MyXMLWriter();
        $this->xml->openMemory();
        $this->xml->setIndent(true);
                
    }
    
    /**
     * Clean up memory
     */
    public function __destruct()
    {
        
        // clean up output buffer
        $this->xml->flush();
        
    }
    
    /**
     * Set account
     * 
     * @param int $accountNumber
     * @return AbstractService
     */
    public function setAccountNumber($accountNumber)
    {
        
        $this->account = $accountNumber;
        
        return $this;
        
    }
    
    /**
     * Set account country code
     * 
     * @param string $countryCode
     * @return AbstractService
     */
    public function setAccountCountryCode($countryCode)
    {
        
        $this->accountCountryCode = $countryCode;
        return $this;
        
    }
    
    /**
     * Set origin (destination) country code
     * 
     * @param string $countryCode
     * @return AbstractService
     */
    public function setOriginCountryCode($countryCode)
    {
        
        $this->originCountryCode = $countryCode;
        return $this;
        
    }
    
    /**
     * Disable SSL verification
     * 
     * @return AbstractService
     */
    public function disableSSLVerify()
    {
        
        $this->verifySSL = false;
        return $this;
        
    }
    
    /**
     * Build/start document
     * 
     * @return void
     */
    protected function startDocument()
    {
        
        $this->xml->startDocument('1.0', 'UTF-8', 'no');
        
    }
    
    /**
     * Build/end document
     * 
     * @return void
     */
    protected function endDocument()
    {
        
        $this->xml->endDocument();
        
    }
    
    /**
     * Set XML content.
     * This is useful when you want to send your own prepared XML document.
     * 
     * @param string $xml
     * @return bool
     */
    public function setXmlContent($xml)
    {
        
        $this->xml->flush();       
        return $this->xml->writeRaw($xml);
        
    }
    
    /**
     * Get XML content
     * 
     * @return string
     */
    protected function getXmlContent()
    {
        
        return $this->xml->flush(false);
        
    }
    
    /**
     * Send request
     * 
     * @return string Returns TNT Response string as XML
     */
    protected function sendRequest()
    {
        
        $headers[] = "Content-type: application/x-www-form-urlencoded";
        $headers[] = "Authorization: Basic " . base64_encode("$this->userId:$this->password");
        
        $context = stream_context_create(array(
                'http' => array(
                    'header' => $headers,
                    'method' => 'POST',
                    'content' => $this->buildHttpPostData()
                ),
                'ssl' => array(
                     'verify_peer' => $this->verifySSL,
                     'verify_peer_name' => $this->verifySSL)
                )
        );
        
        $output = @file_get_contents($this->getServiceUrl(), false, $context);
        
        // $http_response_header comes from PHP engine, 
        // it's not a part of this code
        // http://php.net/manual/en/reserved.variables.httpresponseheader.php
        HTTPHeaders::$headers = $http_response_header;
                
        return $output;
        
    }
 
    /**
     * Build HTTP Post data
     * 
     * @return string
     */
    private function buildHttpPostData()
    {
        
        $post = http_build_query(array('xml_in' => $this->getXmlContent()));
        return $post;
        
    }
    
}
