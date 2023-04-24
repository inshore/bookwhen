<?php

declare(strict_types=1);

namespace InShore\Bookwhen\Domain;

use InShore\Bookwhen\Domain\Attachment;

final class Attachment
{
    /**
     *
     *
     */
    public function __construct(
        public readonly string $contentType,
        public readonly string $fileUrl,
        public readonly string $fileSizeBytes,
        public readonly string $fileSizeText,
        public readonly string $fileName,
        public readonly string $fileType,
        public readonly string $id,
        public readonly Location $location,
        public readonly int $maxTicketsPerBooking,
        public readonly string $startAt,
        public array $tickets,
        public readonly string $title,
        public readonly bool $waitingList
    ) {
    }
}
