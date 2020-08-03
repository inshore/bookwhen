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
        $fromDate = new DateTime($from);
        $toDate = new DateTime($to);
        if(!$this->validDate($from)) {
            return false;
          }
          if(empty($to)) {
            return true;
          }
          if(!$this->validDate($to)) {
            return false;
          }
          // compare if actual to date is greater than from
          if($fromDate < $toDate) {
              return false;
          }
        
    }
    
    public function validTo($from, $to) {
        
    }
    
    public function validTag($tag) {
        return v::stringType()->notEmpty()->alnum()->validate($tag);
    }
    
    public function validToken($token) {
        return v::alnum()->validate($token);
    }
}

// EOF!
