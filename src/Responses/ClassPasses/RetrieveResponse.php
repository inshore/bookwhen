<?php

declare(strict_types=1);

namespace InShore\Bookwhen\Responses\ClassPasses;

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
,



    'cost' =>
    array (
      'currency_code' => 'GBP',
      'net' => 3500,
      'tax' => 0,
    ),
     */
    private function __construct(
        public readonly null | string $details,
        public readonly string $id,
        public readonly int | null $numberAvailable,
        public readonly null | string $title,
        public readonly int | null $usageAllowance,
        public readonly null | string $usageType,
        public readonly int | null $useRestrictedForDays,
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
            $attributes['attributes']['details'],
            $attributes['id'],
            $attributes['attributes']['number_available'],
            $attributes['attributes']['title'],
            $attributes['attributes']['usage_allowance'],
            $attributes['attributes']['usage_type'],
            $attributes['attributes']['use_restricted_for_days'],
        );
    }
}
