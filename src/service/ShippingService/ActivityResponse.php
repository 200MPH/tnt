<?php

/**
 * Shipping Response
 *
 * @author Wojciech Brozyna <http://vobro.systems>
 * @license https://github.com/200MPH/tnt/blob/master/LICENCE MIT
 */

namespace thm\tnt_ec\service\ShippingService;
    
class ActivityResponse extends AbstractShippingResponse {    
    
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
     * @param int $key [optional]
     */
    public function __construct(string $response, 
                                string $requestXml, 
                                string $userId, 
                                string $password, 
                                int $key = 0)
    {
        
        $this->userId = $userId;
        $this->password = $password;
        $this->key = $key;
               
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
     * @return Activity
     */
    public function getActivity()
    {
        
        $activity = new Activity($this->userId, $this->password, $this->key);
        return $activity;
        
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
            
            $this->catchErrors();
            
        }
        
    }
        
}
