<?php

/**
 * Tracking Response
 *
 * @author Wojciech Brozyna <wojciech.brozyna@gmail.com>
 */

namespace thm\tnt_ec\Service\TrackingService\libs;

use thm\tnt_ec\Service\Response;

class TrackingResponse extends Response {
    
    /**
     * @var Consignment[]
     */
    private $consignments = [];
    
    /**
     * Get consignments collection
     * 
     * @return Consignment[]
     */
    public function getConsignments()
    {
        
        if($this->hasError() === false) {
            
            $this->setConsignments();
            
        }
        
        return $this->consignments;
        
    }
    
    /**
     * Set consignments
     * 
     * @return void
     */
    private function setConsignments()
    {
        
        $this->consignments = [];
        
        if(is_array($this->simpleXml->Consignment) === true) {
                
            foreach ($this->simpleXml->Consignment as $cs) {

                $this->consignments[] = new Consignment($cs);

            }

        } else {

            $this->consignments[] = new Consignment($this->simpleXml->Consignment);

        }
        
    }
    
}
