<?php

namespace InShore\Bookwhen\Contracts\Resources;

use InShore\Bookwhen\Responses\Locations\ListResponse;
use InShore\Bookwhen\Responses\Locations\RetrieveResponse;

interface LocationsContract
{
    /**
     * Returns a list of events that belong to the user's organization.
     *
     * @see https://
     */
    public function list(): ListResponse;
    
    /**
     * Returns information about a specific event.
     *
     * @see https://
     */
    public function retrieve(string $eventId): RetrieveResponse;
}