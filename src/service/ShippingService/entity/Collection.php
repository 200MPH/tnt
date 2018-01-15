<?php

/**
 * Collection
 *
 * @author Wojciech Brozyna <wojciech.brozyna@gmail.com>
 * @license https://github.com/200MPH/tnt/blob/master/LICENCE MIT
 */

namespace thm\tnt_ec\service\ShippingService\entity;

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
     * @param Addres & $senderAddress
     */
    public function __construct(Addres & $senderAddress)
    {
        
        parent::__construct();
        $this->sender = $senderAddress;
        
    }
    
    /**
     * Get ship date.
     *  
     * @return string Date in format DD/MM/YYYY - TNT specified
     */
    public function getShipDate()
    {
        
        /**
         * @todo
         * Add below to the method description:
         * "If not previously set then will return current date if current hour <= 14:00,
         * otherwise next working day."
         * 
         * if(empty($this->shipDate) === true) {
            
            if((int)date('H') < 14 ) {
                
                return date('d/m/Y');
                
            } else {
              
                return date('d/m/Y', strtotime("+{$this->calcDays()} day"));
                
            }
            
        }*/
        
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
     * Set ship date
     * 
     * @param string $shipDate Date in format DD/MM/YYYY - TNT specified
     * @return Collection
     */
    public function setShipDate($shipDate)
    {
        
        $this->shipDate = $shipDate;
        $this->xml->writeElement('SHIPDATE', $shipDate);
        
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
            $this->xml->writeElement('FROM', $timeFrom);
            $this->xml->writeElement('TO', $timeTo);
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
            $this->xml->writeElement('FROM', $timeFrom);
            $this->xml->writeElement('TO', $timeTo);
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
        $this->xml->writeElement('COLLINSTRUCTIONS', $collectInstruction);
        
        return $collectInstruction;
        
    }

    /**
     * Use sender address.
     * Useful when sender and collection address are the same.
     * 
     * @return Collection
     */
    public function useSenderAddress()
    {
        
        $this->collection = $this->sender;
        return $this;
        
    }
    
    /**
     * Calculate remain days to the next working day.
     * If Friday return 3, Sat return 2, Sun return 1
     * 
     * @return int
     */
    private function calcDays()
    {
        
        $weekDay = date('N');
        
        switch($weekDay) {
            
            case 5: // Friday
                return 3;
            case 6: // Saturday
                return 2;
            default:
                return 1;
                
        }  
        
    }
    
}
