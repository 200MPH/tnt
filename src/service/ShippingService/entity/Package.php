<?php

/**
 * Package
 *
 * @author Wojciech Brozyna <wojciech.brozyna@gmail.com>
 * @license https://github.com/200MPH/tnt/blob/master/LICENCE MIT
 */

namespace thm\tnt_ec\service\ShippingService\entity;

use thm\tnt_ec\MyXMLWriter;

class Package extends AbstractXml {
    
    /**
     * @var int
     */
    private $items = 0;
    
    /**
     * @var string
     */
    private $description;
    
    /**
     * @var float
     */
    private $length = 0.00;
    
    /**
     * @var float
     */
    private $height = 0.00;
    
    /**
     * @var float
     */
    protected $width = 0.00;
    
    /**
     * @var float
     */
    protected $weight = 0.00;
    
    /**
     * @var Article[]
     */
    private $articles = [];
    
    /**
     * Get entire XML as a string
     * 
     * @return string
     */
    public function getAsXml()
    {
        
        if(empty($this->articles) === true) {
         
            return parent::getAsXml();
            
        }
            
        $parentXml = parent::getAsXml();
        
        $this->xml->flush();
        $this->xml->writeRaw( $parentXml );

        foreach($this->articles as $article) {

            $this->xml->startElement('ARTICLE');
                $this->xml->writeRaw( $article->getAsXml() );
            $this->xml->endElement();

        }
        
        return $this->xml->outputMemory(false);
        
    }
    
    /**
     * Add article.
     * Optional. This is required for customs only.
     * 
     * @return Article
     */
    public function addArticle()
    {
        
        $this->articles[] = new Article();
        
        return end($this->articles);
        
    }
    
    /**
     * Set items QTY
     * 
     * @param int $items
     * @return Package
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
     * @return Package
     */
    public function setDescription($description)
    {
        
        $this->description = $description;
        $this->xml->writeElementCData('DESCRIPTION', $description);
        
        return $this;
        
    }

    /**
     * Set length
     * 
     * @param float $length Meters unit
     * @return Package
     */
    public function setLength($length)
    {
        
        $this->length = $length;
        $this->xml->writeElementCData('LENGTH', $length);
        
        return $this;
        
    }

    /**
     * Set height
     * 
     * @param float $height Meters unit
     * @return Package
     */
    public function setHeight($height)
    {
        
        $this->height = $height;
        $this->xml->writeElementCData('HEIGHT', $height);
        
        return $this;
        
    }

    /**
     * Set 
     * 
     * @param float $width Meters unit
     * @return Package
     */
    public function setWidth($width)
    {
        
        $this->width = $width;
        $this->xml->writeElementCData('WIDTH', $width);
        
        return $this;
        
    }

    /**
     * Set weight
     * 
     * @param float $weight Kilos unit
     */
    public function setWeight($weight)
    {
        
        $this->weight = $weight;
        $this->xml->writeElementCData('WEIGHT', $weight);
        
        return $this;
        
    }

}
