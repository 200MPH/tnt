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
     * EXCEPTION
     * There is an issue affecting the consignment. 
     * More details in the status descriptions or from calling your local TNT
     * customer services centre. 
     */
    const CODE_EXC = 'EXC';
    
    /**
     * IN TRANSIT
     * The consignment is being processed by TNT 
     */
    const CODE_INT = 'INT';
    
    /**
     * DELIVERED
     * The consignment has been delivered
     */
    const CODE_DEL = 'DEL';
    
    /**
     * CONSIGNMENT NOT FOUND
     * The search request resulted in no results
     */
    const CODE_CNF = 'CNF';
    
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
            
            if(is_array($this->simpleXml->Consignment) === true) {
                
                foreach ($this->simpleXml->Consignment as $cs) {
                    
                    $this->consignments[] = new Consignment($cs);
                    
                }
                
            } else {
                
                $this->consignments[] = new Consignment($this->simpleXml->Consignment);
                
            }
            
        }
        
        return $this->consignments;
        
    }
    
}
