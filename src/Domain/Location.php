<?php

declare(strict_types=1);

namespace InShore\Bookwhen\Domain;

/**
 * Immutable value object for a Bookwhen location.
 */
final class Location
{
    public function __construct(
        public readonly string $id,
        public readonly ?string $additionalInfo = null,
        public readonly ?string $addressText = null,
        public readonly ?float $latitude = null,
        public readonly ?float $longitude = null,
        public readonly ?string $mapUrl = null,
        public readonly ?int $zoom = null
    ) {
    }
}
