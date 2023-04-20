<?php

declare(strict_types=1);

namespace InShore\Bookwhen;

use InShore\Bookwhen\BookwhenApi;
use InShore\Bookwhen\Domain\Event;

final class Bookwhen
{
    private $client = null;
    
    /**
     * 
     * @var unknown
     */
    public Event $event;
    
    public $locations = [];
    public $location = null;

    /**
     * Creates a new Bookwhen Client with the given API token.
     */
    public function __construct() {
        $this->client = BookwhenApi::client($_ENV['INSHORE_BOOKWHEN_API_KEY']);
    }

    public function event($eventId) {
        $event = $this->client->events()->retrieve('ev-s4dt-20230421130000');      
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
        
        return $this->event;
    }
}
