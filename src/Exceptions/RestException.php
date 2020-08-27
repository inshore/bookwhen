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
    
    private $logger;
    
    public function __construct($e, $logger)
    {
        $this->e = $e;
        $this->logger = $logger;
    }
    
    /**
     *
     * @return string
     */
    public function errorMessage()
    {
        $this->logger->error($this->e->getMessage());
        $this->logger->debug(var_export($this->e->getMessage(), true));
        return $this->e->getMessage();
    }
}

//EOF!
