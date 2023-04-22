<?php

declare(strict_types=1);

namespace InShore\Bookwhen;

use GuzzleHttp;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Psr7\Request;
use InShore\Bookwhen\Exceptions\ConfigurationException;
use InShore\Bookwhen\Exceptions\RestException;
use InShore\Bookwhen\Exceptions\ValidationException;
use InShore\Bookwhen\Interfaces\ClientInterface;
use InShore\Bookwhen\Validator;
use Monolog\Level;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Psr\Http\Message\ResponseInterface;
use InShore\Bookwhen\Resources\Attachments;
use InShore\Bookwhen\Resources\ClassPasses;
use InShore\Bookwhen\Resources\Events;
use InShore\Bookwhen\Resources\Locations;
use InShore\Bookwhen\Resources\Tickets;

/**
 * Class Client
 *
 * The main class for API consumption
 *
 * @package inshore\bookwhen
 * @todo comments
 * @todo externalise config
 * @todo fix token
 */
class Client implements ClientInterface
{
    /**
     * {@inheritDoc}
     * @see \InShore\Bookwhen\Interfaces\ClientInterface::__construct()
     * @todo sanity check the log level passed in an exception if wrong.
     * @todo handle guzzle error
     */
    public function __construct(private $transporter)
    {
    }

    /**
     *
     */
    public function attachments(): Attachments
    {
        return new Attachments($this->transporter);
    }

    /**

     */
    public function classPasses(): ClassPasses
    {
        return new ClassPasses($this->transporter);
    }
/*
 *
 */
    public function events(): Events
    {
        return new Events($this->transporter);
    }
   /**

    */
    public function locations(): Locations
    {
        return new Locations($this->transporter);
    }
/**

 */
    public function tickets(): Tickets
    {
        return new Tickets($this->transporter);
    }
}

// EOF!
