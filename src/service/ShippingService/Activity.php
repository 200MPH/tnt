<?php

/**
 * It's a "sub service" for Shipping.
 * This class generate <ACTIVITY> section and is able to send it to TNT as a 
 * separate request if necessary. 
 *
 * @author Wojciech Brozyna <http://vobro.systems>
 * @license https://github.com/200MPH/tnt/blob/master/LICENCE MIT
 */

namespace thm\tnt_ec\service\ShippingService;

use thm\tnt_ec\MyXMLWriter;
use thm\tnt_ec\service\AbstractService;

class Activity extends AbstractService {
    
    /**
     * @var int
     */
    private $key = 0;
    
    /**
     * @var bool
     */
    private $showGroupCode = false;
    
    /**
     * @var int
     */
    private $groupCode = 0;
    
    /**
     * @var bool
     */
    private $bookingConf = false;
    
    /**
     * @var MyXMLWriter[]
     */
    private $xmls = [];
    
    /**
     * @var string
     */
    private $activityReqStr = '';
    
    /**
     * @var bool
     */
    private $printAll = false;
    
    /**
     * Activity constructor
     * 
     * @var string $userId
     * @var string $passowrd
     * @var int $key
     */
    public function __construct(string $userId, string $password, int $key = 0) {
        
        $this->key = $key;
        parent::__construct($userId, $password);
        
    }
    
    /**
     * Get shipping service URL
     * @return string
     */
    public function getServiceUrl()
    {
        
        return ShippingService::URL;
        
    }

    /**
     * Send request
     * 
     * @return ActivityResponse
     */
    public function send()
    {
                        
        return new ActivityResponse($this->sendRequest(), 
                                    $this->getXmlContent(), 
                                    $this->userId, 
                                    $this->password, 
                                    $this->key);
        
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
     * @param bool $confirmation [optional] Send booking confirmation email to sender.
     * @return Activity
     */
    public function book($consignment, bool $confirmation = false)
    {
        
        $this->sendBookingConfirmationEmail($confirmation);
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
     * Print all possible shipment documents.
     * If this function is called, calls to print*****() methods will be ignored. 
     * 
     * @param array|string $consignment Consignment references or single reference
     * @return Activity
     */
    public function printAll($consignment)
    {
        
        // do not change instruction sequence here!
        $this->xmls['PRINT'] = [];
        $this->buildActivityElement('PRINT', 'REQUIRED', $consignment);
        $this->printAll = true;
        
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
        $xml->openMemory();
        $xml->setIndent(true);
        
        $xml->writeElementCData('EMAILTO', $emailTo);
        $xml->writeElementCData('EMAILFROM', $emailFrom);
        
        $this->xmls['PRINT']['EMAIL'] = $xml;
        
        return $this;
        
    }
    
    /**
     * Add <SHOW_GROUPCODE/> tag.
     * 
     * @param bool $flag [optional] 
     * @return Activity
     */
    public function showGroupCode($flag = true)
    {
        
        $this->showGroupCode = $flag;
        return $this;
        
    }
    
    /**
     * Set group code
     * 
     * @param int $code
     * @return Activity
     */
    public function setGroupCode(int $code)
    {
        
        $this->groupCode = $code;
        return $this;
        
    }
    
    /**
     * Send booking confirmation
     * 
     * @param bool $flag [optional] True default
     * @return Activity
     */
    public function sendBookingConfirmationEmail(bool $flag = true)
    {
        
        $this->bookingConf = $flag;
        
    }
    
    /**
     * Get XML content
     * 
     * @param bool $xmlHeaderIncluded Include XML header (document start). Default TRUE
     * @return string
     */
    public function getXmlContent($xmlHeaderIncluded = true)
    {
        
        // return activity request immediate if set
        if(empty($this->activityReqStr) === false) { return $this->activityReqStr; }
        
        $this->initXml();
        
        if($xmlHeaderIncluded === true) { $this->startDocument(); }
        
        $this->xml->startElement('ACTIVITY');
        $this->mergeActivities('ACTIVITY');
        
        if(isset($this->xmls['PRINT']) === true) {
            
            $this->xml->startElement('PRINT');
            $this->mergeActivities('PRINT');
            $this->xml->endElement();
            
        }
        
        if($this->showGroupCode === true) {
            $this->xml->writeElement('SHOW_GROUPCODE');
        }
        
        $this->xml->endElement();
        if($xmlHeaderIncluded === true) { $this->endDocument(); }
        
        return parent::getXmlContent();
        
    }
    
    /**
     * Get activity results.<br>
     * Useful to check what documents are available for printing.
     *  
     * @return ActivityResponse
     */
    public function getResults()
    {
        
        return $this->callActivityFunction('GET_RESULT');
        
    }
    
    /**
     * Get consignment note
     * 
     * @return ActivityResponse
     */
    public function getConsignmentNote()
    {
        
        return $this->callActivityFunction('GET_CONNOTE');
        
    }
    
    /**
     * Get label
     * 
     * @return ActivityResponse
     */
    public function getLabel()
    {
        
        return $this->callActivityFunction('GET_LABEL');
        
    }
    
    /**
     * Get manifest
     * 
     * @return ActivityResponse
     */
    public function getManifest()
    {
        
        return $this->callActivityFunction('GET_MANIFEST');
                
    }
    
    /**
     * Get invoice
     * 
     * @return ActivityResponse
     */
    public function getInvoice()
    {
        
        return $this->callActivityFunction('GET_INVOICE');
                
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
        
        if($this->printAll === true) { return null; }
        
        $xml = new MyXMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        
        $xml->startElement($element);
                        
        if($element == 'BOOK') {
            
            if($this->bookingConf === true) {
                
                $xml->writeAttribute('EMAILREQD', 'Y');
                
            }
            
            $xml->writeAttribute('ShowBookingRef', 'Y');
            
        }
            
        if($this->groupCode > 0 && $root != 'PRINT') {
            
            $xml->writeElementCData('GROUPCODE', $this->groupCode, false);
            
        } else {
            
            // transform consignment to array
            if(is_array($consignment) === false) {
                
                $consignments[] = $consignment;
                
            } else {
                
                $consignments = $consignment;
                
            }
            
            foreach($consignments as $number) {

                $xml->writeElementCData('CONREF', $number);

            }
            
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
                
                $this->xml->writeRaw($xml->outputMemory(false));
                
            }
        
        }
        
    }
    
    /* 
     * Call activity function
     * 
     * @param string $function [optional] Function name: GET_RESULT (default), GET_CONNOTE, GET_LABEL, GET_MANIFEST, GET_INVOICE
     * @return ActivityResponse
     */
    private function callActivityFunction(string $function = 'GET_RESULT')
    {
        
        $this->activityReqStr = "{$function}:{$this->key}";
        return $this->send();
                
    }
    
}
