<?php

declare(strict_types=1);

namespace InShore\Bookwhen\Transporters;

use Closure;
use JsonException;
use InShore\Bookwhen\Contracts\TransporterContract;
use InShore\Bookwhen\Exceptions\ErrorException;
use InShore\Bookwhen\Exceptions\TransporterException;
use InShore\Bookwhen\Exceptions\UnserializableResponse;
use InShore\Bookwhen\ValueObjects\Transporter\BaseUri;
use InShore\Bookwhen\ValueObjects\Transporter\Headers;
use InShore\Bookwhen\ValueObjects\Transporter\Payload;
use InShore\Bookwhen\ValueObjects\Transporter\QueryParams;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * @internal
 */
final class HttpTransporter implements TransporterContract
{
    /**
     * Creates a new Http Transporter instance.
     */
    public function __construct(
        private readonly ClientInterface $client,
        private readonly BaseUri $baseUri,
        private readonly Headers $headers,
        private readonly QueryParams $queryParams,
        private readonly Closure $streamHandler,
    ) {
        // ..
    }

    /**
     * {@inheritDoc}
     */
    public function requestObject(Payload $payload): array|string
    {
        $request = $payload->toRequest($this->baseUri, $this->headers, $this->queryParams);

        try {
            $response = $this->client->sendRequest($request);
        } catch (ClientExceptionInterface $clientException) {
            throw new TransporterException($clientException);
        }

        $contents = (string) $response->getBody();

        if ($response->getHeader('Content-Type')[0] === 'text/plain; charset=utf-8') {
            return $contents;
        }

        try {
            /** @var array{error?: array{message: string, type: string, code: string}} $response */
            $response = json_decode($contents, true, 512, JSON_THROW_ON_ERROR)['data']; // @todo confirm for all reseources
        } catch (JsonException $jsonException) {
            throw new UnserializableResponse($jsonException);
        }

        if (isset($response['error'])) {
            throw new ErrorException($response['error']);
        }

        return $response;
    }

    /**
     * {@inheritDoc}
     */
    public function requestContent(Payload $payload): string
    {
        $request = $payload->toRequest($this->baseUri, $this->headers, $this->queryParams);

        try {
            $response = $this->client->sendRequest($request);
        } catch (ClientExceptionInterface $clientException) {
            throw new TransporterException($clientException);
        }

        $contents = $response->getBody()->getContents();

        try {
            /** @var array{error?: array{message: string, type: string, code: string}} $response */
            $response = json_decode($contents, true, 512, JSON_THROW_ON_ERROR);

            if (isset($response['error'])) {
                throw new ErrorException($response['error']);
            }
        } catch (JsonException) {
            // ..
        }

        return $contents;
    }

    /**
     * {@inheritDoc}
     */
    public function requestStream(Payload $payload): ResponseInterface
    {
        $request = $payload->toRequest($this->baseUri, $this->headers, $this->queryParams);

        try {
            $response = ($this->streamHandler)($request);
        } catch (ClientExceptionInterface $clientException) {
            throw new TransporterException($clientException);
        }

        return $response;
    }
}