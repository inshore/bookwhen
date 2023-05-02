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
     * Returns a list of class passes that belong to the user's organization.
     *
     * @see https://api.bookwhen.com/v2#tag/ClassPass/paths/~1class_passes/get
     */
    public function list(array $parameters): ListResponse
    {
        $payload = Payload::list('class_passes', $parameters);

        /** @var array{object: string, data: array<int, array{id: string, object: string, created_at: int, bytes: int, filename: string, purpose: string, status: string, status_details: array<array-key, mixed>|string|null}>} $result */
        $result = $this->transporter->requestObject($payload);

        return ListResponse::from($result);
    }

    /**
     * Returns information about a specific class pass.
     *
     * @see https://api.bookwhen.com/v2#tag/ClassPass/paths/~1class_passes~1%7Bclass_pass_id%7D/get
     */
    public function retrieve(string $classPassId): RetrieveResponse
    {
        $payload = Payload::retrieve('class_passes', $classPassId, []);

        /** @var array{id: string, object: string, created_at: int, bytes: int, filename: string, purpose: string, status: string, status_details: array<array-key, mixed>|string|null} $result */
        $result = $this->transporter->requestObject($payload)['data'];

        return RetrieveResponse::from($result);
    }
}
