<?php

declare(strict_types=1);

namespace InShore\Bookwhen\Resources;

use InShore\Bookwhen\Contracts\Resources\ClassPassesContract;
use InShore\Bookwhen\Responses\ClassPasses\ListResponse;
use InShore\Bookwhen\Responses\ClassPasses\RetrieveResponse;
use InShore\Bookwhen\ValueObjects\Transporter\Payload;

final class ClassPasses implements ClassPassesContract
{
    use Concerns\Transportable;

    /**
     * Returns a list of files that belong to the user's organization.
     *
     * @see https://beta.openai.com/docs/api-reference/files/list
     */
    public function list(): ListResponse
    {
        $payload = Payload::list('class_passes');

        /** @var array{object: string, data: array<int, array{id: string, object: string, created_at: int, bytes: int, filename: string, purpose: string, status: string, status_details: array<array-key, mixed>|string|null}>} $result */
        $result = $this->transporter->requestObject($payload);


        return ListResponse::from($result);
    }

    /**
     * Returns information about a specific file.
     *
     * @see https://beta.openai.com/docs/api-reference/files/retrieve
     */
    public function retrieve(string $classPassId): RetrieveResponse
    {
        $payload = Payload::retrieve('class_passes', $classPassId, []);

        /** @var array{id: string, object: string, created_at: int, bytes: int, filename: string, purpose: string, status: string, status_details: array<array-key, mixed>|string|null} $result */
        $result = $this->transporter->requestObject($payload)['data'];

        return RetrieveResponse::from($result);
    }
}
