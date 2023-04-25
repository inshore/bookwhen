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
        public readonly null | string $contentType,
        public readonly null | string $fileUrl,
        public readonly null | string $fileSizeBytes,
        public readonly null | string $fileSizeText,
        public readonly null | string $fileName,
        public readonly null | string $fileType,
        public readonly string $id
    ) {
    }
}
