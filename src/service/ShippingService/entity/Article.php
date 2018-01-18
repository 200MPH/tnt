<?php

/**
 * Article
 *
 * @author Wojciech Brozyna <wojciech.brozyna@gmail.com>
 * @license https://github.com/200MPH/tnt/blob/master/LICENCE MIT
 */

namespace thm\tnt_ec\service\ShippingService\entity;

class Article extends AbstractXml {
    
    /**
     * @var int
     */
    protected $items = 0;
    
    /**
     * @var string
     */
    protected $description;
    
    /**
     * @var float
     */
    protected $weight = 0.00;
    
    /**
     * @var float
     */
    protected $invoiceValue = 0.00;
    
    /**
     * @var string
     */
    protected $invoiceDescription;
    
    /**
     * @var int
     */
    protected $hts = 0;
    
    /**
     * @var string
     */
    protected $country;
    
    /**
     * @var string
     */
    protected $emrn;
    
    /**
     * Set items
     * 
     * @param int $items
     * @return Article
     */    
    public function setItems($items)
    {
        
        $this->items = $items;
        $this->xml->writeElementCData('ITEMS', $items);
        
        return $this;
        
    }

    /**
     * Set description
     * 
     * @param string $description
     * @return Article
     */
    public function setDescription($description)
    {
        
        $this->description = $description;
        $this->xml->writeElementCData('DESCRIPTION', $description);
        
        return $this;
        
    }

    /**
     * Set weight
     * 
     * @param float $weight
     * @return Article
     */
    public function setWeight($weight)
    {
        
        $this->weight = $weight;
        $this->xml->writeElementCData('WEIGHT', $weight);
        
        return $this;
        
    }

    /**
     * Set invoice value
     * 
     * @param float $invoiceValue
     * @return Article
     */
    public function setInvoiceValue($invoiceValue)
    {
        
        $this->invoiceValue = $invoiceValue;
        $this->xml->writeElementCData('INVOICEVALUE', $invoiceValue);
        
        return $this;
        
    }

    /**
     * Set invoice description
     * 
     * @param string $invoiceDescription
     * @return Article
     */
    public function setInvoiceDescription($invoiceDescription)
    {
        
        $this->invoiceDescription = $invoiceDescription;
        $this->xml->writeElementCData('INVOICEDESC', $invoiceDescription);
        
        return $this;
        
    }
    
    /**
     * Set HTS code
     * 
     * @param int $hts
     * @return Article
     */
    public function setHts($hts)
    {
        
        $this->hts = $hts;
        $this->xml->writeElementCData('HTS', $hts);
        
        return $this;
        
    }

    /**
     * Set country code
     * 
     * @param string $country ISO2
     * @return Article
     */
    public function setCountry($country)
    {
        
        $this->country = $country;
        $this->xml->writeElementCData('COUNTRY', $country);
        
        return $this;
        
    }
    
    /**
     * Set EMRN
     * 
     * @param string $emrn
     * @return Aticle
     */
    public function setEmrn($emrn)
    {
        
        $this->emrn = $emrn;
        $this->xml->writeElementCData('EMRN', $emrn);

        return $this;
        
    }
    
}
