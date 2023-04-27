<?php

declare(strict_types=1);

namespace InShore\Bookwhen\Domain;

final class Location
{
    /**
     *
     */
    public function __construct(
        public readonly null | string $addressText = null,
        public readonly null | string $additionalInfo = null,
        public readonly string $id,
        public readonly float | null $latitude = null,
        public readonly float | null $longitude = null,
        public readonly null | string $mapUrl = null,
        public readonly int | null $zoom = null
    ) {
    }
}
