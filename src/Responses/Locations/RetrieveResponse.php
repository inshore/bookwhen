<?php

declare(strict_types=1);

namespace InShore\Bookwhen\Responses\Locations;

use InShore\Bookwhen\Contracts\ResponseContract;

/**
 * @implements ResponseContract<array{id: string, object: string, created_at: int, bytes: int, filename: string, purpose: string, status: string, status_details: array<array-key, mixed>|string|null}>
 */
final class RetrieveResponse implements ResponseContract
{
    /**
     * @param  array<array-key, mixed>|null  $statusDetails
     */
    private function __construct(
        public readonly null | string $additionalInfo,
        public readonly null | string $addressText,
        public readonly string $id,
        public readonly float | null $latitude,
        public readonly float | null $longitude,
        public readonly null | string $mapUrl,
        public readonly int | null $zoom
    ) {
    }

    /**
     * Acts as static factory, and returns a new Response instance.
     *
     * @param  array{id: string, object: string, created_at: int, bytes: int, filename: string, purpose: string, status: string, status_details: array<array-key, mixed>|string|null}  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            $attributes['attributes']['additional_info'] ?? null,
            $attributes['attributes']['address_text'] ?? null,
            $attributes['id'],
            $attributes['attributes']['latitude'] ?? null,
            $attributes['attributes']['longitude'] ?? null,
            $attributes['attributes']['map_url'] ?? null,
            $attributes['attributes']['zoom'] ?? null
        );
    }
}
