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
        public readonly bool $available,
        public readonly null | string $availableFrom,
        public readonly null | string $availableTo,
        public readonly string $builtBasketUrl,
        public readonly string $builtBasketIframeUrl,
        public readonly bool $courseTicket,
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
}
