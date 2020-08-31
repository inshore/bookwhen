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
    /** @var \Exception the thrown exception. */
    private $e;
    
    /** @var \Monolog\Logger the thrown exception. */
    private $logger;
    
    /**
     * 
     * @param \Exception $e
     * @param \Monolog\Logger $logger
     */
    public function __construct($e, $logger)
    {
        $this->e = $e;
        $this->logger = $logger;
    }
    
    /**
     *
     * @return string the error messsage.
     */
    public function errorMessage(): string
    {
        $this->logger->error($this->e->getMessage());
        $this->logger->debug(var_export($this->e->getMessage(), true));
        return $this->e->getMessage();
    }
}

//EOF!
