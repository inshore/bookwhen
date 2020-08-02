<?php

declare(strict_types = 1);

namespace InShore\BookWhen;

use GuzzleHttp\Client as GuzzleClient;
use InShore\BookWhen\Exception;
use InShore\BookWhen\ClientInterface;
use InShore\BookWhen\Validator;

/**
 * Class Diffbot
 *
 * The main class for API consumption
 *
 * @package Swader\Diffbot
 */
class Client implements ClientInterface
{
    
    
    /** @var string The API access token */
    private static $token = null;

    /** @var string The instance token, settable once per new instance */
    private $instanceToken;

    private $apiBaseUri;
    
    private $apiResource;
    
    private $apiVersion;
    
    private $Validator;
    
    private $Guzzle;
    
    
    /**
     * @param string|null $token The API access token, as obtained on diffbot.com/dev
     * @throws DiffbotException When no token is provided
     */
    public function __construct($token = null)
    {
        
        $this->apiVersion = 'v2';
        
        $this->Validator = new Validator();
       
        $this->Guzzle = new GuzzleClient(['base_uri' => 'https://api.bookwhen.com']);
        
        if ($token === null) {
            if (self::$token === null) {
                $msg = 'No token provided, and none is globally set. ';
                $msg .= 'Use Diffbot::setToken, or instantiate the Diffbot class with a $token parameter.';
                throw new Exception($msg);
            }
        } else {
            $this->validator->validToken($token);
            self::$token = $token;
        }
    }

    /**
     * 
     */
    protected function request() {
        try {
            return $this->Guzzle->request('GET', $this->apiResource , [
                'auth' => [$this->instanceToken],
            ]);
        } catch (Exception $e) {
            // @todo;
        }
    }
    
    /**
     * @todo
     */
    public function getAttachment($attachmentId) {
        
    }

    /**
     * 
     * {@inheritDoc}
     * @see \InShore\BookWhen\Interfaces\ClientInterface::getAttachments()
     */
    public function getAttachments() {
        $this->apiResource = $this->apiVersion . '/attachments';
        
        // @todo prepocess response onto nice model objects.
        return $this->request();
    }
    
    /**
     * 
     * {@inheritDoc}
     * @see \InShore\BookWhen\Interfaces\ClientInterface::getClassPass()
     */
    public function getClassPass($classPassId) {
        
    }
    
    /**
     * 
     * {@inheritDoc}
     * @see \InShore\BookWhen\Interfaces\ClientInterface::getClassPasses()
     */
    public function getClassPasses() {
        $this->apiResource = $this->apiVersion . '/???';
        
        // @todo prepocess response onto nice model objects.
        return $this->request();
    }
    
    /**
     * 
     * {@inheritDoc}
     * @see \InShore\BookWhen\Interfaces\ClientInterface::getEvent()
     */
    public function getEvent($eventId) {
        
        $return = null;
        // validate
      
        try {
            $return = $this->request();
        } catch (Exception $e) {
            // @todo
        }
        
        return $return;
    }
    
    /**
     * 
     * {@inheritDoc}
     * @see \InShore\BookWhen\Interfaces\ClientInterface::getEvents()
     */
    public function getEvents($from = null, $to = null, $includeLocation = false, $includeTickets = false) {
        $this->apiResource = $this->apiVersion . '/events';
        
        // @todo prepocess response onto nice model objects.
        $return = null;
        // validate
        
        try {
            $return = $this->request();
        } catch (Exception $e) {
            // @todo
        }
        
        return $return;
    }
    
    /**
     * 
     * {@inheritDoc}
     * @see \InShore\BookWhen\Interfaces\ClientInterface::getLocation()
     */
    public function getLocation($locationId) {
        
    }
    
    /**
     * 
     * {@inheritDoc}
     * @see \InShore\BookWhen\Interfaces\ClientInterface::getLocations()
     */
    public function getLocations() {
        $client = new GuzzleHttp\Client(['base_uri' => 'https://api.bookwhen.com']);
        $response = $client->request('GET', "/v2/locations/$locationId", [
            'auth' => ['username', 'password'],
        ]);
    } 
    
    /**
     * 
     * {@inheritDoc}
     * @see \InShore\BookWhen\Interfaces\ClientInterface::getTicket()
     */
    public function getTicket($ticketId) {
        
    }
    
    /**
     * 
     * {@inheritDoc}
     * @see \InShore\BookWhen\Interfaces\ClientInterface::getTickets()
     */
    public function getTickets() {
        
    }
    
    /**
     * Sets the token for all future new instances
     * @param $token string The API access token, as obtained on diffbot.com/dev
     * @return void
     */
    public static function setToken($token)
    {
        self::validateToken($token);
        self::$token = $token;
    }

    private static function validateToken($token)
    {
        if (!is_string($token)) {
            throw new \InvalidArgumentException('Token is not a string.');
        }
        if (strlen($token) < 4) {
            throw new \InvalidArgumentException('Token "' . $token . '" is too short, and thus invalid.');
        }
        return true;
    }
    
}

// EOF!
