<?php

namespace InShore\Bookwhen\Contracts\Resources;

use InShore\Bookwhen\Responses\Attachments\ListResponse;
use InShore\Bookwhen\Responses\Attachments\RetrieveResponse;

interface AttachmentsContract
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
    public function retrieve(string $attachmentId): RetrieveResponse;
}
