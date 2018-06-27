<?php

/**
 * Result Request
 *
 * @author Wojciech Brozyna <wojciech.brozyna@gmail.com>
 * @license https://github.com/200MPH/tnt/blob/master/LICENCE MIT
 */

namespace thm\tnt_ec\service\ShippingService;

use thm\tnt_ec\service\AbstractService;

class ShippingResultService extends AbstractService {
    
    /**
     * @var int
     */
    private $key = 0;
    
    /**
     * @var string
     */
    private $request;

    /**
     * Constructor
     * 
     * @var int $userId
     * @var string $password
     * @var int $key [optional] Response key
     */
    public function __construct($userId, $password, $key = 0) 
    {
        
        $this->key = $key;
        parent::__construct($userId, $password);
        
    }
    
    /**
     * Get service URL
     * 
     * @return string
     */    
    public function getServiceUrl()
    {
        
        return ShippingService::URL;
        
    }

    /**
     * Get consignment note
     * 
     * @return string
     */
    public function getConsignmentNote()
    {
        
        return $this->getResult($this->key, 'GET_CONNOTE');
        
    }
    
    /**
     * Get label
     * 
     * @return string
     */
    public function getLabel()
    {
        
        return $this->getResult($this->key, 'GET_LABEL');
        
    }
    
    /**
     * Get manifest
     * 
     * @return string
     */
    public function getManifest()
    {
        
        return $this->getResult($this->key, 'GET_MANIFEST');
        
    }
    
    /**
     * Get invoice
     * 
     * @return string
     */
    public function getInvoice()
    {
        
        return $this->getResult($this->key, 'GET_INVOICE');
        
    }
        
    /**
     * Get XML content
     * 
     * @return string
     */
    protected function getXmlContent()
    {
                
        return $this->request;
        
    }
    
    /**
     * Get result
     * 
     * @param int $key
     * @param string $function [optional] Function name: GET_RESULT (default), GET_CONNOTE, GET_LABEL, GET_MANIFEST, GET_INVOICE
     * @return string XML string
     */
    private function getResult($key, $function = 'GET_RESULT')
    {
        
        $this->request = "{$function}:{$key}";
        return $this->sendRequest();
        
    }
    
}
