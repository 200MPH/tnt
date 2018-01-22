<?php

/**
 * Shipping Service
 *
 * @author Wojciech Brozyna <wojciech.brozyna@gmail.com>
 * @license https://github.com/200MPH/tnt/blob/master/LICENCE MIT
 */

namespace thm\tnt_ec\service\ShippingService;

use thm\tnt_ec\service\AbstractService;
use thm\tnt_ec\service\ShippingService\entity\Address;
use thm\tnt_ec\service\ShippingService\entity\Collection;
use thm\tnt_ec\service\ShippingService\entity\Consignment;
use thm\tnt_ec\service\ShippingService\ShippingResponse;

class ShippingService extends AbstractService {
    
    /* Version */
    const VERSION = '3.0';
    
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
     * @var Consignment[]
     */
    private $consignments = [];
    
    /**
     * User defined XML content - custom
     * @var bool
     */
    private $userXml = false;
    
    /**
     * @var bool
     */
    private $activity = false;
    
    /**
     * @var string
     */
    private $appid;
    
    /**
     * Initialize service
     * 
     * @param string $userId
     * @param string $password
     * @param string $appid [optional] Default "IN"
     * @throw TNTException
     */
    public function __construct($userId, $password, $appid = 'IN')
    {
        
        parent::__construct($userId, $password);
        $this->appid = $appid;
        
    }
    
    /**
     * Get shipping service URL
     * @return string
     */
    public function getServiceUrl()
    {
    
        return self::URL;
        
    }
    
    /**
     * Set sender address
     * 
     * @return Address
     */
    public function setSender()
    {
        
        if(!$this->sender instanceof Address) {
            
            $this->sender = new Address();
            $this->sender->setAccountNumber($this->account);
            
        }
        
        return $this->sender;
        
    }
    
    /**
     * Set collection.
     *  
     * @return Collection
     */
    public function setCollection()
    {
        
        if(!$this->collection instanceof Collection) {
            
            // initialise object just in case when collection object 
            // is set before $sender object - reverted sequence
            $this->setSender();
            $this->collection = new Collection( $this->sender );
            
        }
        
        return $this->collection;
        
    }
    
    /**
     * Add consignment.
     * TNT allow to add up to 50 consignments, but they recommend add 3 per request. 
     * 
     * @return Consignment
     */
    public function addConsignment()
    {
        
        $con = new Consignment();
        $con->setAccount($this->account, $this->accountCountryCode);
        $this->consignments[] = $con;
        
        return end($this->consignments);
        
    }
    
    /**
     * Create activity - auto activity
     * This will generate <ACTIVITY> element within this request.
     * Following activities will be created: CREATE, BOOK, SHIP, PRINT (consignment, label, manifest).
     * Anything else has to be created manually (RATE, PRINT INVOICE, EMAILTO, EMAILFROM)
     * 
     * @return ShippingService
     */
    public function autoActivity()
    {
        
        $this->activity = true;
        return $this;
        
    }
    
    /**
     * Send request to TNT
     * 
     * @return ShippingResponse
     */
    public function send()
    {
        
        $r = $this->sendRequest();
        $x = $this->getXmlContent();
        $u = $this->userId;
        $p = $this->password;
                
        return new ShippingResponse($r, $x, $u, $p);
        
    }
    
    /**
     * Set XML content.
     * This is useful when you want to send your own prepared XML document.
     * 
     * @param string $xml
     * @return bool
     */
    public function setXmlContent($xml)
    {
        
        $this->userXml = true;
        return parent::setXmlContent($xml);
        
    }
    
    /**
     * Get XML content
     * 
     * @return string
     */
    public function getXmlContent()
    {
        
        if($this->userXml === true) {
            
            // return user defined content without modifications
            return parent::getXmlContent();
            
        }
        
        $this->startDocument();
        
        $this->buildSenderSection();
        $this->buildConsignmentSection();
                
        $this->endDocument();
        
        return parent::getXmlContent();
        
    }
    
    /**
     * Build/start document
     * 
     * @return void
     */
    protected function startDocument()
    {
        
        parent::startDocument();
        
        $this->xml->startElement('ESHIPPER');
        $this->xml->startElement('LOGIN');
            $this->xml->writeElement('COMPANY', $this->userId);
            $this->xml->writeElement('PASSWORD', $this->password);
            $this->xml->writeElement('APPID', $this->appid);
            $this->xml->writeElement('APPVERSION', self::VERSION);
        $this->xml->endElement();
        $this->xml->startElement('CONSIGNMENTBATCH');
        
    }
    
    /**
     * Build/end document
     * 
     * @return void
     */
    protected function endDocument()
    {
        
        $this->xml->endElement();
        $this->buildActivitySection();
        $this->xml->endElement();
        
        parent::endDocument();
        
    }
    
    /**
     * Build sender section
     * 
     * @return void
     */
    private function buildSenderSection()
    {
        
        if($this->sender instanceof Address) {
        
            $this->xml->startElement('SENDER');
                $this->xml->writeRaw( $this->sender->getAsXml() );
                $this->buildCollectionSection();
            $this->xml->endElement();
        
        }
        
    }
    
    /**
     * Build collection section
     * 
     * @return void
     */
    private function buildCollectionSection()
    {
        
        if($this->collection instanceof Collection) {
        
            $this->xml->startElement('COLLECTION');
                $this->xml->writeRaw( $this->collection->getAsXml() );
            $this->xml->endElement();
        
        }
        
    }
    
    /**
     * Build consignment section
     * 
     * @return void
     */
    private function buildConsignmentSection()
    {
        
        if(empty($this->consignments) === false) {
        
            foreach($this->consignments as $consignment) {

                $this->xml->startElement('CONSIGNMENT');
                    $this->xml->writeRaw( $consignment->getAsXml() );
                $this->xml->endElement();

            }
        
        }
        
    }
    
    /**
     * Build activity section
     * 
     * @return void
     */
    private function buildActivitySection()
    {
        
        if($this->activity === true) {
            
            $conRefs = [];
            
            foreach($this->consignments as $consignment) {
                
                $conRefs[] = $consignment->getConReference();
                
            }
            
            $activity = new Activity($this->userId, $this->password);
            $activity->create($conRefs)
                     ->book($conRefs)
                     ->ship($conRefs)
                     ->printConsignmentNote($conRefs)
                     ->printLabel($conRefs)
                     ->printManifest($conRefs);
            
            $this->xml->writeRaw( $activity->getXmlContent(false) );
            
        }
        
    }
    
}
