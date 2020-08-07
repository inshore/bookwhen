<?php

declare(strict_types = 1);

namespace InShore\BookWhen;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Psr7\Request;
use InShore\BookWhen\Exceptions\Exception;
use InShore\BookWhen\Interfaces\ClientInterface;
use InShore\BookWhen\Validator;

/**
 * Class Client
 *
 * The main class for API consumption
 *
 * @package inshore-packages\bookwhen
 */
class Client implements ClientInterface
{
    
    /** @var string The API access token */
    private static $token = null;
    
    /** @var string The instance token, settable once per new instance */
    private $instanceToken;
    
    private $apiBaseUri;
    
    private $apiQuery;
   
    private $apiResource;
    
    private $apiVersion;
    
    private $Validator;
    
    private $GuzzleClient;
    
    /**
     * @param string|null $token The API access token, as obtained on diffbot.com/dev
     * @throws DiffbotException When no token is provided
     */
    public function __construct($token = null)
    {
        
        $this->apiQuery = [];
        
        $this->apiVersion = 'v2';
        
        $this->Validator = new Validator();
        
        $this->GuzzleClient = new GuzzleClient([
            'base_uri' => 'https://api.bookwhen.com/'
        ]);
        
        if ($token === null) {
            if (self::$token === null) {
                $msg = 'No token provided, and none is globally set. ';
                $msg .= 'Use Diffbot::setToken, or instantiate the Diffbot class with a $token parameter.';
                throw new Exception($msg);
            }
        } else {
            if($this->Validator->validToken($token)) {
                self::$token = $token;
                $this->instanceToken = self::$token;
            }
        }
    }
    
    /**
     * @todo pull in the $this->$apiQuery and attach if not empty.['query' => ['foo' => 'bar']
     */
    protected function request() {
        try {
            // Authorization.
            $requestOptions = [
                'headers' => [
                    'Authorization' => 'Basic '.base64_encode($this->instanceToken.':')
                ]
            ];
            
            // Query.
            if (!empty($this->apiQuery) && is_array($this->apiQuery)) {
                $requestOptions['query'] = $this->apiQuery;
            }
   
            
            
            $requestOptions['debug'] = true;
            //$request = new Request('GET', $this->apiResource, $requestOptions);

            //return $this->GuzzleClient->send($request);
            return $this->GuzzleClient->request('GET', $this->apiResource, $requestOptions);
           
        } catch (Exception $e) {
            // @todo;
        }
    }
    
    /**
     * @todo
     */
    public function getAttachment($attachmentId) {
        $this->apiResource = $this->apiVersion . '/attachmetns';
        
        // if(!empty($eventId && !$this->Valdator->validId($attachmentId))) {
        //     throw \Exception::class;
        // }
        
        try {
            $return = $this->request();
        } catch (Exception $e) {
            // @todo
        }
        
        return $null;
    }
    
    /**
     *
     * {@inheritDoc}
     * @see \InShore\BookWhen\Interfaces\ClientInterface::getAttachments()
     */
    public function getAttachments()
    {    
        $this->apiResource = $this->apiVersion . '/attachments';
        
        // @todo prepocess response onto nice model objects.
        return $this->request();
    }
    
    /**
     *
     * {@inheritDoc}
     * @see \InShore\BookWhen\Interfaces\ClientInterface::getClassPass()
     */
    public function getClassPass($classPassId)
    {
        
    }
    
    /**
     *
     * {@inheritDoc}
     * @see \InShore\BookWhen\Interfaces\ClientInterface::getClassPasses()
     */
    public function getClassPasses() 
    {   
        $this->apiResource = $this->apiVersion . '/???';
        
        // @todo prepocess response onto nice model objects.
        return $this->request();
    }
    
    /**
     *
     * {@inheritDoc}
     * @see \InShore\BookWhen\Interfaces\ClientInterface::getEvent()
     */
    public function getEvent($eventId) 
    {   
        $this->apiResource = $this->apiVersion . '/events';
        
        $return = null;
        // if(!empty($eventId && !$this->Valdator->validId($eventId))) {
        //     throw \Exception::class;
        // }
     
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
    public function getEvents($tags = [], $from = null, $to = null, $includeLocation = false, $includeTickets = false)
    {    
        // Validate $tags.
        if (!empty($tags)) {
            if(!is_array($tags)) {
                // @todo throw \Exception::class;
            } else {
                $tags = array_unique($tags);
                foreach ($tags as $tag) {
                    if (!empty($tag) && !$this->Validator->validTag($tag)) {
                        throw \Exception::class;
                    }
                }
            }
            $this->apiQuery['filter[tag]'] = implode(',', $tags);
        }
        
        // Validate $from;
        if(!empty($from)) {
            if(!$this->Validator->validFrom($from, $to)) {
                throw \Exception::class;
            } else {
                $this->apiQuery['filter[from]'] = $from;
            }
        }
        
        // Validate $to;
        if(!empty($to)) {
            if(!$this->Validator->validFrom($from, $to)) {
                throw \Exception::class;
            } else {
                $this->apiQuery['filter[to]'] = $to;
            }
        }
        
        // API resource.
        $this->apiResource = $this->apiVersion . '/events';
        
        
        
        // Validate $includeLocation;
        
        // Validate $includeTickets;
        
        // @todo prepocess response onto nice model objects.
        $return = null;
        
        try {
            $Response = $this->request();
        } catch (Exception $e) {
            // @todo
        }
        
        $body = json_decode($Response->getBody()->getContents());
        
        $return = [];
        
        foreach ($body->data as $event) {
            // Add additional properties here.
            $event->soldOut = (bool) ($event->attributes->attendee_count >= $event->attributes->attendee_limit);
            array_push($return, $event);
        }
        
        return $return;
    }
    
    /**
     *
     * {@inheritDoc}
     * @see \InShore\BookWhen\Interfaces\ClientInterface::getLocation()
     */
    public function getLocation($locationId)
    {
        $this->apiResource = $this->apiVersion . '/locations';
        
        $return = null;
        // if(!empty($eventId && !$this->Valdator->validId($ticketId))) {
        //     throw \Exception::class;
        // }
        
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
     * @see \InShore\BookWhen\Interfaces\ClientInterface::getLocations()
     */
    public function getLocations()
    {
        $this->apiResource = $this->apiVersion . '/locations';

        try {
            $Response = $this->request();
        } catch (Exception $e) {
            
            // @todo
        }

        return json_decode($Response->getBody()->getContents(), true);
    } 
    
    /**
     *
     * {@inheritDoc}
     * @see \InShore\BookWhen\Interfaces\ClientInterface::getTicket()
     */
    public function getTicket($ticketId)
    {
        $this->apiResource = $this->apiVersion . '/tickets';
        
        $return = null;
        // if(!empty($eventId && !$this->Valdator->validId($ticketId))) {
        //     throw \Exception::class;
        // }
        
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
     * @see \InShore\BookWhen\Interfaces\ClientInterface::getTickets()
     * 
     * ['query' => ['foo' => 'bar']
     */
    public function getTickets($eventId)
    {
        if (!$this->Validator->validId($eventId)) {
            throw new \InvalidArgumentException('Invalid Event ID.');
        }

        $this->apiQuery = ['event' => $eventId];
        
        $this->apiResource = $this->apiVersion . '/tickets';
        
        $return = [];
        
        try {
            $Response = $this->request();
            $body = json_decode($Response->getBody()->getContents());
            foreach ($body->data as $ticket) {
                array_push($return, $ticket);
            }
            return $return;
        } catch (Exception $e) {
            // @todo
        }
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
    
    /**
     * 
     * @param unknown $token
     * @throws \InvalidArgumentException
     * @return boolean
     */
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
