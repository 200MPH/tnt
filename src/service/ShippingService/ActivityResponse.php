<?php

/**
 * Activity Response
 *
 * @author Wojciech Brozyna <http://vobro.systems>
 * @license https://github.com/200MPH/tnt/blob/master/LICENCE MIT
 */

namespace thm\tnt_ec\service\ShippingService;

class ActivityResponse extends AbstractShippingResponse {    
    
    /**
     * Catch errors
     */
    protected function catchConcreteResponseError(): void {
        
        $this->catchErrors();
        
    }

}