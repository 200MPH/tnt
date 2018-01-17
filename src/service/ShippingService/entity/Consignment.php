<?php

/**
 * Consignment
 *
 * @author Wojciech Brozyna <wojciech.brozyna@gmail.com>
 * @license https://github.com/200MPH/tnt/blob/master/LICENCE MIT
 */

namespace thm\tnt_ec\service\ShippingService\entity;

class Consignment extends AbstractXml {
    
    /**
     * @var string
     */
    private $conReference;
    
    /**
     * Receiver address
     * 
     * @var Address
     */
    private $receiver;
    
    /**
     * Delivery address
     * 
     * @var Address
     */
    private $delivery;
    
    /**
     * @var string
     */
    private $customerRef;
    
    /**
     * Consignment type.
     * "D" for document, "N" for non document package.
     * 
     * @var string
     */
    private $contype = 'N';
    
    /**
     * S - sender, R - receiver
     * 
     * @var string
     */
    private $paymentind = 'S';
    
    /**
     * @var int
     */
    private $items = 0;
    
    /**
     * @var float 
     */
    private $totalWeight = 0.00;
    
    /**
     * @var float
     */
    private $totalVolume = 0.00;
    
    /**
     * @var string
     */
    private $currency = 'GBP';
    
    /**
     * @var float
     */
    private $goodsValue = 0.00;
    
    /**
     * @var float
     */
    private $insuranceValue = 0.00;
    
    /**
     * @var string
     */
    private $insuranceCurrency = 'GBP';
    
    /**
     * @var string
     */
    private $service;
    
    /**
     * @var string
     */
    private $option;
    
    /**
     * @var string
     */
    private $description;
    
    /**
     * @var string
     */
    private $deliveryInstructions;
    
    /**
     * @var Package[]
     */
    private $packages = [];
    
    /**
     * Service options
     * @var array
     */
    private $serviceOptions = [];
    
    /**
     * @var array
     */
    private $account = [];
    
    /**
     * Set account
     * 
     * @param int $accountNumber
     * @param string $accountCountry ISO2 country code
     * 
     * @return void
     */
    public function setAccount($accountNumber, $accountCountry)
    {
        
        $this->account['number'] = $accountNumber;
        $this->account['country'] = $accountCountry;
        
    }
    
    /**
     * Get entire XML as a string
     * 
     * @return string
     */
    public function getAsXml()
    {
        
        if(empty($this->packages) === true) {
         
            return parent::getAsXml();
            
        }
            
        $xml = new \XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);

        $xml->writeElement('CONREF', $this->conReference);
        $xml->startElement('DETAILS');

            // merge addresses into new document
            $this->mergeReceiverAddress($xml);
            $this->mergeDeliveryAddress($xml);
        
            // copy this XML into new document
            $xml->writeRaw( parent::getAsXml() );

            // merge packages into new document
            $this->mergePackages($xml);

        $this->xml->endElement();

        // re-assigne variable
        $this->xml = $xml;
        
        return $xml->outputMemory(false);
        
    }
    
    /**
     * Add package.
     * TNT allows for maximum 50 packages per consignment.
     * 
     * @return Package
     */
    public function addPackage()
    {
        
        $this->packages[] = new Package();
        
        return end($this->packages);
        
    }
    
    /**
     * Add service option
     * 
     * @param string $option
     * @return Consignment
     */
    public function addOption($option)
    {
        
        if(count($this->serviceOptions) < 5) {
            
            $this->serviceOptions[] = $option;
            $this->xml->writeElement('OPTION', $option);
            
        }
        
        return $this;
        
    }
    
    /**
     * Mark as hazardous
     * 
     * @param string $unNumber [optional] Required for UK domestic
     * @return Consignment
     */
    public function hazardous($unNumber = '0000')
    {
        
        $this->xml->writeElement('HAZARDOUS', 'Y');
        $this->xml->writeElement('UNNUMBER', $unNumber);
        $this->xml->writeElement('PACKINGGROUP', 'II');
        
        return $this;
        
    }
 
    /**
     * Set consignment reference
     * 
     * @param string $conReference
     * @return Consignment
     */
    public function setConReference($conReference)
    {
        
        // NOTE that I'm not adding <CONREF> element here
        // because it must be separate (see TNT documentation)
        // <CONREF> is added in getAsXml() instead 
        
        $this->conReference = $conReference;        
        return $this;
        
    }

    /**
     * Set receiver address - NOT DELIVERY ADDRESS
     * 
     * @return Address
     */
    public function setReceiver()
    {
        
        if(!$this->receiver instanceof Address) {
            
            $this->receiver = new Address();
            
        }

        return $this->receiver;
        
    }
    
    /**
     * Set receiver address as delivery address.
     *  
     * @return Consignment
     */
    public function setReceiverAsDelivery()
    {
             
        $this->delivery =& $this->receiver;
        
        return $this;
        
    }
    
    /**
     * Set delivery address
     * 
     * @return Address
     */
    public function setDelivery()
    {
        
        if(!$this->delivery instanceof Address) {
            
            $this->delivery = new Address();
            
        }
        
        return $this->delivery;
        
    }

    /**
     * Set customer reference
     * 
     * @param string $customerRef
     * @return Consignment
     */
    public function setCustomerRef($customerRef)
    {
        
        $this->customerRef = $customerRef;
        $this->xml->writeElement('CUSTOMERREF', $customerRef);
        
        return $this;
        
    }

    /**
     * Set consignment type.
     * "N" for non document parcel, "D" for document
     * 
     * @param string $contype [optional] "N" default
     * @return Consignment
     */
    public function setContype($contype = 'N')
    {
        
        $this->contype = $contype;
        $this->xml->writeElement('CONTYPE', $contype);
        
        return $this;
        
    }

    /**
     * Set payment who pay
     * "S" sender pays, "R" receiver pays
     * 
     * @param string $paymentind [optional] "S" default
     * @return Consignment
     */
    public function setPaymentind($paymentind = 'S')
    {
        
        $this->paymentind = $paymentind;
        $this->xml->writeElement('PAYMENTIND', $paymentind);
     
        if($this->paymentind === 'R') {
            
            $this->receiver->setAccountNumber($this->account['number']);
            $this->receiver->setAcountCountry($this->account['country']);
            
        }
        
        return $this;
        
    }

    /**
     * Set items - parcels total
     * 
     * @param int $items
     * @return Consignment
     */
    public function setItems($items)
    {
        
        $this->items = $items;
        $this->xml->writeElement('ITEMS', $items);
        
        return $this;
        
    }

    /**
     * Set total weight
     * 
     * @param float $totalWeight
     * @return Consignment
     */
    public function setTotalWeight($totalWeight)
    {
        
        $this->totalWeight = $totalWeight;
        $this->xml->writeElement('TOTALWEIGHT', $totalWeight);
        
        return $this;
        
    }

    /**
     * Set total volume
     * 
     * @param float $totalVolume
     * @return Consignment
     */
    public function setTotalVolume($totalVolume)
    {
        
        $this->totalVolume = $totalVolume;
        $this->xml->writeElement('TOTALVOLUME', $totalVolume);
        
        return $this;
        
    }

    /**
     * Set currency
     * 
     * @param string $currency
     * @return Consignment
     */
    public function setCurrency($currency)
    {
        
        $this->currency = $currency;
        $this->xml->writeElement('CURRENCY', $currency);
        
        return $this;
        
    }

    /**
     * Set goods value
     * 
     * @param float $goodsValue
     * @return Consignment
     */
    public function setGoodsValue($goodsValue)
    {
        
        $this->goodsValue = $goodsValue;
        $this->xml->writeElement('GOODSVALUE', $goodsValue);
        
        return $this;
        
    }

    /**
     * Set insurance value
     * 
     * @param float $insuranceValue
     * @return Consignment
     */
    public function setInsuranceValue($insuranceValue)
    {
        
        $this->insuranceValue = $insuranceValue;
        $this->xml->writeElement('INSURANCEVALUE', $insuranceValue);
        
        return $this;
        
    }

    /**
     * Set insurance currency
     * 
     * @param string $insuranceCurrency
     * @return Consignment
     */
    public function setInsuranceCurrency($insuranceCurrency)
    {
        
        $this->insuranceCurrency = $insuranceCurrency;
        $this->xml->writeElement('INSURANCECURRENCY', $insuranceCurrency);
        
        return $this;
        
    }

    /**
     * Set service
     * 
     * @param string $service
     * @return Consignment
     */
    public function setService($service)
    {
        
        $this->service = $service;
        $this->xml->writeElement('SERVICE', $service);
        
        return $this;
        
    }

    /**
     * Set description
     * 
     * @param string $description
     * @return Consignment
     */
    public function setDescription($description)
    {
        
        $this->description = $description;
        $this->xml->writeElement('DESCRIPTION', $description);
        
        return $this;
        
    }

    /**
     * Set delivery instructions
     * 
     * @param string $deliveryInstructions
     * @return Consignment
     */
    public function setDeliveryInstructions($deliveryInstructions)
    {
                
        $this->deliveryInstructions = $deliveryInstructions;
        $this->xml->writeElement('DELIVERYINST', $deliveryInstructions);
        
        return $this;
        
    }
    
    /**
     * Get consignment reference
     * 
     * @return string
     */
    public function getConReference()
    {
        
        return $this->conReference;
        
    }
    
    /**
     * Merge receiver address into this document
     * 
     * @param XMLWriter &$xml
     * @return void
     */
    private function mergeReceiverAddress(\XMLWriter & $xml)
    {
        
        $this->setReceiver(); // initialise in case when not set by user - avoid errors
        $xml->startElement('RECEIVER');
        $xml->writeRaw( $this->receiver->getAsXml() );
        $xml->endElement();
        
    }
    
    /**
     * Merge delivery address into this document
     * 
     * @param \XMLWriter &$xml
     * @return void
     */
    private function mergeDeliveryAddress(\XMLWriter & $xml)
    {
        
        $this->setReceiver(); // initialise in case when not set by user - avoid errors
        $xml->startElement('DELIVERY');
        $xml->writeRaw( $this->delivery->getAsXml() );
        $xml->endElement();
        
    }
    
    /**
     * Merge packages into this document
     * 
     * @param \XMLWriter &$xml
     * @return void
     */
    private function mergePackages(\XMLWriter & $xml)
    {
        
        foreach($this->packages as $package) {
                
            $xml->startElement('PACKAGE');
                $xml->writeRaw( $package->getAsXml() );
            $xml->endElement();

        }
        
    }
    
}
