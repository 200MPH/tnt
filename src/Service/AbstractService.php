<?php

/**
 * Abstract Service
 *
 * @author Wojciech Brozyna <wojciech.brozyna@gmail.com>
 */

namespace thm\tnt_ec\Service;

use XMLWriter;
use thm\tnt_ec\Service\Response;
use thm\tnt_ec\TNTException;

abstract class AbstractService {
    
    /* Version */
    const VERSION = 3.1;
    
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
     * Web service URL
     * 
     * @var string
     */
    private $url = 'https://express.tnt.com/expressconnect/track.do';
    
    /**
     * User ID
     * 
     * @var string
     */
    private $userId;
    
    /**
     * Password
     * 
     * @var string
     */
    private $password;
    
    /**
     * Initialize service
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
        
        $this->xml = new XMLWriter();
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
     * Get XML content
     * 
     * @return string
     */
    protected function getXmlContent()
    {
        
        return $this->xml->outputMemory(false);
        
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
                )
        ));
        
        $output = file_get_contents($this->url, false, $context);
        
        // $http_response_header comes from PHP engine, 
        // it's not a part of this code
        // http://php.net/manual/en/reserved.variables.httpresponseheader.php
        Response::$headers = $http_response_header;
        
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
