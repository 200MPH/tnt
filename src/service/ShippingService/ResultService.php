<?php

/**
 * Result Request
 *
 * @author Wojciech Brozyna <wojciech.brozyna@gmail.com>
 * @license https://github.com/200MPH/tnt/blob/master/LICENCE MIT
 */

namespace thm\tnt_ec\service\ShippingService;

use thm\tnt_ec\service\AbstractService;

class ResultService extends AbstractService {
    
    /**
     * @var string
     */
    private $request;
    
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
     * Get result
     * 
     * @param int $key
     * @param string $function [optional] Function name: GET_RESULT (default), GET_CONNOTE, GET_LABEL, GET_MANIFEST, GET_INVOICE
     * @return string XML string
     */
    public function getResult($key, $function = 'GET_RESULT')
    {
        
        $this->request = "{$function}:{$key}";
        return $this->sendRequest();
        
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
    
}
