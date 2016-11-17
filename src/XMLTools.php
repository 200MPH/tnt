<?php

/**
 * TNT XML Tools
 *
 * @author Wojciech Brozyna <wojciech.brozyna@gmail.com>
 */

namespace thm\tnt_ec;

class XMLTools {
    
    /**
     * Merge XML documents in to one document.
     * 
     * @param array $documents
     * @return string Merged douments as one XML file
     */
    static public function mergeXml(array $documents)
    {
        
        foreach($documents as $document) {
            
            // skip empty documents
            if(empty($document) === true) {
                
                continue;
                
            }
            
            
            
        }
        
    }
    
}
