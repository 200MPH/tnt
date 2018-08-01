<?php

/**
 * MyXMLWriter
 * Wrapper for PHP XMLWriter to speed up writing <[CDATA]> elements.
 *
 * @author Wojciech Brozyna <wojciech.brozyna@gmail.com>
 * license https://github.com/200MPH/tnt/blob/master/LICENCE MIT
 */

namespace thm\tnt_ec;

use XMLWriter;

class MyXMLWriter extends XMLWriter {
    
    /**
     * Write element and wrap it in <[CDATA]> tag.
     
     * @param string $name
     * @param string $content
     * @param bool $wrap [optional] Set FALSE to omit <[CDATA]> wrapping - disable
     */
    public function writeElementCData($name, $content = null, $wrap = true) 
    {
        
        if($wrap === false) {
            
           return $this->writeElement($name, $content);
            
        } 
        
        $this->startElement($name);
            $state = $this->writeCdata($content);
        $this->endElement();
                
        return $state;
        
    }
    
}
