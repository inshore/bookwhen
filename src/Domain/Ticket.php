<?php

declare(strict_types=1);

namespace InShore\Bookwhen\Domain;

use InShore\Bookwhen\Domain\Event;

final class Ticket
{
    /**
     *
     */
    public function __construct(
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
}
