<?php

declare(strict_types=1);

namespace InShore\Bookwhen\Exceptions;


/**
 * InshoreBookwhenRestException Class
 * 
 * @package inshore\bookwhen
 */
class RestException extends InshoreBookwhenException
{
    private $e;
    
    public function __construct($e) {
        $this->e = $e;
    }
    
    /**
     *
     * @return string
     */
    public function errorMessage() {
        return $this->e->getMessage();    }
}

//EOF!
