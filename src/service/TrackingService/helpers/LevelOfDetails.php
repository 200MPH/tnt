<?php

/**
 * Level Of Details
 *
 * @author Wojciech Brozyna <http://vobro.systems>
 */

namespace thm\tnt_ec\service\TrackingService\helpers;

use thm\tnt_ec\service\TrackingService\TrackingService;

class LevelOfDetails
{
    
    /**
     * @var TrackingService
     */
    private $ts;
    
    /**
     * @var string
     */
    private $xml;
    
    /**
     * Initialize object
     */
    public function __construct(TrackingService $ts)
    {
        
        $this->ts = $ts;
    }
    
    /**
     * Get XML
     *
     * @return string
     */
    public function getXml()
    {
        
        return $this->xml;
    }
    
    /**
     * Set XML
     *
     * @param string $xml
     */
    public function setXML($xml)
    {
        
        $this->xml = $xml;
    }
    
    /**
     * Set summary
     *
     * @return TrackingService
     */
    public function setSummary()
    {
        
        $this->xml = "<LevelOfDetail>\n";
        $this->xml .= " <Summary />\n";
        $this->xml .= "</LevelOfDetail>\n";
        
        return $this->ts;
    }
    
    /**
     * Set complete
     *
     * @return LevelOfDetailsDecorator
     */
    public function setComplete()
    {
        
        /* Create default XML string if not decorate by decorator */
        $this->xml = "<LevelOfDetail>\n";
        $this->xml .= " <Complete />\n";
        $this->xml .= "</LevelOfDetail>\n";
        
        $decorator = new LevelOfDetailsDecorator($this);
        
        return $decorator;
    }
}
