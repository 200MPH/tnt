<?php

/**
 * Shipping Service
 *
 * @author Wojciech Brozyna <wojciech.brozyna@gmail.com>
 * @license https://github.com/200MPH/tnt/blob/master/LICENCE MIT
 */

namespace thm\tnt_ec\service\ShippingService;

use thm\tnt_ec\Service\AbstractService;
use thm\tnt_ec\service\ShippingService\entity\Address;

class ShippingService extends AbstractService {
    
    /* Version */
    const VERSION = 2.4;
    
    /* Service URL */
    const URL = 'https://express.tnt.com/expressconnect/shipping/ship';
        
    /**
     * @var Address
     */
    private $sender;
    
    /**
     * @var Collection
     */
    private $collection;
    
    /**
     * Get shipping service URL
     * @return string
     */
    public function getServiceUrl()
    {
    
        return self::URL;
        
    }

}
