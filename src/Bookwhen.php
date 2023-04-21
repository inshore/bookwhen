<?php

declare(strict_types=1);

namespace InShore\Bookwhen;

use InShore\Bookwhen\BookwhenApi;
use InShore\Bookwhen\Domain\Attachment;
use InShore\Bookwhen\Domain\ClassPass;
use InShore\Bookwhen\Domain\Event;
use InShore\Bookwhen\Domain\Location;
use InShore\Bookwhen\Domain\Ticket;
use InShore\Bookwhen\Exceptions\ValidationException;
use InShore\Bookwhen\Validator;
use Monolog\Level;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

final class Bookwhen
{
    private $client = null;

    /**
     *
     * @var unknown
     */
    public Attachment $attachment;
    
    /**
     *
     * @var unknown
     */
    public ClassPass $classPass;
    
    /**
     *
     * @var unknown
     */
    public Event $event;
    
    /**
     *
     * @var unknown
     */
    public array $events;

    public $locations = [];
    public readonly Location $location;

    /** @var string The path to the log file */
    private $logFile;
    
    /** @var object loging object. */
    private $logger;
    
    /** @var string the logging level. */
    private string $logLevel;
        
    /**
     * Creates a new Bookwhen Client with the given API token.
     */
    public function __construct(
        private $validator = new Validator()
    )
    {
//         $this->logFile = $logFile;
//         $this->logLevel = $logLevel;
//         $this->logger = new Logger('inShore Bookwhen API');
//         $this->logger->pushHandler(new StreamHandler($this->logFile, $this->logLevel));
        
        
        $this->client = BookwhenApi::client($_ENV['INSHORE_BOOKWHEN_API_KEY']);
    }

    
    public function attachments(string $title = null, string $fileName = null, string $fileType = null): array
    {
        //$this->logger->debug(__METHOD__ . '(' . var_export(func_get_args(), true) . ')');
        
        if (!is_null($title) && !$this->validator->validTitle($title)) {
            throw new ValidationException('title', $title);
        }
        
        if (!is_null($fileName) && !$this->validator->validFileName($fileName)) {
            throw new ValidationException('file name', $fileName);
        }
        
        if (!is_null($fileType) && !$this->validator->validFileType($fileType)) {
            throw new ValidationException('file type', $fileType);
        }
        
        $attachments = $this->client->attachments()->list();
    }
    /**

     */
    public function event($eventId)
    {
        //$this->logger->debug(__METHOD__ . '(' . var_export(func_get_args(), true) . ')');
        
        if (!$this->validator->validId($eventId, 'event')) {
            throw new ValidationException('eventId', $eventId);
        }
        //if($this->event === null || $this->event->id === null || $this->event->id !== $eventId) {
        $event = $this->client->events()->retrieve($eventId);
        $eventAttachments = [];
        
     
        $eventTickets = [];
        $location = $this->client->locations()->retrieve($event->locationId);
        
//         $this->event->location = new Location(
//             $location->addressText,
//             $location->additionalInfo,
//             $location->id,
//             $location->latitude,
//             $location->longitude,
//             $location->mapUrl,
//             $location->zoom
//             );
        
        $this->event = new Event(
            $event->allDay,
            $eventAttachments,
            $event->attendeeCount,
            $event->attendeeLimit,
            $event->details,
            $event->endAt,
            $event->id,
            new Location(
                $location->addressText,
                $location->additionalInfo,
                $location->id,
                $location->latitude,
                $location->longitude,
                $location->mapUrl,
                $location->zoom
            ),
            $event->maxTicketsPerBooking,
            $event->startAt,
            $eventTickets, 
            $event->title,
            $event->waitingList
        );
        // }
        //

        return $this->event;
    }
    
    
    /**
     *
     * {@inheritDoc}
     * @see \InShore\Bookwhen\Interfaces\ClientInterface::getEvents()
     */
    public function Events(
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
        ): array 
     {
        
        //$this->logger->debug(__METHOD__ . '(' . var_export(func_get_args(), true) . ')');
        
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
           // $this->apiQuery['filter[tag]'] = implode(',', $tags);
        }
        
        // Validate $from;
        if (!empty($from)) {
            if (!$this->validator->validFrom($from, $to)) {
                throw new ValidationException('from', $from . '-' . $to);
            } else {
             //   $this->apiQuery['filter[from]'] = $from;
            }
        }
        
        // Validate $to;
        if (!empty($to)) {
            if (!$this->validator->validTo($to, $from)) {
                throw new ValidationException('to', $to . '-' . $from);
            } else {
              //  $this->apiQuery['filter[to]'] = $to;
            }
        }
        
        $this->events = [];
        
        return $this->events;
        
    }
    
   
    /**
     *
     * {@inheritDoc}
     * @see \InShore\Bookwhen\Interfaces\ClientInterface::getTicket()
     */
    public function ticket($ticketId)
    {
        if (!$this->validator->validId($ticketId, 'ticket')) {
            throw new ValidationException('ticketId', $ticketId);
        }
    }
    
    /**
     *
     * {@inheritDoc}
     * @see \InShore\Bookwhen\Interfaces\ClientInterface::getTicket()
     */
    public function tickets()
    {
        return $this->client->tickets();
    }
}
