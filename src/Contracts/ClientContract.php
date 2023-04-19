<?php

namespace InShore\Bookwhen\Contracts;

use InShore\Bookwhen\Resources\EventsContract;

interface ClientContract
{
    /**
     * @todo ref the api documents
     */
    public function events(): EventsContract;
}