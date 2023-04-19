<?php

declare(strict_types=1);

namespace InShore\Bookwhen\ValueObjects\Transporter;

use InShore\Bookwhen\Contracts\StringableContract;

/**
 * @internal
 */
final class BaseUri implements StringableContract
{
    /**
     * Creates a new Base URI value object.
     */
    private function __construct(private readonly string $baseUri)
    {
        // ..
    }

    /**
     * Creates a new Base URI value object.
     */
    public static function from(string $baseUri): self
    {
        return new self($baseUri);
    }

    /**
     * {@inheritdoc}
     */
    public function toString(): string
    {
        return 'https://' . $this->baseUri . '/';
    }
}