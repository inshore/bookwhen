<?php

declare(strict_types=1);

namespace InShore\Bookwhen\Contracts;

use InShore\Bookwhen\Exceptions\ErrorException;
use InShore\Bookwhen\Exceptions\TransporterException;
use InShore\Bookwhen\Exceptions\UnserializableResponse;
use InShore\Bookwhen\ValueObjects\Transporter\Payload;
use Psr\Http\Message\ResponseInterface;

/**
 * @internal
 */
interface TransporterContract
{
    /**
     * Sends a request to a server.
     **
     * @return array<array-key, mixed>
     *
     * @throws ErrorException|UnserializableResponse|TransporterException
     */
    public function requestObject(Payload $payload): array | string;

    /**
     * Sends a content request to a server.
     *
     * @throws ErrorException|TransporterException
     */
    public function requestContent(Payload $payload): string;

    /**
     * Sends a stream request to a server.
     **
     * @throws ErrorException
     */
    public function requestStream(Payload $payload): ResponseInterface;
}
