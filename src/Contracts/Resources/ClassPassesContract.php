<?php

namespace InShore\Bookwhen\Contracts\Resources;

use InShore\Bookwhen\Responses\ClassPasses\ListResponse;
use InShore\Bookwhen\Responses\ClassPasses\RetrieveResponse;

interface ClassPassesContract
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
    public function retrieve(string $classPassId): RetrieveResponse;
}
