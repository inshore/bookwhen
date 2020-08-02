<?php
declare(strict_types = 1);

namespace InShore\BookWhen;

require 'vendor/autoload.php';

use GuzzleHttp\Client;
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

    private $baseUri;
    
    private $Validator;
    
    private $Client;
    
    
    /**
     * @param string|null $token The API access token, as obtained on diffbot.com/dev
     * @throws DiffbotException When no token is provided
     */
    public function __construct($token = null)
    {
        
        $this->Validator = new Validator();
       
        $this->Client = new Client(['base_uri' => 'https://api.bookwhen.com']);
        
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

    protected function reqauest() {
        
    }
    
    /**
     * @todo
     */
    public function getAttachment() {
        
    }

    /**
     * 
     * {@inheritDoc}
     * @see \InShore\BookWhen\Interfaces\ClientInterface::getAttachments()
     */
    public function getAttachments() {
        
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
        
    }
    
    /**
     * 
     * {@inheritDoc}
     * @see \InShore\BookWhen\Interfaces\ClientInterface::getEvent()
     */
    public function getEvent($eventId) {
        $client = new GuzzleHttp\Client(['base_uri' => 'https://api.bookwhen.com']);
        $response = $client->request('GET', "/v2/events/$eventId", [
            'auth' => ['username', 'password'],
        ]);
    }
    
    /**
     * 
     * {@inheritDoc}
     * @see \InShore\BookWhen\Interfaces\ClientInterface::getEvents()
     */
    public function getEvents($eventId)
    {
        $return = $this->Client->request(
            'GET', "/v2/events/$eventId", 
            [
                'auth' => [self::$token, 'password'],
            ]
         );
        
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
    public function getTicket() {
        
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
