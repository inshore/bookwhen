<?php

declare(strict_types=1);

namespace InShore\Bookwhen\Responses\Attachments;

use InShore\Bookwhen\Contracts\ResponseContract;

/**
 * @implements ResponseContract<array{id: string, object: string, created_at: int, bytes: int, filename: string, purpose: string, status: string, status_details: array<array-key, mixed>|string|null}>
 */
final class RetrieveResponse implements ResponseContract
{
    /**
     * @param  array<array-key, mixed>|null  $statusDetails
     */
    private function __construct(
        public readonly null | string $contentType,
        public readonly null | string $fileName,
        public readonly null | string $fileSizeBytes,
        public readonly null | string $fileSizeText,
        public readonly null | string $fileType,
        public readonly null | string $fileUrl,
        public readonly string $id,
        public readonly null | string $title
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
            $attributes['attributes']['content_type'] ?? null,
            $attributes['attributes']['file_name'] ?? null,
            $attributes['attributes']['file_size_bytes'] ?? null,
            $attributes['attributes']['file_size_text'] ?? null,
            $attributes['attributes']['file_type'] ?? null,
            $attributes['attributes']['file_url'] ?? null,
            $attributes['id'],
            $attributes['attributes']['title'] ?? null,
        );
    }
}
