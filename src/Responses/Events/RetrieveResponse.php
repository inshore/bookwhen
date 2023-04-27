<?php

declare(strict_types=1);

namespace InShore\Bookwhen\Responses\Events;

use InShore\Bookwhen\Contracts\ResponseContract;
use InShore\Bookwhen\Responses\Concerns\ArrayAccessible;
use InShore\Bookwhen\Responses\Locations\RetrieveResponse as LocationsRetrieveResponse;
use InShore\Bookwhen\Responses\Tickets\RetrieveResponse as TicketsRetrieveResponse;

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
        public readonly bool $allDay,
        public readonly array $attachments,
        public readonly int $attendeeCount,
        public readonly int $attendeeLimit,
        public readonly string $details,
        public readonly string $endAt,
        public readonly string $id,
        public readonly \InShore\Bookwhen\Responses\Locations\RetrieveResponse $location,
        public readonly int $maxTicketsPerBooking,
        public readonly string $startAt,
        public readonly array $tickets,
        public readonly string $title,
        public readonly bool $waitingList
    ) {
    }

    /**
     * Acts as static factory, and returns a new Response instance.
     *
     * @param  array{id: string, object: string, created_at: int, bytes: int, filename: string, purpose: string, status: string, status_details: array<array-key, mixed>|string|null}  $attributes
     */
    public static function from(array $attributes, $included = []): self
    {
        // location
        $location = LocationsRetrieveResponse::from([
//             'attributes' => [
//                 'address_text' => null,
//                 'additional_info' => null,
//                 'latitude' => null,
//                 'longitude' => null,
//                 'map_url' => null,
//                 'zoom' => null
//             ],
            'id' => $attributes['relationships']['location']['data']['id']
        ]);

        // tickets
        $tickets = [];
        foreach ($attributes['relationships']['tickets']['data'] as $ticket) {
            array_push($tickets, TicketsRetrieveResponse::from([
                'id' => $ticket['id']
            ]));
        }

        if (!empty($included)) {
            foreach ($included as $includedData) {
                if ($includedData['type'] === 'location' && $includedData['id'] = $location->id) {
                    $location = LocationsRetrieveResponse::from($includedData);
                }
            }

            //tickets
            foreach ($tickets as $index => $ticket) {
                foreach ($included as $includedData) {
                    if ($includedData['type'] === 'ticket' && $includedData['id'] = $ticket->id) {
                        $tickets[$index] = TicketsRetrieveResponse::from($includedData);
                    }
                }
            }
        }

        return new self(
            $attributes['attributes']['all_day'],
            $attributes['relationships']['attachments']['data'],
            $attributes['attributes']['attendee_count'],
            $attributes['attributes']['attendee_limit'],
            $attributes['attributes']['details'],
            $attributes['attributes']['end_at'],
            $attributes['id'],
            $location,
            $attributes['attributes']['max_tickets_per_booking'],
            $attributes['attributes']['start_at'],
            $tickets,
            $attributes['attributes']['title'],
            $attributes['attributes']['waiting_list']
        );
    }
}
