<?php

declare(strict_types=1);

namespace InShore\Bookwhen\Resources;

use InShore\Bookwhen\Contracts\Resources\EventsContract;
use InShore\Bookwhen\Responses\Events\ListResponse;
use InShore\Bookwhen\Responses\Events\RetrieveResponse;
use InShore\Bookwhen\ValueObjects\Transporter\Payload;

final class Events implements EventsContract
{
    use Concerns\Transportable;

    /**
     * Returns a list of files that belong to the user's organization.
     *
     * @see https://beta.openai.com/docs/api-reference/files/list
     */
    public function list(array $parameters): ListResponse
    {
        $payload = Payload::list('events', $parameters);

        /** @var array{object: string, data: array<int, array{id: string, object: string, created_at: int, bytes: int, filename: string, purpose: string, status: string, status_details: array<array-key, mixed>|string|null}>} $result */
        $result = $this->transporter->requestObject($payload);

        return ListResponse::from($result);
    }

    /**
     * Returns information about a specific file.
     *
     * @see https://beta.openai.com/docs/api-reference/files/retrieve
     */
    public function retrieve(string $eventId, array $parameters): RetrieveResponse
    {
        $payload = Payload::retrieve('events', $eventId, $parameters);

        /** @var array{id: string, object: string, created_at: int, bytes: int, filename: string, purpose: string, status: string, status_details: array<array-key, mixed>|string|null} $result */
        $result = $this->transporter->requestObject($payload);

        if (!array_key_exists('included', $result)) {
            return RetrieveResponse::from($result['data']);
        } else {
            return RetrieveResponse::from($result['data'], $result['included']);
        }
    }
}
