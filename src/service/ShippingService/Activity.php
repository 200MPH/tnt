<?php

/**
 * It'a a "sub service" for Shipping.
 * This class generate <ACTIVITY> section and is able to send it to TNT as a 
 * separate request if necessary. 
 *
 * @author Wojciech Brozyna <wojciech.brozyna@gmail.com>
 * @license https://github.com/200MPH/tnt/blob/master/LICENCE MIT
 */

namespace thm\tnt_ec\service\ShippingService;

use thm\tnt_ec\MyXMLWriter;
use thm\tnt_ec\service\AbstractService;

class Activity extends AbstractService {
    
    /**
     * @var MyXMLWriter[]
     */
    private $xmls = [];
    
    /**
     * Get shipping service URL
     * @return string
     */
    public function getServiceUrl()
    {
        
        return ShippingService::URL;
        
    }

    /**
     * Add <CREATE> activity
     * 
     * @param array|string $consignment Consignment references or single reference
     * @return Activity
     */
    public function create($consignment)
    {
        
        $this->buildActivityElement('ACTIVITY', 'CREATE', $consignment);
        
        return $this;
        
    }
    
    /**
     * Add <RATE> activity
     * 
     * @param array|string $consignment Consignment references or single reference
     * @return Activity
     */
    public function rate($consignment)
    {
        
        $this->buildActivityElement('ACTIVITY', 'RATE', $consignment);
        
        return $this;
        
    }
    
    /**
     * Add <BOOK> activity
     * 
     * @param array|string $consignment Consignment references or single reference
     * @return Activity
     */
    public function book($consignment)
    {
        
        $this->buildActivityElement('ACTIVITY', 'BOOK', $consignment);
        
        return $this;
        
    }
    
    /**
     * Add <SHIP> activity
     * 
     * @param array|string $consignment Consignment references or single reference
     * @return Activity
     */
    public function ship($consignment)
    {
        
        $this->buildActivityElement('ACTIVITY', 'SHIP', $consignment);
        
        return $this;
        
    }
    
    /** 
     * Add <PRINT><CONNOTE> activity - print consignment note request
     * 
     * @param array|string $consignment Consignment references or single reference
     * @return Activity
     */
    public function printConsignmentNote($consignment)
    {
                
        $this->buildActivityElement('PRINT', 'CONNOTE', $consignment);
        
        return $this;
        
    }
    
    /** 
     * Add <PRINT><LABEL> activity - print label request
     * 
     * @param array|string $consignment Consignment references or single reference
     * @return Activity
     */
    public function printLabel($consignment)
    {
        
        $this->buildActivityElement('PRINT', 'LABEL', $consignment);
        
        return $this;
        
    }
    
    /** 
     * Add <PRINT><MANIFEST> activity - print manifest request
     * 
     * @param array|string $consignment Consignment references or single reference
     * @return Activity
     */
    public function printManifest($consignment)
    {
        
        $this->buildActivityElement('PRINT', 'MANIFEST', $consignment);
        
        return $this;
        
    }
    
    /** 
     * Add <PRINT><INVOICE> activity - print invoice request
     * 
     * @param array|string $consignment Consignment references or single reference
     * @return Activity
     */
    public function printInvoice($consignment)
    {
        
       $this->buildActivityElement('PRINT', 'INVOICE', $consignment);
        
        return $this;
        
    }
    
    /**
     * Add <PRINT><EMAIL> activity
     * 
     * @param string $emailTo
     * @param string $emailFrom
     * @return Activity
     */
    public function printEmail($emailTo, $emailFrom)
    {
        
        $xml = new MyXMLWriter();
        $xml->writeElementCData('EMAILTO', $emailTo);
        $xml->writeElementCData('EMAILFROM', $emailFrom);
        
        $this->xmls['PRINT']['EMAIL'] = $xml;
        
        return $this;
        
    }
    
    /**
     * Get XML content
     * 
     * @param bool $xmlHeaderIncluded Include XML header (document start). Default TRUE
     * @return string
     */
    public function getXmlContent($xmlHeaderIncluded = true)
    {
        
        if($xmlHeaderIncluded === true) { $this->startDocument(); }
        
        $this->xml->startElement('ACTIVITY');
        $this->mergeActivities('ACTIVITY');
        
        if(isset($this->xmls['PRINT']) === true) {
            
            $this->xml->startElement('PRINT');
            $this->mergeActivities('PRINT');
            $this->xml->endElement();
            
        }
        
        $this->xml->endElement();
        if($xmlHeaderIncluded === true) { $this->endDocument(); }
        
        return parent::getXmlContent();
        
    }
    
    /**
     * Build activity element
     * 
     * @param string $root
     * @param string $element Example: CREATE, RATE, SHIP
     * @param array|string $consignment Consignment references or single reference
     * @return void
     */
    private function buildActivityElement($root, $element, $consignment)
    {
           
        $xml = new MyXMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        
        $xml->startElement($element);
        
        if($element == 'BOOK') {
            
            $xml->writeAttribute('ShowBookingRef', 'Y');
            
        }
        
        if(is_array($consignment) === true) {
            
            foreach($consignment as $number) {
                
                $xml->writeElementCData('CONREF', $number);
                
            }
            
        } else {
            
            $xml->writeElementCData('CONREF', $consignment);
            
        }
        
        $xml->endElement();
        
        $this->xmls[$root][$element] = $xml;
        
    }
    
    /**
     * Merge activity elements
     * 
     * @param string $name
     * @return void
     */
    private function mergeActivities($name)
    {
        
        if(isset($this->xmls[$name]) === true) {
            
            foreach($this->xmls[$name] as $xml) {
                
                $this->xml->writeRaw($xml->outputMemory());
                
            }
        
        }
        
    }
    
}
