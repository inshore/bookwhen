<?php

declare(strict_types=1);

namespace InShore\Bookwhen;

use InShore\Bookwhen\BookwhenApi;
use InShore\Bookwhen\Client;
use InShore\Bookwhen\Domain\Attachment;
use InShore\Bookwhen\Domain\ClassPass;
use InShore\Bookwhen\Domain\Event;
use InShore\Bookwhen\Domain\Location;
use InShore\Bookwhen\Domain\Ticket;
use InShore\Bookwhen\Exceptions\ValidationException;
use InShore\Bookwhen\Interfaces\BookwhenInterface;
use InShore\Bookwhen\Validator;
use Monolog\Level;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

final class Bookwhen implements BookwhenInterface
{
    private null | Client $client;

    /**
     *
     * @var unknown
     */
    public Attachment $attachment;

    /**
     *
     * @var unknown
     */
    public array $attachments = [];

    /**
     *
     * @var unknown
     */
    public ClassPass $classPass;

    /**
     *
     * @var unknown
     */
    public array $classPasses = [];

    /**
     *
     * @var unknown
     */
    public Event $event;

    /**
     *
     * @var unknown
     */
    public array $events = [];

    /**
     *
     */
    public readonly Location $location;


    /**

     */
    public Ticket $ticket;

    /**

     */
    public array $tickets = [];

    /**
        *
     */
    public $locations = [];


    /** @var string The path to the log file */
    private $logFile;

    /** @var object loging object. */
    private $logger;

    /** @var string the logging level. */
    private string $logLevel;



    /**
     * Creates a new Bookwhen Client with the given API token.
     * @todo logging
     */
    public function __construct(
        private $validator = new Validator()
    ) {
        //         $this->logFile = $logFile;
        //         $this->logLevel = $logLevel;
        //         $this->logger = new Logger('inShore Bookwhen API');
        //         $this->logger->pushHandler(new StreamHandler($this->logFile, $this->logLevel));
        $this->client = BookwhenApi::client($_ENV['INSHORE_BOOKWHEN_API_KEY']);
    }

    /**
     *
     * {@inheritDoc}
     * @see \InShore\Bookwhen\Interfaces\ClientInterface::attachment()
     * @todo all attachment properties
     */
    public function attachment(string $attachmentId): Attachment
    {
        if (!$this->validator->validId($attachmentId, 'attachment')) {
            throw new ValidationException('attachmentId', $attachmentId);
        }

        $attachment = $this->client->attachments()->retrieve($attachmentId);

        return $this->attachment = new Attachment(
            $classPass->details,
            $classPass->id,
            $classPass->title,
        );
    }

    /**
     *
     * {@inheritDoc}
     * @see \InShore\Bookwhen\Interfaces\BookwhenInterface::attachment()
     * @todo
     */
    public function attachments(
        string $title = null,
        string $fileName = null,
        string $fileType = null
    ): array {
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

        foreach ($attachments->data as $attachment) {
            array_push($this->attachment, new Attachment(
                $attachment->id,
            ));
        }

        return $this->attachments;
    }

    /**
     *
     * {@inheritDoc}
     * @see \InShore\Bookwhen\Interfaces\ClientInterface::getClassPass()
     * @todo
     */
    public function classPass(string $classPassId): ClassPass
    {
        //         $this->logger->debug(__METHOD__ . '(' . var_export(func_get_args(), true) . ')');

        //       if (!$this->validator->validId($classPassId, 'classPass')) {
        //           throw new ValidationException('classPassId', $classPassId);
        //      }

        $classPass = $this->client->classPasses()->retrieve($classPassId);

        return new ClassPass(
            $classPass->details,
            $classPass->id,
            $classPass->number_available,
            $classPass->title,
            $classPass->usage_allowance,
            $classPass->usage_type,
            $classPass->use_restricted_for_days
        );
    }

    /**
     *
     * {@inheritDoc}
     * @see \InShore\Bookwhen\Interfaces\ClientInterface::getClassPasses()
     * @todo break params on to multiplper lines..
     */
    public function classPasses(
        $title = null,
        $detail = null,
        $usageType = null,
        $cost = null,
        $usageAllowance = null,
        $useRestrictedForDays = null
    ): array {

        //$this->logger->debug(__METHOD__ . '(' . var_export(func_get_args(), true) . ')');

        if (!is_null($title) && !$this->validator->validTitle($title)) {
            throw new ValidationException('title', $title);
        }

        // @todo remaingin validation

        $classPasses = $this->client->classPasses()->list([]);

        foreach ($classPasses->data as $classPass) {
            array_push($this->classPasses, new classPasses(
                $ticket->details,
                $ticket->id,
                $ticket->title
            ));
        }
        return $this->classPasses;
    }

    /**
     *
     * {@inheritDoc}
     * @see \InShore\Bookwhen\Interfaces\BookwhenInterface::event()
     * @todo break params on to multiplper lines..
     */
    public function event(string $eventId): Event
    {
        //$this->logger->debug(__METHOD__ . '(' . var_export(func_get_args(), true) . ')');

        if (!$this->validator->validId($eventId, 'event')) {
            throw new ValidationException('eventId', $eventId);
        }

        $event = $this->client->events()->retrieve($eventId);
        $eventAttachments = [];


        $eventTickets = [];
        foreach ($event->tickets as $eventTicket) {
            $ticket = $this->client->tickets()->retrieve($eventTicket['id']);
            array_push($eventTickets, new Ticket(
                $ticket->available,
                $ticket->availableFrom,
                $ticket->availableTo,
                $ticket->builtBasketUrl,
                $ticket->builtBasketIframeUrl,
                $ticket->courseTicket,
                $ticket->details,
                $ticket->groupTicket,
                $ticket->groupMin,
                $ticket->groupMax,
                $ticket->id,
                $ticket->numberIssued,
                $ticket->numberTaken,
                $ticket->title
            ));
        }

        $location = $this->client->locations()->retrieve($event->locationId);

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
    ): array {

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

    /*
     *
     * {@inheritDoc}
     * @see \InShore\Bookwhen\Interfaces\ClientInterface::getLocation()
     */
    public function location(string $locationId): Location
    {

        if (!$this->validator->validId($locationId, 'location')) {
            throw new ValidationException('locationId', $locationId);
        }

        $location = $this->client->locations()->retrieve($locationId);

        return $this->location = new Location(
            $location->additionalInfo,
            $location->addressText,
            $location->id,
            $location->latitude,
            $location->longitude,
            $location->mapUrl,
            $location->zoom
        );
    }

    /**
     *
     * {@inheritDoc}
     * @see \InShore\Bookwhen\Interfaces\ClientInterface::getLocations()
     * @todo validate params.
     */
    public function locations(
        null | string $addressText = null,
        null | string $additionalInfo = null
    ): array {

        // $this->logger->debug(__METHOD__ . '(' . var_export(func_get_args(), true) . ')');

        if (!$this->validator->validId($eventId, 'event')) {
            throw new ValidationException('eventId', $eventId);
        }

        $locations = $this->client->locations()->list();

        foreach ($locations->data as $location) {
            array_push($this->locations, new Location(
                $location->additionalInfo,
                $location->addressText,
                $location->id,
                $location->latitude,
                $location->longitude,
                $location->mapUrl,
                $location->zoom
            ));
        }

        return $this->locations;

    }

    /**
     * Set Debug.
     * @deprecated
     */
    public function setLogging($level)
    {
        $this->logging = $level;
    }

     /**
     * Sets the token for all future new instances
     * @deprecated
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

    /**
     * {@inheritDoc}
     * @see \InShore\Bookwhen\Interfaces\BookWhenInterface::ticket()
     */
    public function ticket($ticketId): Ticket
    {
        if (!$this->validator->validId($ticketId, 'ticket')) {
            throw new ValidationException('ticketId', $ticketId);
        }

        $ticket = $this->client->tickets()->retrieve($ticketId);

        return $this->ticket = new Ticket(
            $ticket->available,
            $ticket->availableFrom,
            $ticket->availableTo,
            $ticket->builtBasketUrl,
            $ticket->builtBasketIframeUrl,
            $ticket->courseTicket,
            $ticket->details,
            $ticket->groupTicket,
            $ticket->groupMin,
            $ticket->groupMax,
            $ticket->id,
            $ticket->numberIssued,
            $ticket->numberTaken,
            $ticket->title
        );
    }

    /**
     * {@inheritDoc}
     * @see \InShore\Bookwhen\Interfaces\BookWhenInterface::tickets()
     * @todo includes
     */
    public function tickets(string $eventId): array
    {
        // $this->logger->debug(__METHOD__ . '(' . var_export(func_get_args(), true) . ')');

        if (!$this->validator->validId($eventId, 'event')) {
            throw new ValidationException('eventId', $eventId);
        }

        $tickets = $this->client->tickets()->list([
            'event_id' => $eventId,
            'include' => 'events.tickets'
        ]);

        foreach ($tickets->data as $ticket) {
            array_push($this->tickets, new Ticket(
                $ticket->available,
                $ticket->availableFrom,
                $ticket->availableTo,
                $ticket->builtBasketUrl,
                $ticket->builtBasketIframeUrl,
                $ticket->courseTicket,
                $ticket->details,
                $ticket->groupTicket,
                $ticket->groupMin,
                $ticket->groupMax,
                $ticket->id,
                $ticket->numberIssued,
                $ticket->numberTaken,
                $ticket->title
            ));
        }

        return $this->tickets;

    }
}
