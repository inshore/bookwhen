<?php

namespace InShore\Bookwhen\Contracts\Resources;

use InShore\Bookwhen\Responses\ClassPasses\TicketResponse;
use InShore\Bookwhen\Responses\ClassPasses\TicketsResponse;

interface TicketsContract
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
    public function retrieve(string $classPassId): RetrieveResponse;
}
