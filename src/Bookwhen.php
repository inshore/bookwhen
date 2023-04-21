<?php

declare(strict_types=1);

namespace InShore\Bookwhen;

use InShore\Bookwhen\BookwhenApi;
use InShore\Bookwhen\Domain\Event;
use InShore\Bookwhen\Domain\Location;

final class Bookwhen
{
    private $client = null;

    /**
     *
     * @var unknown
     */
    public Event $event;

    public $locations = [];
    public readonly Location $location;

    /**
     * Creates a new Bookwhen Client with the given API token.
     */
    public function __construct()
    {
        $this->client = BookwhenApi::client($_ENV['INSHORE_BOOKWHEN_API_KEY']);
    }

    public function event($eventId)
    {
        //if($this->event === null || $this->event->id === null || $this->event->id !== $eventId) {
        $event = $this->client->events()->retrieve($eventId);
        $this->event = new Event(
            $event->allDay,
            $event->attendeeCount,
            $event->attendeeLimit,
            $event->details,
            $event->endAt,
            $event->id,
            $event->maxTicketsPerBooking,
            $event->startAt,
            $event->title,
            $event->waitingList
        );
        // }
        // Location
        $location = $this->client->locations()->retrieve($event->locationId);
        $this->event->location = new Location(
            $location->addressText,
            $location->additionalInfo,
            $location->id,
            $location->latitude,
            $location->longitude,
            $location->mapUrl,
            $location->zoom
        );

        return $this->event;
    }
}
