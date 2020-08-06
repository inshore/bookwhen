<?php

declare(strict_types = 1);

namespace InShore\BookWhen;

use InShore\BookWhen\Exception;
use InShore\BookWhen\Interfaces\ValidatorInterface;
use Respect\Validation\Validator as v;

class Validator implements ValidatorInterface
{
    
    public function __construct() {
        
    }
    
    public function validDate($date) {
        return v::stringType()->notEmpty()->numericVal()->length(8, 8)->date('Ymd')->validate($date);
    }
    
    public function validFrom($from, $to) {
        $fromDate = new \DateTime($from);
        $toDate = new \DateTime($to);
        if(!$this->validDate($from)) {
            return false;
        }
        // need this?
        if(empty($to)) {
            return true;
        }
        if(!$this->validDate($to)) {
            return false;
        }
        // compare if actual to date is greater than from
        if($fromDate < $toDate) {
            return true;
        }
        
    }
    
    public function validTo($from, $to) {
        $fromDate = new \DateTime($from);
        $toDate = new \DateTime($to);
        $todayDate = date('Ymd');
        if(!$this->validDate($to)) {
            return false;
        }
        if(empty($from)) {
            return false;
        }
        if(!$this->validFrom($from)) {
            return false;
        }
        if($toDate < $fromDate) {
            return false;
        }

        //do we want this?
        if($toDate < $todayDate) {
            return false;
        }
        
        
    }
    
    public function validTag($tag) {
        return v::stringType()->notEmpty()->alnum()->validate($tag);
    }
    
    public function validToken($token) {
        return v::alnum()->validate($token);
    }

    public function validId($Id, $type = null) {
        $exploded = explode('-', $Id);

        if(count($exploded) !== 3) {
            return false;
        }
        if($exploded[0] !== 'ev') {
            return false;
        }
        //syntax
        if(!v::alnum($exploded[1]) || strlen($exploded[1] !== 4)) {
            return false;
        } 
        return $this->validDate($exploded[2]);
        


// not empty, php explode to break up the id, count the array and make sure theres three parts,
//test first part is ev, second part 4 char alphnanum, third part valid date time
    }
}

// EOF!
