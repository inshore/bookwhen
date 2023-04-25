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
        public readonly bool | null $available,
        public readonly null | string $availableFrom,
        public readonly null | string $availableTo,
        public readonly null | string $builtBasketUrl,
        public readonly null | string $builtBasketIframeUrl,
        public readonly bool | null $courseTicket,
        // cost
        public readonly null | string $details,
        public readonly bool | null $groupTicket,
        public readonly int | null $groupMin,
        public readonly int | null $groupMax,
        public readonly string $id,
        public readonly int | null $numberIssued,
        public readonly int | null $numberTaken,
        public readonly null | string $title
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
            $attributes['attributes']['available'],
            $attributes['attributes']['available_from'],
            $attributes['attributes']['available_to'],
            $attributes['attributes']['built_basket_url'],
            $attributes['attributes']['built_basket_iframe_url'],
            $attributes['attributes']['course_ticket'],
            $attributes['attributes']['details'],
            $attributes['attributes']['group_ticket'],
            $attributes['attributes']['group_min'],
            $attributes['attributes']['group_max'],
            $attributes['id'],
            $attributes['attributes']['number_issued'],
            $attributes['attributes']['number_taken'],
            $attributes['attributes']['title']
        );
    }
}
