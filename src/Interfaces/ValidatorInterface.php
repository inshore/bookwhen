<?php

namespace InShore\BookWhen\Interfaces;

interface ValidatorInterface
{
    
    /**
     *
     * @param string $token
     */
    public function __construct();
    
    /**
     * 
     */
    public function validToken($token);
    
    /**
     * 
     */
    public function validDate($date);
    
    public function validFrom($from, $to);
    
    public function validTo($from, $to);
    
}

