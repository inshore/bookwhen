<?php
namespace InShore\BookWhen\Validator;

use InShore\BookWhen\Interfaces\ValidatorInterface;

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
        
    }

    public function validFrom($from, $to) {
        
    }
    
    public function validTo($from, $to) {
        
    }
    
    public function validToken($token) {
        return true;
    }
}
 
//EOF!
