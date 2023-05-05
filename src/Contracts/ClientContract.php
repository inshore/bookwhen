<?php

namespace InShore\Bookwhen\Contracts;

use InShore\Bookwhen\Contracts\Resources\AttachmentsContract;
use InShore\Bookwhen\Contracts\Resources\ClassPassesContract;
use InShore\Bookwhen\Contracts\Resources\EventsContract;
use InShore\Bookwhen\Contracts\Resources\LocationsContract;
use InShore\Bookwhen\Contracts\Resources\TicketsContract;

interface ClientContract
{
    /**
     * @todo ref the api documents
     */
    public function attachments(): AttachmentsContract;

    /**
     * @todo ref the api documents
     */
    public function classPasses(): ClassPassesContract;

    /**
     * @todo ref the api documents
     */
    public function events(): EventsContract;

    /**
     * @todo ref the api documents
     */
    public function locations(): LocationsContract;

    /**
     * @todo ref the api documents
     */
    public function tickets(): TicketsContract;
}
