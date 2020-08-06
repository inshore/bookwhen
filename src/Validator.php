<?php

declare(strict_types = 1);

namespace InShore\BookWhen;

use InShore\BookWhen\Exception;
use InShore\BookWhen\Interfaces\ValidatorInterface;
use Respect\Validation\Validator as v;

class Validator implements ValidatorInterface
{
    
    /**
     * 
     */
    public function __construct() {
        
    }
    
    /**
     * 
     * {@inheritDoc}
     * @see \InShore\BookWhen\Interfaces\ValidatorInterface::validDate()
     */
    public function validDate($date) {
        return v::stringType()->notEmpty()->numericVal()->length(8, 8)->date('Ymd')->validate($date);
    }
    
    /**
     * 
     * {@inheritDoc}
     * @see \InShore\BookWhen\Interfaces\ValidatorInterface::validFrom()
     */
    public function validFrom($from, $to): bool {
        
        $fromDate = new \DateTime($from);
        
        if(!$this->validDate($from)) {
            return false;
        }
        // need this?
        if(empty($to)) {
            return true;
        }
        
        $toDate = new \DateTime($to);
        
        if(!$this->validDate($to)) {
            return false;
        }
        
        // Compare if actual to date is greater than from.
        if($fromDate < $toDate) {
            return (bool) true;
        }
    }
    
    /**
     * 
     * {@inheritDoc}
     * @see \InShore\BookWhen\Interfaces\ValidatorInterface::validTo()
     */
    public function validTo($from, $to): bool {
        
        $toDate = new \DateTime($to);
        
        $todayDate = date('Ymd');
        
        if(!$this->validDate($to)) {
            return false;
        }
        
        if(empty($from)) {
            return true;
        }
        
        $fromDate = new \DateTime($from);
        if(!$this->validFrom($from)) {
            return false;
        }
        if($toDate < $fromDate) {
            return false;
        }
        
        // @todo Do we want this?
//         if($toDate < $todayDate) {
//             return false;
//         }

        return (bool) true;
    }
    
    /**
     * 
     * @param unknown $tag
     * @return unknown
     */
    public function validTag($tag): bool {
        return v::stringType()->notEmpty()->alnum()->validate($tag);
    }
    
    /**
     * 
     * {@inheritDoc}
     * @see \InShore\BookWhen\Interfaces\ValidatorInterface::validToken()
     */
    public function validToken($token) {
        return v::alnum()->validate($token);
    }

    /**
     * 
     * @param unknown $Id
     * @param unknown $type
     * @return boolean|unknown
     */
    public function validId($Id, $type = null): bool {
        
        $exploded = explode('-', $Id);

        if(count($exploded) !== 3) {
            return false;
        }
        
        if($exploded[0] !== 'ev') {
            return false;
        }
        
        // Syntax.
        if(!v::stringType()->notEmpty()->alnum()->length(4, 4)->validate($exploded[1])) {
            return false;
        } 
        
        return (bool) $this->validDate($exploded[2]);
    }
}

// EOF!
