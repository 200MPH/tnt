<?php

/**
 * Shipping Service
 *
 * @author Wojciech Brozyna <http://vobro.systems>
 * @license https://github.com/200MPH/tnt/blob/master/LICENCE MIT
 */

namespace thm\tnt_ec\service\ShippingService;

use thm\tnt_ec\service\AbstractService;
use thm\tnt_ec\service\ShippingService\entity\Address;
use thm\tnt_ec\service\ShippingService\entity\Collection;
use thm\tnt_ec\service\ShippingService\entity\Consignment;

class ShippingService extends AbstractService {
    
    /* Version */
    const VERSION = '3.0';
    
    /* Service URL */
    const URL = 'https://express.tnt.com/expressconnect/shipping/ship';
        
    /**
     * @var string
     */
    public $appid;
    
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
     * Group code
     * 
     * @var int
     */
    private $groupCode = 0;
    
    /**
     * @var bool
     */
    private $auto_activity = false;
    
    /**
     * @var Activity
     */
    private $activity;
    
    /**
     * Initialise service
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
     * TNT allow to add up to 50 consignment, but they recommend add 3 per request. 
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
     * Create optional activity elements.
     * Although <ACTIVITY><CREATE> element is mandatory and created automatically for each shipment request,
     * you may want to add other <ACTIVITY> elements.   
     * Calling this method will create following activities: BOOK, SHIP, PRINT (all available documents).
     * Anything else has to be created manually (RATE, EMAILTO, EMAILFROM)
     * 
     * @return ShippingService
     */
    public function createOptionalActivities()
    {
        
        $this->auto_activity = true;
        return $this;
        
    }
    
    /**
     * Set group code
     * 
     * @param int $groupCode
     * @return ShippingService 
     */
    public function setGroupCode(int $groupCode)
    {
        
        $this->groupCode = (int) $groupCode;
        return $this;
        
    }
            
    
    /**
     * Send request to TNT
     * 
     * @return ActivityResponse
     */
    public function send()
    {
        
        $r = $this->sendRequest();
        $x = $this->getXmlContent();
        $u = $this->userId;
        $p = $this->password;
                
        return new ActivityResponse($r, $x, $u, $p);
        
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
        
        $this->initXml();
        $this->startDocument();     
        $this->buildSenderSection();
        $this->buildConsignmentSection();
        $this->endDocument();
        
        return parent::getXmlContent();
        
    }
    
    /**
     * Set Activity object
     * 
     * @param Activity $activity
     * @return ShippingService
     */
    public function setActivity(Activity $activity) 
    {
        
        $this->activity = $activity;
        return $this;
        
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
        
        if($this->groupCode > 0) {
            
            $this->xml->writeElement('GROUPCODE', $this->groupCode);
            
        }
    
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
           
        $this->xml->writeRaw( $this->getActivity()->getXmlContent(false) );
        
    }
    
    /**
     * Get activity
     * 
     * @return Activity
     */
    final private function getActivity()
    {
        
        if($this->activity instanceof Activity) {
            
            return $this->activity;
            
        } 
        
        $conRefs = [];

        foreach($this->consignments as $consignment) {

            $conRefs[] = $consignment->getConReference();

        }
     
        // CREATE activity is mandatory for every request
        $this->activity = new Activity($this->userId, $this->password);
        $this->activity->showGroupCode()
                       ->create($conRefs);
        
        if($this->auto_activity === true) {
        
            $this->activity->book($conRefs)
                           ->ship($conRefs)
                           ->printAll($conRefs);
                     
        }
        
        return $this->activity;
        
    }
    
}
