<?php

/**
 * Collection
 *
 * @author Wojciech Brozyna <wojciech.brozyna@gmail.com>
 * @license https://github.com/200MPH/tnt/blob/master/LICENCE MIT
 */

namespace thm\tnt_ec\service\ShippingService\entity;

use thm\tnt_ec\MyXMLWriter;

class Collection extends AbstractXml {
    
    /**
     * Sender address.
     * We will use it when collection address is same as sender address.
     * 
     * @var Address
     */
    private $sender;
    
    /**
     * Collection address
     * 
     * @var Address
     */
    private $collection;
    
    /**
     * @var string
     */
    private $shipDate;
    
    /**
     * @var array
     */
    private $prefCollectTime = [];
    
    /**
     * @var array
     */
    private $altCollectTime = [];
    
    /**
     * @var string
     */
    private $collectInstruction;
    
    /**
     * Constructor
     * 
     * @param Address & $senderAddress
     */
    public function __construct(Address & $senderAddress)
    {
        
        parent::__construct();
        $this->sender = $senderAddress;
        
    }
    
    /**
     * Get entire XML as a string
     * 
     * @return string
     */
    public function getAsXml()
    {
        
        // merge addresses into one XML document
        $xml = new MyXMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        
        $xml->startElement('COLLECTIONADDRESS');
        $xml->writeRaw( $this->collection->getAsXml() );
        $xml->endElement();
        
        $xml->writeRaw( parent::getAsXml() );
                
        //re-assign object
        $this->xml = $xml;
        
        return parent::getAsXml();
        
    }
    
    /**
     * Get ship date.
     *  
     * @return string Date in format DD/MM/YYYY - TNT specified
     */
    public function getShipDate()
    {
        
        return $this->shipDate;
        
    }

    /**
     * Get preferred collection time - from
     * 
     * @return string
     */
    public function getPrefCollectTimeFrom()
    {
        
        return $this->prefCollectTime['from'];
        
    }

    /**
     * Get preferred collection time - to
     * 
     * @return string
     */
    public function getPrefCollectTimeTo()
    {
        
        return $this->prefCollectTime['to'];
        
    }
    
    /**
     * Get alternative collection time - from 
     * 
     * @return string
     */
    public function getAltCollectTimeFrom()
    {
        
        return $this->altCollectTime['from'];
        
    }

    /**
     * Get alternative collection time - to
     * 
     * @return string
     */
    public function getAltCollectTimeTo()
    {
        
        return $this->altCollectTime['to'];
        
    }
    
    /**
     * Get collect instructions
     * 
     * @return string
     */
    public function getCollectInstruction()
    {
        
        return $this->collectInstruction;
        
    }

    /**
     * Set collection address
     * 
     * @return Address
     */
    public function setAddress()
    {
        
        $this->collection = new Address();
        return $this->collection;
        
    }
    
    /**
     * Set ship date
     * 
     * @param string $shipDate Date in format DD/MM/YYYY - TNT specified
     * @return Collection
     */
    public function setShipDate($shipDate)
    {
        
        $this->shipDate = $shipDate;
        $this->xml->writeElementCData('SHIPDATE', $shipDate);
        
        return $this;
        
    }

    /**
     * Set preferred collection time
     * 
     * @param string $timeFrom
     * @param string $timeTo
     * @return Collection
     */
    public function setPrefCollectTime($timeFrom, $timeTo)
    {
        
        $this->prefCollectTime['from'] = $timeFrom;
        $this->prefCollectTime['to'] = $timeTo;
        
        $this->xml->startElement('PREFCOLLECTTIME');
            $this->xml->writeElementCData('FROM', $timeFrom);
            $this->xml->writeElementCData('TO', $timeTo);
        $this->xml->endElement();
        
        return $this;
        
    }

    /**
     * Set alternative collection time
     * 
     * @param string $timeFrom
     * @param string $timeTo
     * @return Collection
     */
    public function setAltCollectionTime($timeFrom, $timeTo)
    {
        
        $this->altCollectTime['from'] = $timeFrom;
        $this->altCollectTime['to'] = $timeTo;
        
        $this->xml->startElement('ALTCOLLECTTIME');
            $this->xml->writeElementCData('FROM', $timeFrom);
            $this->xml->writeElementCData('TO', $timeTo);
        $this->xml->endElement();
        
        return $this;
        
    }

    /**
     * Set collection instructions
     * 
     * @param string $collectInstruction
     * @return Collection
     */
    public function setCollectInstruction($collectInstruction)
    {
        
        $this->collectInstruction = $collectInstruction;
        $this->xml->writeElementCData('COLLINSTRUCTIONS', $collectInstruction);
        
        return $this;
        
    }

    /**
     * Use sender address.
     * Use it when sender and collection address are the same.
     * 
     * @return Collection
     */
    public function useSenderAddress()
    {
        
        $auxXml = $this->sender->getAsXml();
        $account = $this->sender->getAccount();
        $delete = "<ACCOUNT><![CDATA[{$account}]]></ACCOUNT>";
        
        $newXml = str_replace($delete, '', $auxXml);
        
        $this->collection = new Address();
        $this->collection->xml->flush();
        $this->collection->xml->writeRaw($newXml);
        
        return $this;
        
    }
    
}
