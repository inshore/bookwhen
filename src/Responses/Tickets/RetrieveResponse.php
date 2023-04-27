<?php

declare(strict_types=1);

namespace InShore\Bookwhen\Responses\Tickets;

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
        public readonly object $cost,
        public readonly bool | null $courseTicket,
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

        $cost = new \stdClass();
        if (!empty($attributes['attributes']['cost'])) {
            $cost->currencyCode = $attributes['attributes']['cost']['currency_code'];
            $cost->net = $attributes['attributes']['cost']['net'];
            $cost->tax = $attributes['attributes']['cost']['tax'];
        }

        return new self(
            $attributes['attributes']['available'] ?? null,
            $attributes['attributes']['available_from'] ?? null,
            $attributes['attributes']['available_to'] ?? null,
            $attributes['attributes']['built_basket_url'] ?? null,
            $attributes['attributes']['built_basket_iframe_url'] ?? null,
            $cost,
            $attributes['attributes']['course_ticket'] ?? null,
            $attributes['attributes']['details'] ?? null,
            $attributes['attributes']['group_ticket'] ?? null,
            $attributes['attributes']['group_min'] ?? null,
            $attributes['attributes']['group_max'] ?? null,
            $attributes['id'],
            $attributes['attributes']['number_issued'] ?? null,
            $attributes['attributes']['number_taken'] ?? null,
            $attributes['attributes']['title'] ?? null,
        );
    }
}
