<?php

declare(strict_types=1);

namespace InShore\Bookwhen\Responses\Locations;

use InShore\Bookwhen\Contracts\ResponseContract;
use InShore\Bookwhen\Responses\Concerns\ArrayAccessible;
//use OpenAI\Testing\Responses\Concerns\Fakeable;

/**
 * @implements ResponseContract<array{id: string, object: string, created_at: int, bytes: int, filename: string, purpose: string, status: string, status_details: array<array-key, mixed>|string|null}>
 */
final class RetrieveResponse implements ResponseContract
{
    /**
     * @use ArrayAccessible<array{id: string, object: string, created_at: int, bytes: int, filename: string, purpose: string, status: string, status_details: array<array-key, mixed>|string|null}>
     */
    use ArrayAccessible;

    //use Fakeable;

    /**
     * @param  array<array-key, mixed>|null  $statusDetails
     */
    private function __construct(
        public readonly string $addressText,
        public readonly string $additionalInfo,
        public readonly string $id,
        public readonly float $latitude,
        public readonly float $longitude,
        public readonly string $mapUrl,
        public readonly int $zoom
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
            $attributes['attributes']['address_text'],
            $attributes['attributes']['additional_info'],
            $attributes['id'],
            $attributes['attributes']['latitude'],
            $attributes['attributes']['longitude'],
            $attributes['attributes']['map_url'],
            $attributes['attributes']['zoom']
        );
    }

    /**
     * {@inheritDoc}
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'type' => $this->type,
            //'attributes' => $this->attributes,
        ];
    }
}
