<?php

/**
 * Decorate LevelOfDetails object
 *
 * @author Wojciech Brozyna <wojciech.brozyna@gmail.com>
 */

namespace thm\tnt_ec\service\TrackingService\helpers;

class LevelOfDetailsDecorator {
    
    /**
     * @var LevelOfDetails
     */
    private $lod;
    
    /**
     * Complete attributes
     * 
     * @var array
     */
    private $cAttributes = [];
    
    /**
     * POD
     * 
     * @var bool
     */
    private $pod = false;
    
    /**
     * Construct LevelOfDetails object
     */
    public function __construct(LevelOfDetails & $lod)
    {
        
        $this->lod = $lod;
                
    }
    
    /**
     * Set origin address.
     * This will return origin address in the response.
     * 
     * @return LevelOfDetailsDecorator
     */
    public function setOriginAddress()
    {
        
        $this->cAttributes['originAddress'] = 'true';
        
        $this->decorateXml();
        
        return $this;
        
    }
    
    /**
     * Set destination address.
     * This will return destination address in the response.
     * 
     * @return LevelOfDetailsDecorator
     */
    public function setDestinationAddress()
    {
        
        $this->cAttributes['destinationAddress'] = 'true';
        
        $this->decorateXml();
        
        return $this;
        
    }
    
    /**
     * Set shipment.
     * This will return shipments details in the response.
     * 
     * @return LevelOfDetailsDecorator
     */
    public function setShipment()
    {
        
        $this->cAttributes['shipment'] = 'true';
        
        $this->decorateXml();
        
        return $this;
        
    }
    
    /**
     * Set package.
     * This will return package details in the response.
     * 
     * @return LevelOfDetailsDecorator
     */
    public function setPackage()
    {
        
        $this->cAttributes['package'] = 'true';
        
        $this->decorateXml();
        
        return $this;
        
    }
    
    /**
     * Set POD. 
     * This will return POD file URL in the response.
     * 
     * @return LevelOfDetailsDecorator
     */
    public function setPod()
    {
        
        $this->pod = true;
        
        $this->decorateXml();
        
        return $this;
        
    }
    
    /**
     * Build XML string
     * 
     * @return void
     */
    private function decorateXml()
    {
        
        $xml = "<LevelOfDetail>\n";
        $xml .= ' <Complete ';
        
        foreach($this->cAttributes as $name => $value) {
            
            $xml .= "{$name}=\"$value\" ";
            
        }
        
        $xml .= "/>\n";
        
        if($this->pod === true) {
            
            $xml .= " <POD format=\"URL\"/>\n";
            
        }
        
        $xml .= "</LevelOfDetail>\n";
        
        $this->lod->setXML($xml);
        
    }
    
}
