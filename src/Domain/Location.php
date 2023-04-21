<?php

declare(strict_types=1);

namespace InShore\Bookwhen\Domain;

final class Location
{
    /**
     *
     */
    public function __construct(
        public readonly string $addressText,
        public readonly string $additionalInfo,
        public readonly string $id,
        public readonly float $latittude,
        public readonly float $longitude,
        public readonly string $mapUrl,
        public readonly int $zoom
    ) {
    }
}
