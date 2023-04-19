<?php

namespace InShore\Bookwhen\Contracts;

use InShore\Bookwhen\Resources\TicketsContract;

interface ClientContract
{
    /**
     * @todo ref the api documents
     */
    public function tickets(): TicketsContract;
}