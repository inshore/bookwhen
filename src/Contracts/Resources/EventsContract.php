<?php

namespace InShore\Bookwhen\Contracts\Resources;

use InShore\Bookwhen\Responses\Events\ListResponse;
use InShore\Bookwhen\Responses\Events\RetrieveResponse;

interface EventsContract
{
    /**
     * Returns a list of events that belong to the user's organization.
     *
     * @see https://
     */
    public function list(array $parameters): ListResponse;

    /**
     * Returns information about a specific event.
     *
     * @see https://
     */
    public function retrieve(string $eventId, array $parameters): RetrieveResponse;
}
