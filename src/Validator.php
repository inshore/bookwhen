<?php

declare(strict_types=1);

namespace InShore\BookWhen;

use InShore\BookWhen\Exception;
use InShore\BookWhen\Interfaces\ValidatorInterface;
use Respect\Validation\Validator as v;

class Validator implements ValidatorInterface
{
    
    /**
     * 
     */
    public function __construct()
    {
        
    }
    
    /**
     * 
     * {@inheritDoc}
     * @see \InShore\BookWhen\Interfaces\ValidatorInterface::validDate()
     */
    public function validDate($date): bool 
    {
        if (v::stringType()->notEmpty()->numericVal()->length(8, 8)->date('Ymd')->validate($date)) {
            return true;
        } else { 
            return v::stringType()->notEmpty()->numericVal()->length(14, 14)->dateTime('Ymdhms')->validate($date);
        }
    }
    
    /**
     * 
     * {@inheritDoc}
     * @see \InShore\BookWhen\Interfaces\ValidatorInterface::validFrom()
     */
    public function validFrom($from, $to = null): bool 
    {
        
        $fromDate = new \DateTime($from);
        
        if (!$this->validDate($from)) {
            return false;
        }
        // need this?
        if(empty($to)) {
            return true;
        }
        
        $toDate = new \DateTime($to);
        
        if (!$this->validDate($to)) {
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
    public function validTo($to, $from = null): bool 
    {
        
        $toDate = new \DateTime($to);
        
        if (!$this->validDate($to)) {
            return false;
        }
        
        if (empty($from)) {
            return true;
        }
        
        $fromDate = new \DateTime($from);
        if (!$this->validFrom($from)) {
            return false;
        }
        if ($toDate < $fromDate) {
            return false;
        }
        
        return (bool) true;
    }
    
    /**
     * 
     * {@inheritDoc}
     * @see \InShore\BookWhen\Interfaces\ValidatorInterface::validTag()
     */
    public function validTag($tag): bool 
    {
        return v::stringType()->notEmpty()->alnum()->validate($tag);
    }
    
    /**
     * 
     * {@inheritDoc}
     * @see \InShore\BookWhen\Interfaces\ValidatorInterface::validToken()
     */
    public function validToken($token): bool
    {
        return v::alnum()->validate($token);
    }

    /**
     * 
     * {@inheritDoc}
     * @see \InShore\BookWhen\Interfaces\ValidatorInterface::validId()
     * @todo
     */
    public function validId($Id, $type = null): bool 
    {
        
        switch ($type) {
            case 'classPass':
                // @todo
            break;
            case 'event':
                $exploded = explode('-', $Id);
                
                if (count($exploded) !== 3) {
                    return false;
                }
                
                if ($exploded[0] !== 'ev') {
                    return false;
                }
                
                // Syntax.
                if (!v::stringType()->notEmpty()->alnum()->length(4, 4)->validate($exploded[1])) {
                    return false;
                }
                
                return $this->validDate($exploded[2]);
                break;
            
            case 'ticket':
                $exploded = explode('-', $Id);
                
                if (count($exploded) !== 3) {
                    return false;
                }
                
                if($exploded[0] !== 'ti') {
                    return false;
                }
                
                // Syntax.
                if (!v::stringType()->notEmpty()->alnum()->length(4, 4)->validate($exploded[1])) {
                    return false;
                }
                
                return $this->validDate($exploded[2]);
                break;
            
            case 'attachment':
            case 'location':
            default:
                // @todo
                break;
        }
    }
}

// EOF!
