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
     * Returns a list of locations that belong to the user's organization.
     *
     * @see https://api.bookwhen.com/v2#tag/Location/paths/~1locations/get
     */
    public function list(array $parameters): ListResponse
    {
        $payload = Payload::list('locations', $parameters);

        /** @var array{object: string, data: array<int, array{id: string, object: string, created_at: int, bytes: int, filename: string, purpose: string, status: string, status_details: array<array-key, mixed>|string|null}>} $result */
        $result = $this->transporter->requestObject($payload);

        return ListResponse::from($result);
    }

    /**
     * Returns information about a specific location.
     *
     * @see https://api.bookwhen.com/v2#tag/Location/paths/~1locations~1%7Blocation_id%7D/get
     */
    public function retrieve(string $eventId): RetrieveResponse
    {
        $payload = Payload::retrieve('locations', $eventId);

        /** @var array{id: string, object: string, created_at: int, bytes: int, filename: string, purpose: string, status: string, status_details: array<array-key, mixed>|string|null} $result */
        $result = $this->transporter->requestObject($payload)['data'];

        return RetrieveResponse::from($result);
    }
}
