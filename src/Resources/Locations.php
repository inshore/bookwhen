<?php

declare(strict_types=1);

namespace InShore\Bookwhen\Resources;

use InShore\Bookwhen\Contracts\Resources\LocationsContract;
use InShore\Bookwhen\Responses\Locations\ListResponse;
use InShore\Bookwhen\Responses\Locations\RetrieveResponse;
use InShore\Bookwhen\ValueObjects\Transporter\Payload;

final class Locations implements LocationsContract
{
    use Concerns\Transportable;

    /**
     * Returns a list of files that belong to the user's organization.
     *
     * @see https://beta.openai.com/docs/api-reference/files/list
     */
    public function list(): ListResponse
    {
        $payload = Payload::list('locations');

        /** @var array{object: string, data: array<int, array{id: string, object: string, created_at: int, bytes: int, filename: string, purpose: string, status: string, status_details: array<array-key, mixed>|string|null}>} $result */
        $result = $this->transporter->requestObject($payload);

        return ListResponse::from($result);
    }

    /**
     * Returns information about a specific file.
     *
     * @see https://beta.openai.com/docs/api-reference/files/retrieve
     */
    public function retrieve(string $eventId): RetrieveResponse
    {
        $payload = Payload::retrieve('locations', $eventId);

        /** @var array{id: string, object: string, created_at: int, bytes: int, filename: string, purpose: string, status: string, status_details: array<array-key, mixed>|string|null} $result */
        $result = $this->transporter->requestObject($payload);

        return RetrieveResponse::from($result);
    }
}
