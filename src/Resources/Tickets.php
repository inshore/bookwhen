<?php

declare(strict_types=1);

namespace InShore\Bookwhen\Resources;

use InShore\Bookwhen\Contracts\Resources\TicketsContract;
use InShore\Bookwhen\Responses\Tickets\ListResponse;
use InShore\Bookwhen\Responses\Tickets\RetrieveResponse;
use InShore\Bookwhen\ValueObjects\Transporter\Payload;

final class Tickets implements TicketsContract
{
    use Concerns\Transportable;

    /**
     * Returns a list of files that belong to the user's organization.
     *
     * @see https://beta.openai.com/docs/api-reference/files/list
     */
    public function list(array $parameters): ListResponse // @todo change
    {
        $payload = Payload::list('tickets', $parameters);

        /** @var array{object: string, data: array<int, array{id: string, object: string, created_at: int, bytes: int, filename: string, purpose: string, status: string, status_details: array<array-key, mixed>|string|null}>} $result */
        $result = $this->transporter->requestObject($payload);

        if(!array_key_exists('included', $result)) {
            return ListResponse::from($result);
        } else {
            return ListResponse::from($result, $result['included']);
        }
    }

    /**
     * Returns information about a specific file.
     *
     * @see https://beta.openai.com/docs/api-reference/files/retrieve
     */
    public function retrieve(string $ticketId): RetrieveResponse
    {
        $payload = Payload::retrieve('tickets', $ticketId);

        /** @var array{id: string, object: string, created_at: int, bytes: int, filename: string, purpose: string, status: string, status_details: array<array-key, mixed>|string|null} $result */
        $result = $this->transporter->requestObject($payload);

        if(!array_key_exists('included', $result)) {
            return RetrieveResponse::from($result['data']);
        } else {
            return RetrieveResponse::from($result['data'], $result['included']);
        }
    }
}
