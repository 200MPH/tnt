<?php

/**
 * TNTException
 *
 * @author Wojciech Brozyna <wojciech.brozyna@gmail.com>
 * @license https://github.com/200MPH/tnt/blob/master/LICENCE MIT
 */

namespace thm\tnt_ec;

use Exception;

class TNTException extends Exception {
    
    /* Username is empty */
    const USERNAME_EMPTY = 'Username cannot be empty when creating service object';
    
    /* Password is empty */
    const PASS_EMPTY = 'Password cannot be empty when creating service object';
    
    /* Attempt to search by multiple types */
    const SEARCH_MULTI_TYPES = 'You cannot search by account and reference number at the same time';
    
}
