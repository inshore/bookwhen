<?php

declare(strict_types=1);

namespace InShore\Bookwhen\Responses\Attachments;

use InShore\Bookwhen\Contracts\ResponseContract;
use InShore\Bookwhen\Responses\Concerns\ArrayAccessible;

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
            $attributes['attributes']['content_type'],
            $attributes['attributes']['file_name'],
            $attributes['attributes']['file_size_bytes'],
            $attributes['attributes']['file_size_text'],
            $attributes['attributes']['file_type'],
            $attributes['attributes']['file_url'],
            $attributes['id'],
            $attributes['attributes']['title']
        );
    }
}
