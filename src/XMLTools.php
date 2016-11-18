<?php

/**
 * TNT XML Tools
 *
 * @author Wojciech Brozyna <wojciech.brozyna@gmail.com>
 */

namespace thm\tnt_ec;

use DOMDocument;

class XMLTools {
    
    /**
     * Merge XML documents in to one document.
     * 
     * @param array $documents
     * @return string Merged douments as one XML file
     */
    static public function mergeXml(array $documents)
    {
        
        $merged = null;
        
        // always merge firts elements of array with the others
        // therefore we have to subtract one position form array
        // otherwise we will get undefined offest error 
        $counter = count($documents) - 1;
        
        for($i=0; $i < $counter; $i++) {
            
            // skip empty documents
            if(empty($documents[$i]) === true) { continue; }
            
            if($i === 0) {
                
                // add first document to merge array.
                $merged = $documents[$i];
                
            }
            
            // load parent document
            $parent = new DOMDocument();
            $parent->loadXML($merged);
                                   
            // load child document, next in the array
            $child = new DOMDocument();
            $child->loadXml($documents[$i+1]);
            
            foreach ($child->documentElement->childNodes as $node) {
                
                $importedNode = $parent->importNode($node, true);
                
                $parent->documentElement->appendChild($importedNode);
                
                $merged = $parent->saveXML();
                
            }
            
        }
        
        // dont know why, but setting up parent property like below
        // does not remove new line character from document
        // so I used str_replace instead
        // $parent->preserveWhiteSpace = false;
        // $parent->formatOutput = false; 
        return str_replace("\n", '', $merged);
        
    }
    
}
