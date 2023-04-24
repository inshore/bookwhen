<?php

namespace InShore\Bookwhen\Contracts\Resources;

use InShore\Bookwhen\Responses\Tickets\TicketResponse;
use InShore\Bookwhen\Responses\Tickets\TicketsResponse;

interface TicketsContract
{
    /**
     */
    public function ticket(array $parameters): TicketResponse;

    /**
     */
    public function tickets(array $parameters): TicketsResponse;
}
