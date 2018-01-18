<?php

/**
 * Tracking Service
 *
 * @author Wojciech Brozyna <wojciech.brozyna@gmail.com>
 * @license https://github.com/200MPH/tnt/blob/master/LICENCE MIT
 */

namespace thm\tnt_ec\service\TrackingService;

use thm\tnt_ec\service\AbstractService;
use thm\tnt_ec\service\TrackingService\helpers\LevelOfDetails;
use thm\tnt_ec\TNTException;
use thm\tnt_ec\XMLTools;

class TrackingService extends AbstractService {
    
    /* Version */
    const VERSION = 3.1;
    
    /* Service URL */
    const URL = 'https://express.tnt.com/expressconnect/track.do';
    
    /* Market types */
    const M_ITL = 'INTERNATIONAL';
    const M_DST = 'DOMESTIC';
    
    /**
     * Search date from
     * 
     * @var string
     */
    private $dateFrom = null;
    
    /**
     * Search date to
     * 
     * @var string
     */
    private $dateTo = null;
    
    /**
     * Number of days to search from days
     * 
     * @var int
     */
    private $days = 0;
    
    /**
     * Market type
     * 
     * @var string
     */
    private $marketType = TrackingService::M_DST;
    
    /**
     * Locale - translate.
     * English US set as default.
     * 
     * @var string
     */
    private $locale = 'en_US';
    
    /**
     * @var LevelOfDetails
     */
    private $lod;
    
    /**
     * Origin output
     * 
     * @var array
     */
    private $outputs;
    
    /**
     * Get TNT service URL
     * 
     * @return string
     */
    public function getServiceUrl() {
        
        return self::URL;
        
    }
    
    /**
     * Search by consignment numbers (TNT reference)
     * 
     * @param array $consignments
     * @return TrackingResponse
     */
    public function searchByConsignment(array $consignments)
    {
        
        $this->xml->flush();
        
        $this->startDocument();
            
            foreach($consignments as $consignment) {

                $this->xml->writeElement('ConsignmentNumber', $consignment);

            }
                
        $this->endDocument();
            
        return new TrackingResponse( $this->sendRequest(), $this->getXmlContent() );
        
    }
    
    /**
     * Search by customer references (your reference)
     * 
     * @param array $references
     * @return TrackingResponse
     */
    public function searchByCustomerReference(array $references)
    {
        
        $this->xml->flush();
        
        $this->startDocument();
            
            foreach($references as $reference) {

                $this->xml->writeElement('CustomerReference', $reference);

            }
                
        $this->endDocument();
            
        return new TrackingResponse( $this->sendRequest(), $this->getXmlContent() );
        
    }

    /**
     * Search by date period
     * 
     * @param string $dateFrom Format: YYYYMMDD
     * @param string $dateTo [optional] Format YYYYMMDD
     * @param int $days [optional] Number of days following $dateFrom. 
     * If $dateTo is set, then $days will be ignored by TNT.
     * 
     * @return TrackingResponse
     */
    public function searchByDate($dateFrom, $dateTo = null, $days = 3)
    {
        
        $this->xml->flush();
        
        $this->dateFrom = $dateFrom;
        $this->dateTo   = $dateTo;
        $this->days     = $days;
        
        $this->startDocument();
            
        $this->setSearchByDateCriteria();
                
        $this->endDocument();
            
        return new TrackingResponse( $this->sendRequest(), $this->getXmlContent() );
        
    }
    
    /**
     * Set market type DOMESTIC
     * 
     * @return TrackingService
     */
    public function setMarketTypeDomestic()
    {
        
        $this->marketType = TrackingService::M_DST;
        return $this;
        
    }

    /**
     * Set market type INTERNATIONAL
     * 
     * @return TrackingService
     */
    public function setMarketTypeInternational()
    {
        
        $this->marketType = TrackingService::M_ITL;
        return $this;
        
    }
    
    /**
     * Set locale - translate attempt.
     * Will attempt to translate status description in to relevant local language.
     * 
     * @param string $countryCode If not specified, English is set to default.
     * @return TrackingService
     */
    public function setLocale($countryCode) 
    {
        
        $this->locale = $countryCode;
        return $this;
        
    }
    
    /**
     * Set level of details returned
     * 
     * @return LevelOfDetails
     */
    public function setLevelOfDetails()
    {
        
        if($this->lod instanceof LevelOfDetails) {
            
            return $this->lod;
            
        } else {
            
            $this->lod = new LevelOfDetails( $this );
            
            return $this->lod;
            
        }
        
    }

    /**
     * Start document
     * 
     * @return void
     */
    protected function startDocument()
    {
        
        parent::startDocument();
        
        $this->xml->startElement("TrackRequest");
        $this->xml->writeAttribute('locale', $this->locale);
        $this->xml->writeAttribute('version', self::VERSION);
        $this->xml->startElement("SearchCriteria");
        $this->setMarketTypeAttributes();
                    
    }
    
    /**
     * End document
     * 
     * @return void
     */
    protected function endDocument()
    {
        
        $this->xml->endElement();
        $this->xml->writeRaw( $this->setLevelOfDetails()->getXml() );
        $this->xml->endElement();
        
        parent::endDocument();
        
    }
    
    /**
     * Send request
     * 
     * @return string Returns TNT Response string as XML
     */
    protected function sendRequest()
    {
        
        $this->setResponse();
        
        return XMLTools::mergeXml($this->outputs);
        
    }
    
    /**
     * Send request.
     * Note, parent method return string, this one an array.
     * 
     * @return array Returns TNT Responses string as XML
     */
    protected function setResponse()
    {
        
        // Tracking service might contain <ContinuationKey> element
        // which works like a pagination
        // We have to loop request until this key exists in the response
        $response = parent::sendRequest();
           
        $this->outputs[] = $response;
        
        if($this->continueRequest($response) === true) {

            $this->setResponse();

        } 
        
    }
    
    /**
     * Set search by account criteria
     * 
     * @return void
     * @throws TNTException
     */
    private function setSearchByDateCriteria()
    {
        
        if(empty($this->dateFrom) === false) {
            
            $this->xml->startElement('Account');
                $this->xml->writeElement('Number', $this->account);
                $this->xml->writeElement('CountryCode', $this->accountCountryCode);
            $this->xml->endElement();
            
            $this->xml->startElement('Period');
                $this->xml->writeElement('DateFrom', $this->dateFrom);
                $this->xml->writeElement('DateTo', $this->dateTo);
                $this->xml->writeElement('NumberOfDays', $this->days);
            $this->xml->endElement();
            
        }
        
    }
    
    /**
     * Set market type attributes for search criteria
     * 
     * @return void
     */
    private function setMarketTypeAttributes()
    {
        
        if(empty($this->marketType) === false) {
            
            $this->xml->writeAttribute('marketType', $this->marketType);
            $this->xml->writeAttribute('originCountry', $this->originCountryCode);
                        
        }
        
    }
 
    /**
     * Continue requesting TNT for more consignment - pagination
     * 
     * @param string $output XML output
     * @return bool True if requesting must be continued, otherwise false.
     */
    private function continueRequest($output)
    {
        
        if(empty($output) === true) {
            
            return false;
            
        }
        
        $xml = new \SimpleXMLElement($output);
            
        if(isset($xml->ContinuationKey) === true) {
                
            $this->xml->writeElement('ContinuationKey', $xml->ContinuationKey);

            return true;
            
        }
        
        return false;
        
    }
    
}
