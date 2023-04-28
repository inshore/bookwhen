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
    /**
     *
     */
    private null | Client $client;

    /**
     *
     */
    public Attachment $attachment;

    /**
     *
     */
    public array $attachments = [];

    /**
     *
     */
    public ClassPass $classPass;

    /**
     *
     */
    public array $classPasses = [];

    /**
     *
     */
    public Event $event;

    /**
     *
     */
    public array $events = [];

    /**
     *
     */
    private array $filters = [];

    /**
     *
     */
    public Location $location;

    /**
     *
     */
    private array $includes = [];

    /**
     *
     */
    public Ticket $ticket;

    /**
     *
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
        string $apiKey = null,
        private $validator = new Validator()
        ) {
            //         $this->logFile = $logFile;
            //         $this->logLevel = $logLevel;
            //         $this->logger = new Logger('inShore Bookwhen API');
            //         $this->logger->pushHandler(new StreamHandler($this->logFile, $this->logLevel));
            $this->client = BookwhenApi::client(!is_null($apiKey) ? $apiKey : $_ENV['INSHORE_BOOKWHEN_API_KEY']);
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
            $attachment->contentType,
            $attachment->fileUrl,
            $attachment->fileSizeBytes,
            $attachment->fileSizeText,
            $attachment->fileName,
            $attachment->fileType,
            $attachment->id,
            $attachment->title,
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
        } else {
            $this->filters['filter[title]'] = $title;
        }

        if (!is_null($fileName) && !$this->validator->validFileName($fileName)) {
            throw new ValidationException('file name', $fileName);
        } else {
            $this->filters['filter[file_name]'] = $fileName;
        }

        if (!is_null($fileType) && !$this->validator->validFileType($fileType)) {
            throw new ValidationException('file type', $fileType);
        } else {
            $this->filters['filter[file_type]'] = $fileType;
        }

        $attachments = $this->client->attachments()->list($this->filters);

        foreach ($attachments->data as $attachment) {
            array_push($this->attachments, new Attachment(
                $attachment->contentType,
                $attachment->fileUrl,
                $attachment->fileSizeBytes,
                $attachment->fileSizeText,
                $attachment->fileName,
                $attachment->fileType,
                $attachment->id,
                $attachment->title
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

        if (!$this->validator->validId($classPassId, 'classPass')) {
            throw new ValidationException('classPassId', $classPassId);
        }

        $classPass = $this->client->classPasses()->retrieve($classPassId);

        return new ClassPass(
            $classPass->details,
            $classPass->id,
            $classPass->numberAvailable,
            $classPass->title,
            $classPass->usageAllowance,
            $classPass->usageType,
            $classPass->useRestrictedForDays
        );
    }

    /**
     *
     * {@inheritDoc}
     * @see \InShore\Bookwhen\Interfaces\ClientInterface::getClassPasses()
     * @todo break params on to multiplper lines..
     */
    public function classPasses(
        $cost = null,
        $detail = null,
        $title = null,
        $usageAllowance = null,
        $usageType = null,
        $useRestrictedForDays = null
    ): array {

        //$this->logger->debug(__METHOD__ . '(' . var_export(func_get_args(), true) . ')');

        if (!is_null($detail) && !$this->validator->validDetails($detail)) {
            throw new ValidationException('detail', $detail);
        } else {
            $this->filters['filter[detail]'] = $detail;
        }

        if (!is_null($title) && !$this->validator->validTitle($title)) {
            throw new ValidationException('title', $title);
        } else {
            $this->filters['filter[title]'] = $title;
        }

        if (!is_null($usageAllowance) && !$this->validator->validUsageAllowance($usageAllowance)) {
            throw new ValidationException('usageAllowance', $usageAllowance);
        } else {
            $this->filters['filter[usage_allowance]'] = $usageAllowance;
        }

        if (!is_null($usageType) && !$this->validator->validUsageType($usageType)) {
            throw new ValidationException('usageType', $usageType);
        } else {
            $this->filters['filter[usage_type]'] = $usageType;
        }

        if (!is_null($useRestrictedForDays) && !$this->validator->validUseRestrictedForDays($useRestrictedForDays)) {
            throw new ValidationException('useRestrictedForDays', $useRestrictedForDays);
        } else {
            $this->filters['filter[use_restricted_for_days]'] = $useRestrictedForDays;
        }

        $classPasses = $this->client->classPasses()->list($this->filters);

        foreach ($classPasses->data as $classPass) {
            array_push($this->classPasses, new ClassPass(
                $classPass->details,
                $classPass->id,
                $classPass->numberAvailable,
                $classPass->title,
                $classPass->usageAllowance,
                $classPass->usageType,
                $classPass->useRestrictedForDays,
            ));
        }
        return $this->classPasses;
    }

    /**
     *
     * {@inheritDoc}
     * @see \InShore\Bookwhen\Interfaces\BookwhenInterface::event()
     * @todo filters.
     */
    public function event(
        string $eventId,
        bool $includeAttachments = false,
        bool $includeLocation = false,
        bool $includeTickets = false,
        bool $includeTicketsClassPasses = false,
        bool $includeTicketsEvents = false
    ): Event {
        //$this->logger->debug(__METHOD__ . '(' . var_export(func_get_args(), true) . ')');

        if (!$this->validator->validId($eventId, 'event')) {
            throw new ValidationException('eventId', $eventId);
        }

        // Validate $includeAttachments;
        if (!$this->validator->validInclude($includeAttachments)) {
            throw new ValidationException('includeAttachments', $includeAttachments);
        }

        if ($includeAttachments) {
            array_push($this->includes, 'attachments');
        }

        // Validate $includeTickets;
        if (!$this->validator->validInclude($includeLocation)) {
            throw new ValidationException('includeLocation', $includeLocation);
        }
        if ($includeLocation) {
            array_push($this->includes, 'location');
        }

        // Validate $includeTickets;
        if (!$this->validator->validInclude($includeTickets)) {
            throw new ValidationException('includeTickets', $includeTickets);
        }

        if ($includeTickets) {
            array_push($this->includes, 'tickets');
        }

        // Validate $includeTicketsEvents;
        if (!$this->validator->validInclude($includeTicketsEvents)) {
            throw new ValidationException('includeTicketsEvents', $includeTicketsEvents);
        }

        if ($includeTicketsEvents) {
            array_push($this->includes, 'tickets.events');
        }

        // Validate $includeTicketsClassPasses;
        if (!$this->validator->validInclude($includeTicketsClassPasses)) {
            throw new ValidationException('includeTicketsClassPasses', $includeTicketsClassPasses);
        }

        if ($includeTicketsClassPasses) {
            array_push($this->includes, 'tickets.class_passes');
        }

        $event = $this->client->events()->retrieve($eventId, ['include' => implode(',', $this->includes)]);

        // attachments
        $eventAttachments = [];

        foreach ($event->attachments as $eventAttachment) {
            $attachment = $this->client->attachments()->retrieve($eventAttachment['id']);
            array_push($eventAttachments, new Attachment(
                $attachment->contentType,
                $attachment->fileUrl,
                $attachment->fileSizeBytes,
                $attachment->fileSizeText,
                $attachment->fileName,
                $attachment->fileType,
                $attachment->id,
                $attachment->title
            ));
        }

        // eventTickets
        $eventTickets = [];
        foreach ($event->tickets as $ticket) {
            array_push($eventTickets, new Ticket(
                $ticket->available,
                $ticket->availableFrom,
                $ticket->availableTo,
                $ticket->builtBasketUrl,
                $ticket->builtBasketIframeUrl,
                $ticket->cost,
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

        // ticketsClassPasses
        // @todo

        // ticketsEvents
        // @todo

        return $this->event = new Event(
            $event->allDay,
            $eventAttachments,
            $event->attendeeCount,
            $event->attendeeLimit,
            $event->details,
            $event->endAt,
            $event->id,
            new Location(
                $event->location->additionalInfo,
                $event->location->addressText,
                $event->location->id,
                $event->location->latitude,
                $event->location->longitude,
                $event->location->mapUrl,
                $event->location->zoom
            ),
            $event->maxTicketsPerBooking,
            $event->startAt,
            $eventTickets,
            $event->title,
            $event->waitingList
        );
    }

    /**
     *
     * {@inheritDoc}
     * @see \InShore\Bookwhen\Interfaces\ClientInterface::getEvents()
     */
    public function events(
        $calendar = false,
        $entry = false,
        $location = [],
        $tags = [],
        $title = [],
        $detail = [],
        $from = null,
        $to = null,
        bool $includeAttachments = false,
        bool $includeLocation = false,
        bool $includeTickets = false,
        bool $includeTicketsClassPasses = false,
        bool $includeTicketsEvents = false
    ): array {

        //$this->logger->debug(__METHOD__ . '(' . var_export(func_get_args(), true) . ')');

        // Validate $calendar
        // @todo details required

        // Validate $detail
        if (!empty($detail)) {
            if (!is_array($detail)) {
                throw new ValidationException('detail', implode(' ', $detail));
            } else {
                $detail = array_unique($detail);
                foreach ($detail as $item) {
                    if (!$this->validator->validLocation($item)) {
                        throw new ValidationException('detail', $item);
                    }
                }
                $this->filters['filter[detail]'] = implode(',', $detail);
            }
        }

        // Validate $entry
        // @todo details required

        // Validate $from;
        if (!empty($from)) {
            if (!$this->validator->validFrom($from, $to)) {
                throw new ValidationException('from', $from . '-' . $to);
            } else {
                $this->filters['filter[from]'] = $from;
            }
        }

        // Validate $location
        if (!empty($location)) {
            if (!is_array($location)) {
                throw new ValidationException('location', implode(' ', $title));
            } else {
                $location = array_unique($location);
                foreach ($location as $item) {
                    if (!$this->validator->validLocation($item)) {
                        throw new ValidationException('location', $item);
                    }
                }
                $this->filters['filter[location]'] = implode(',', $location);
            }
        }

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
            $this->filters['filter[tag]'] = implode(',', $tags);
        }

        // Validate $title;
        if (!empty($title)) {
            if (!is_array($title)) {
                throw new ValidationException('title', implode(' ', $title));
            } else {
                $title = array_unique($title);
                foreach ($title as $item) {
                    if (!$this->validator->validTitle($item)) {
                        throw new ValidationException('title', $item);
                    }
                }
                $this->filters['filter[title]'] = implode(',', $title);
            }
        }

        // Validate $to;
        if (!empty($to)) {
            if (!$this->validator->validTo($to, $from)) {
                throw new ValidationException('to', $to . '-' . $from);
            } else {
                $this->filters['filter[to]'] = $to;
            }
        }

        // Validate $includeTickets;
        if (!$this->validator->validInclude($includeLocation)) {
            throw new ValidationException('includeLocation', $includeLocation);
        }
        if ($includeLocation) {
            array_push($this->includes, 'location');
        }

        // Validate $includeTickets;
        if (!$this->validator->validInclude($includeTickets)) {
            throw new ValidationException('includeTickets', $includeTickets);
        }

        if ($includeTickets) {
            array_push($this->includes, 'tickets');
        }

        // Validate $includeTicketsEvents;
        if (!$this->validator->validInclude($includeTicketsEvents)) {
            throw new ValidationException('includeTicketsEvents', $includeTicketsEvents);
        }

        if ($includeTicketsEvents) {
            array_push($this->includes, 'tickets.events');
        }

        // Validate $includeTicketsClassPasses;
        if (!$this->validator->validInclude($includeTicketsClassPasses)) {
            throw new ValidationException('includeTicketsClassPasses', $includeTicketsClassPasses);
        }

        if ($includeTicketsClassPasses) {
            array_push($this->includes, 'tickets.class_passes');
        }

        $events = $this->client->events()->list(array_merge($this->filters, ['include' => implode(',', $this->includes)]));

        foreach ($events->data as $event) {

            $eventTickets = [];
            foreach ($event->tickets as $ticket) {
                array_push($eventTickets, new Ticket(
                    $ticket->available,
                    $ticket->availableFrom,
                    $ticket->availableTo,
                    $ticket->builtBasketUrl,
                    $ticket->builtBasketIframeUrl,
                    $ticket->cost,
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

            array_push($this->events, new Event(
                $event->allDay,
                $event->attachments,
                $event->attendeeCount,
                $event->attendeeLimit,
                $event->details,
                $event->endAt,
                $event->id,
                new Location(
                    $event->location->additionalInfo,
                    $event->location->addressText,
                    $event->location->id,
                    $event->location->latitude,
                    $event->location->longitude,
                    $event->location->mapUrl,
                    $event->location->zoom
                ),
                $event->maxTicketsPerBooking,
                $event->startAt,
                $eventTickets,
                $event->title,
                $event->waitingList
            ));
        }

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
            $event->location->additionalInfo,
            $event->location->addressText,
            $location->id,
            $location->latitude,
            $location->longitude,
            $location->mapUrl,
            $location->zoom
        );
    }

    /**
     *
     */
    public function locations(
        null | string $addressText = null,
        null | string $additionalInfo = null
    ): array {

        // $this->logger->debug(__METHOD__ . '(' . var_export(func_get_args(), true) . ')');

        if (!empty($additionalInfo)) {
            if (!$this->validator->validAdditionalInfo($additionalInfo, 'additionalInfo')) {
                throw new ValidationException('additionalInfo', $additionalInfo);
            }
            $this->filters['filter[additional_info]'] = $additionalInfo;
        }

        if (!empty($addressText)) {
            if (!$this->validator->validAddressText($addressText, 'addressText')) {
                throw new ValidationException('addressText', $addressText);
            }
            $this->filters['filter[address_text]'] = $addressText;
        }

        $locations = $this->client->locations()->list($this->filters);

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
        $this->logLevel = $level;
    }

    /**
     * {@inheritDoc}
     * @see \InShore\Bookwhen\Interfaces\BookWhenInterface::ticket()
     * class_passes
     */
    public function ticket(
        string $ticketId,
        bool $includeClassPasses = false,
        bool $includeEvents = false,
        bool $includeEventsAttachments = false,
        bool $includeEventsLocation = false,
        bool $includeEventsTickets = false
    ): Ticket {

        // ticketId
        if (!$this->validator->validId($ticketId, 'ticket')) {
            throw new ValidationException('ticketId', $ticketId);
        }

        // Validate $includeClassPasses;
        if (!$this->validator->validInclude($includeClassPasses)) {
            throw new ValidationException('includeClassPasses', $includeClassPasses);
        }

        if ($includeClassPasses) {
            array_push($this->includes, 'class_passes');
        }

        // Validate $includeEvents;
        if (!$this->validator->validInclude($includeEvents)) {
            throw new ValidationException('includeEvents', $includeEvents);
        }
        if ($includeEvents) {
            array_push($this->includes, 'events');
        }

        // Validate $includeAttachments;
        if (!$this->validator->validInclude($includeEventsAttachments)) {
            throw new ValidationException('includeEventssAttachments', $includeEventsAttachments);
        }
        if ($includeEventsAttachments) {
            array_push($this->includes, 'events.attachments');
        }

        // Validate $includeEventsLocation;
        if (!$this->validator->validInclude($includeEventsLocation)) {
            throw new ValidationException('includeEventsLocation', $includeEventsLocation);
        }
        if ($includeEventsLocation) {
            array_push($this->includes, 'events.location');
        }

        // Validate $includeEventsTickets;
        if (!$this->validator->validInclude($includeEventsTickets)) {
            throw new ValidationException('includeEventsTickets', $includeEventsTickets);
        }
        if ($includeEventsTickets) {
            array_push($this->includes, 'events.tickets');
        }

        $ticket = $this->client->tickets()->retrieve($ticketId);
        return $this->ticket = new Ticket(
            $ticket->available,
            $ticket->availableFrom,
            $ticket->availableTo,
            $ticket->builtBasketUrl,
            $ticket->builtBasketIframeUrl,
            $ticket->cost,
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
    public function tickets(
        string $eventId,
        bool $includeClassPasses = false,
        bool $includeEvents = false,
        bool $includeEventsAttachments = false,
        bool $includeEventsLocation = false,
        bool $includeEventsTickets = false
    ): array {

        // $this->logger->debug(__METHOD__ . '(' . var_export(func_get_args(), true) . ')');

        if (!$this->validator->validId($eventId, 'event')) {
            throw new ValidationException('eventId', $eventId);
        }

        // Validate $includeClassPasses;
        if (!$this->validator->validInclude($includeClassPasses)) {
            throw new ValidationException('includeClassPasses', $includeClassPasses);
        }

        if ($includeClassPasses) {
            array_push($this->includes, 'class_passes');
        }

        // Validate $includeEvents;
        if (!$this->validator->validInclude($includeEvents)) {
            throw new ValidationException('includeEvents', $includeEvents);
        }

        if ($includeEvents) {
            array_push($this->includes, 'events');
        }

        // Validate $includeAttachments;
        if (!$this->validator->validInclude($includeEventsAttachments)) {
            throw new ValidationException('includeEventssAttachments', $includeEventsAttachments);
        }

        if ($includeEventsAttachments) {
            array_push($this->includes, 'events.attachments');
        }

        // Validate $includeEventsLocation;
        if (!$this->validator->validInclude($includeEventsLocation)) {
            throw new ValidationException('includeEventsLocation', $includeEventsLocation);
        }

        if ($includeEventsLocation) {
            array_push($this->includes, 'events.location');
        }

        // Validate $includeEventsTickets;
        if (!$this->validator->validInclude($includeEventsTickets)) {
            throw new ValidationException('includeEventsTickets', $includeEventsTickets);
        }

        if ($includeEventsTickets) {
            array_push($this->includes, 'events.tickets');
        }

        $tickets = $this->client->tickets()->list(array_merge(['event_id' => $eventId], ['include' => implode(',', $this->includes)]));

        foreach ($tickets->data as $ticket) {
            array_push($this->tickets, new Ticket(
                $ticket->available,
                $ticket->availableFrom,
                $ticket->availableTo,
                $ticket->builtBasketUrl,
                $ticket->builtBasketIframeUrl,
                $ticket->cost,
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
