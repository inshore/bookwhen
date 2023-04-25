<?php

declare(strict_types=1);

namespace InShore\Bookwhen\Domain;

use InShore\Bookwhen\Domain\Event;

final class ClassPass
{
    /**
     *
     */
    public function __construct(
        public readonly string $id,
    ) {
    }
}
