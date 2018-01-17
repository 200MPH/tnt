<?php

/**
 * Tracking Response
 *
 * @author Wojciech Brozyna <wojciech.brozyna@gmail.com>
 * @license https://github.com/200MPH/tnt/blob/master/LICENCE MIT
 */

namespace thm\tnt_ec\service\TrackingService;

use thm\tnt_ec\service\AbstractResponse;
use thm\tnt_ec\service\TrackingService\entity\Consignment;

class TrackingResponse extends AbstractResponse {
    
    /**
     * @var Consignment[]
     */
    private $consignments = [];
    
    /**
     * Get consignment collection
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
     * Catch errors for this response
     * 
     * @return void
     */
    protected function catchConcreteResponseError()
    {
        
        $this->validateXml();
        $this->catchErrorsFromXmlResponse();
        
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
    
}
