<?php

namespace InShore\Bookwhen\Contracts;

use InShore\Bookwhen\ContractsResources\AttachmentsContract;
use InShore\Bookwhen\ContractsResources\ClassPassesContract;
use InShore\Bookwhen\ContractsResources\EventsContract;
use InShore\Bookwhen\ContractsResources\LocationContract;
use InShore\Bookwhen\ContractsResources\TicketssContract;

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
