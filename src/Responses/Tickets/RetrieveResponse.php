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
        public readonly bool $available,
        public readonly null | string $availableFrom,
        public readonly null | string $availableTo,
        public readonly string $builtBasketUrl,
        public readonly string $builtBasketIframeUrl,
        public readonly bool $courseTicket,
        // cost
        public readonly string $details,
        public readonly bool $groupTicket,
        public readonly int $groupMin,
        public readonly int $groupMax,
        public readonly string $id,
        public readonly int | null $numberIssued,
        public readonly int $numberTaken,
        public readonly string $title
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
