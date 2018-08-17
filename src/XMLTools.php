<?php

/**
 * TNT Express Connect - XML Tools
 *
 * @author Wojciech Brozyna <http://vobro.systems>
 * @license https://github.com/200MPH/tnt/blob/master/LICENCE MIT
 */

namespace thm\tnt_ec;

use DOMDocument;

class XMLTools {
    
    /**
     * Merge XML documents in to one document.
     * 
     * @param array $docs
     * @return string Merged documents as one XML file
     */
    static public function mergeXml(array $docs)
    {
        
        $merged = '';
        
        // remove empty elements
        foreach($docs as $key => $document) {
            
            if(empty($document) === true) {
            
                unset($docs[$key]);
                
            }  
            
        }
        
        // re-index array
        $documents = array_values($docs);
        
        // if only one element in array then return without merging
        if(count($documents) === 1) { return $documents[0]; }
        
        // always merge first elements of array with the others
        // therefore we have to subtract one position from array
        // otherwise we will get undefined offset error 
        $counter = count($documents) - 1;
        
        for($i=0; $i < $counter; $i++) {
                        
            if($i === 0) {
                
                // add first document to the merge string.
                $merged = $documents[$i];
                
            }
            
            // load parent document
            $parent = new DOMDocument();
            $parent->loadXML($merged);
                                   
            // load child document, next element in the array
            $child = new DOMDocument();
            $child->loadXml($documents[$i+1]);
            
            foreach ($child->documentElement->childNodes as $node) {
                
                $importedNode = $parent->importNode($node, true);
                $parent->documentElement->appendChild($importedNode);
                
            }
            
            $merged = $parent->saveXML();
            
        }
        
        // I dont know why, but setting up parent property like below
        // does not remove new line character from document
        // so I used str_replace instead
        // $parent->preserveWhiteSpace = false;
        // $parent->formatOutput = false; 
        return str_replace("\n", '', $merged);
        
    }
    
}
