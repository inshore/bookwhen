<?php

declare(strict_types=1);

namespace InShore\Bookwhen\Resources;

use InShore\Bookwhen\Contracts\Resources\EventsContract;
use InShore\Bookwhen\Responses\Events\ListResponse;
use InShore\Bookwhen\Responses\Events\RetrieveResponse;
use InShore\Bookwhen\ValueObjects\Transporter\Payload;

final class Files implements EventsContract
{
    use Concerns\Transportable;

    /**
     * Returns a list of files that belong to the user's organization.
     *
     * @see https://beta.openai.com/docs/api-reference/files/list
     */
    public function list(): ListResponse
    {
        $payload = Payload::list('events');

        /** @var array{object: string, data: array<int, array{id: string, object: string, created_at: int, bytes: int, filename: string, purpose: string, status: string, status_details: array<array-key, mixed>|string|null}>} $result */
        $result = $this->transporter->requestObject($payload);

        return ListResponse::from($result);
    }

    /**
     * Returns information about a specific file.
     *
     * @see https://beta.openai.com/docs/api-reference/files/retrieve
     */
    public function retrieve(string $file): RetrieveResponse
    {
        $payload = Payload::retrieve('events', $file);

        /** @var array{id: string, object: string, created_at: int, bytes: int, filename: string, purpose: string, status: string, status_details: array<array-key, mixed>|string|null} $result */
        $result = $this->transporter->requestObject($payload);

        return RetrieveResponse::from($result);
    }
}
