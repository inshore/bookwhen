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
        return v::date('Ymd')->validate($date);
    }
    
    public function validFrom($from, $to) {
        
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
