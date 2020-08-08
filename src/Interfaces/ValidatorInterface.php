<?php

declare(strict_types = 1);

namespace InShore\BookWhen\Interfaces;

interface ValidatorInterface
{
    
    /**
     *
     */
    public function __construct();
        
    /**
     * @param string $date
     */
    public function validDate($date);
    
    /**
     * 
     * @param string $from
     * @param string $to
     */
    public function validFrom($from, $to);
    
    /**
     * @param string $id
     * @param string $type
     */
    public function validId($id, $type);
    /**
     * 
     * @param string $from
     * @param string $to
     */
    public function validTo($from, $to);
    
    /**
     * @param string $token
     */
    public function validToken($token);
    
}

