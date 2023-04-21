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
    /** @var string The API access token */
    private $token;

    /** @var string The instance token, settable once per new instance */
    private $instanceToken;

    private $apiBaseUri;

    private $apiQuery;

    private $apiResource;

    private $apiVersion;

    private $include;

    /** @var string The path to the log file */
    private $logFile;

    /** @var object loging object. */
    private $logger;

    /** @var string the logging level. */
    private string $logLevel;

    private $validator;

    private $guzzleClient;

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
    public function classPasses(): ClassPssses
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
    
    
    
    
    
    
    
    
    
        // ..
//     }public function __construct($token = null, string $logFile = 'inShoreBookwhen.log', string $logLevel = 'Debug')
//     {
//         // Logging.
//         // 'Debug',
//         // 'Info',
//         // 'Notice',
//         // 'Warning',
//         // 'Error',
//         // 'Critical',
//         // 'Alert',
//         // 'Emergency',
//         // Level::cases()
//         $this->logFile = $logFile;
//         $this->logLevel = $logLevel;
//         $this->logger = new Logger('inShore Bookwhen API');
//         $this->logger->pushHandler(new StreamHandler($this->logFile, $this->logLevel));

//         $this->validator = new Validator();

//         $this->include = [];

//         if ($token === null) {
//             // @todo fix messaging here
//             $msg = 'No token provided, and none is globally set. ';
//             $msg .= 'Use Diffbot::setToken, or instantiate the Diffbot class with a $token parameter.';
//             throw new ConfigurationException($msg);
//         } else {
//             if ($this->validator->validToken($token)) {
//                 $this->token = $token;
//                 $this->instanceToken = $this->token;
//             }
//         }

//         $this->apiBaseUri = 'https://api.bookwhen.com/';
//         $this->apiQuery = [];
//         $this->apiVersion = 'v2';

//         $this->guzzleClient = new GuzzleClient([
//             'base_uri' => $this->apiBaseUri
//         ]);

//         $this->logger->info('Client class successfully instantiated');
//         $this->logger->debug(var_export($this, true));
//     }

    /**
     * {@inheritDoc}
     * @see \InShore\Bookwhen\Interfaces\ClientInterface::request()
     */
    protected function request(): ResponseInterface
    {
        $this->logger->debug(__METHOD__ . '()');
        try {
            // Authorization.
            $requestOptions = [
                'headers' => [
                    'Authorization' => 'Basic ' . base64_encode($this->instanceToken . ':')
                ]
            ];

            // Query.
            if (!empty($this->apiQuery) && is_array($this->apiQuery)) {
                $requestOptions['query'] = $this->apiQuery;
                $this->apiQuery = [];
            }

            $this->logger->debug('request(GET, ' . $this->apiResource . ', ' . var_export($requestOptions, true) . ')');
            $requestOptions['debug'] = true;

            return $this->guzzleClient->request('GET', $this->apiResource, $requestOptions);

        } catch (Exception $e) {
            throw new RestException($e, $this->logger);
        }
    }

    /**
     * {@inheritDoc}
     * @see \InShore\Bookwhen\Interfaces\ClientInterface::getAttachment()
     */
    public function getAttachment($attachmentId)
    {
        $this->logger->debug(__METHOD__ . '(' . var_export(func_get_args(), true) . ')');
        if (!$this->validator->validId($attachmentId, 'attachment')) {
            throw new ValidationException('attachmentId', $attachmentId);
        }
        $this->apiResource = $this->apiVersion . '/attachments' . '/' . $attachmentId;

        try {
            $Response = $this->request();
            $body = json_decode($Response->getBody()->getContents());
            $attachment = $body->data[0];
            $return = $attachment;
            return $return;
        } catch (Exception $e) {
            throw new RestException($e, $this->logger);
        }
    }

    /**
     *
     * {@inheritDoc}
     * @see \InShore\Bookwhen\Interfaces\ClientInterface::getAttachments()
     */
    public function getAttachments($title = null, $fileName = null, $fileType = null): array
    {
        $this->logger->debug(__METHOD__ . '(' . var_export(func_get_args(), true) . ')');
        if (!is_null($title) && !$this->validator->validTitle($title)) {
            throw new ValidationException('title', $title);
        }

        if (!is_null($fileName) && !$this->validator->validFileName($fileName)) {
            throw new ValidationException('file name', $fileName);
        }

        if (!is_null($fileType) && !$this->validator->validFileType($fileType)) {
            throw new ValidationException('file type', $fileType);
        }

        $this->apiResource = $this->apiVersion . '/attachments';

        try {
            $return = [];
            $Response = $this->request();
            $body = json_decode($Response->getBody()->getContents());

            foreach ($body->data as $attachment) {
                array_push($return, $attachment);
            }

            return $return;
        } catch (Exception $e) {
            throw new RestException($e, $this->logger);
        }
    }

    /**
     *
     * {@inheritDoc}
     * @see \InShore\Bookwhen\Interfaces\ClientInterface::getClassPass()
     */
    public function getClassPass($classPassId)
    {
        $this->logger->debug(__METHOD__ . '(' . var_export(func_get_args(), true) . ')');
        $this->apiResource = $this->apiVersion . '/class_passes';

        if (!$this->validator->validId($classPassId, 'classPass')) {
            throw new ValidationException('classPassId', $classPassId);
        }

        try {
            $Response = $this->request();
            $body = json_decode($Response->getBody()->getContents());
            $classPass = $body->data;
            $return = $classPass;
            return $return;
        } catch (Exception $e) {
            throw new RestException($e->getMessage(), $this->logger);
        }
    }

    /**
     *
     * {@inheritDoc}
     * @see \InShore\Bookwhen\Interfaces\ClientInterface::getClassPasses()
     * @todo break params on to multiplper lines..
     */
    public function getClassPasses(
        $title = null,
        $detail = null,
        $usageType = null,
        $cost = null,
        $usageAllowance = null,
        $useRestrictedForDays = null
    ): array {

        $this->logger->debug(__METHOD__ . '(' . var_export(func_get_args(), true) . ')');

        if (!is_null($title) && !$this->validator->validTitle($title)) {
            throw new ValidationException('title', $title);
        }

        $this->apiResource = $this->apiVersion . '/class_passes';

        $return = [];

        try {
            $Response = $this->request();
            $body = json_decode($Response->getBody()->getContents());

            foreach ($body->data as $classPass) {
                array_push($return, $classPass);
            }

            return $return;
        } catch (Exception $e) {
            throw new RestException($e, $this->logger);
        }
    }

    /**
     *
     * {@inheritDoc}
     * @see \InShore\Bookwhen\Interfaces\ClientInterface::getEvent()
     */
    public function getEvent($eventId)
    {
        $this->logger->debug(__METHOD__ . '(' . var_export(func_get_args(), true) . ')');

        if (!$this->validator->validId($eventId, 'event')) {
            throw new ValidationException('eventId', $eventId);
        }
        $this->apiResource = $this->apiVersion . '/events' . '/' . $eventId;

        try {
            $Response = $this->request();
            $body = json_decode($Response->getBody()->getContents());
            $event = $body->data;
            $event->soldOut = (bool) ($event->attributes->attendee_count >= $event->attributes->attendee_limit);
            $event->availability = (int) ($event->attributes->attendee_count >= $event->attributes->attendee_limit);
            $return = $event;
            return $return;
        } catch (Exception $e) {
            throw new RestException($e, $this->logger);
        }
    }

    /**
     *
     * {@inheritDoc}
     * @see \InShore\Bookwhen\Interfaces\ClientInterface::getEvents()
     */
    public function getEvents(
        $calendar = false,
        $entry = false,
        $location = [],
        $tags = [],
        $title = [],
        $detail = [],
        $from = null,
        $to = null,
        $includeLocation = false,
        $includeAttachments = false,
        $includeTickets = false,
        $includeTicketsEvents = false,
        $includeTicketsClassPasses = false
    ): array {

        $this->logger->debug(__METHOD__ . '(' . var_export(func_get_args(), true) . ')');

        // Validate $tags.
        if (!empty($tags)) {
            if (!is_array($tags)) {
                throw new ValidationException('tags', implode(' ', $tags));
            } else {
                $tags = array_unique($tags);
                foreach ($tags as $tag) {
                    if (!empty($tag) && !$this->validator->validTag($tag)) {
                        throw new ValidationException('tag', $tag);
                    }
                }
            }
            $this->apiQuery['filter[tag]'] = implode(',', $tags);
        }

        // Validate $from;
        if (!empty($from)) {
            if (!$this->validator->validFrom($from, $to)) {
                throw new ValidationException('from', $from . '-' . $to);
            } else {
                $this->apiQuery['filter[from]'] = $from;
            }
        }

        // Validate $to;
        if (!empty($to)) {
            if (!$this->validator->validTo($to, $from)) {
                throw new ValidationException('to', $to . '-' . $from);
            } else {
                $this->apiQuery['filter[to]'] = $to;
            }
        }

        // API resource.
        $this->apiResource = $this->apiVersion . '/events';


        $include = [];
        // Validate $includeLocation;

        if (!empty($includeLocation)) {
            if (!$this->validator->validInclude($includeLocation)) {
                throw new ValidationException('include', $includeLocation);
            } elseif ($includeLocation) {
                $include[] = 'location';
            }
        }

        // Validate $includeAttachments;
        if (!empty($includeAttachments)) {
            if (!$this->validator->validInclude($includeAttachments)) {
                throw new ValidationException('include', $includeAttachments);
            } elseif ($includeAttachments) {
                $include[] = 'attachments';
            }
        }

        // Validate $includeTickets
        if (!empty($includeTickets)) {
            if (!$this->validator->validInclude($includeTickets)) {
                throw new ValidationException('include', $includeTickets);
            } elseif ($includeTickets) {
                $include[] = 'tickets';
            }
        }

        // Validate $includeTicketsEvents;
        if (!empty($includeTicketsEvents)) {
            if (!$this->validator->validInclude($includeTicketsEvents)) {
                throw new ValidationException('include', $includeTicketsEvents);
            } elseif ($includeTicketsEvents) {
                $include[] = 'tickets.events';
            }
        }

        // Validate $includeTicketsEvents;
        if (!empty($includeTicketsClassPasses)) {
            if (!$this->validator->validInclude($includeTicketsClassPasses)) {
                throw new ValidationException('include', $includeTicketsClassPasses);
            } elseif ($includeTicketsClassPasses) {
                $include[] = 'tickets.class_passes';
            }
        }

        if (count($include) > 0) {
            $this->apiQuery['include'] = implode(',', $include);

        }

        try {
            $Response = $this->request();

            $body = json_decode($Response->getBody()->getContents());

            // Prepocess response onto nice model objects.
            // @todo abstract.
            $return = [];

            foreach ($body->data as $event) {
                // Add additional properties here.
                $event->availability = (int) ($event->attributes->attendee_limit - $event->attributes->attendee_count);
                $event->soldOut = (bool) ($event->attributes->attendee_count >= $event->attributes->attendee_limit);
                array_push($return, $event);
            }

            return $return;
        } catch (Exception $e) {
            throw new RestException($e, $this->logger);
        }
    }

    /**
     *
     * {@inheritDoc}
     * @see \InShore\Bookwhen\Interfaces\ClientInterface::getLocation()
     */
    public function getLocation($locationId)
    {

        if (!$this->validator->validId($locationId, 'location')) {
            throw new ValidationException('locationId', $locationId);
        }

        $this->apiResource = $this->apiVersion . '/locations/' . $locationId;

        try {
            $Response = $this->request();
            $body = json_decode($Response->getBody()->getContents());
            $location = $body->data;
            $return = $location;
            return $return;
        } catch (Exception $e) {
            throw new RestException($e->getMessage(), $this->logger);
        }

    }

    /**
     *
     * {@inheritDoc}
     * @see \InShore\Bookwhen\Interfaces\ClientInterface::getLocations()
     * @todo validate params.
     */
    public function getLocations($addressText = null, $additionalInfo = null): array
    {
        $this->apiResource = $this->apiVersion . '/locations';

        $return = [];

        try {
            $Response = $this->request();
            $body = json_decode($Response->getBody()->getContents());

            foreach ($body->data as $location) {
                array_push($return, $location);
            }

            return $return;
        } catch (Exception $e) {
            throw new RestException($e, $this->logger);
        }
    }

    /**
     *
     * {@inheritDoc}
     * @see \InShore\Bookwhen\Interfaces\ClientInterface::getTicket()
     */
    public function getTicket($ticketId)
    {
        if (!$this->validator->validId($ticketId, 'ticket')) {
            throw new ValidationException('ticketId', $ticketId);
        }

        $this->apiResource = $this->apiVersion . '/tickets';


        try {
            $Response = $this->request();
            $body = json_decode($Response->getBody()->getContents());
            $ticket = $body->data[0];
            $return = $ticket;
            return $return;
        } catch (Exception $e) {
            throw new RestException($e, $this->logger);
        }
    }

    /**
     *
     * {@inheritDoc}
     * @see \InShore\Bookwhen\Interfaces\ClientInterface::getTickets()
     */
    public function getTickets($eventId): array
    {
        $this->logger->debug(__METHOD__ . '(' . var_export(func_get_args(), true) . ')');
        if (!$this->validator->validId($eventId, 'event')) {
            throw new ValidationException('eventId', $eventId);
        }

        $this->apiQuery = ['event' => $eventId];

        $this->apiResource = $this->apiVersion . '/tickets';

        try {
            $return = [];

            $Response = $this->request();
            $body = json_decode($Response->getBody()->getContents());

            foreach ($body->data as $ticket) {
                array_push($return, $ticket);
            }
            $this->logger->debug(var_export($return, true));
            return $return;
        } catch (GuzzleHttp\Exception\ClientException $e) {
            throw new RestException($e, $this->logger);
        }
    }

    /**
     * Set Debug.
     */
    public function setLogging($level)
    {
        $this->logging = $level;
    }

    /**
     * Set Guzzle Client
     */
    public function setGuzzleClient($guzzleClient)
    {
        $this->guzzleClient = $guzzleClient;
    }

    /**
     * Sets the token for all future new instances
     * @param $token string The API access token, as obtained on diffbot.com/dev.
     */
    public static function setToken($token)
    {
        $validator = new Validator();
        if (!$validator->validToken($token)) {
            throw new \InvalidArgumentException('Invalid Token.');
        }
        self::$token = $token;
    }

    

}

// EOF!
