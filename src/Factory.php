<?php

declare(strict_types=1);

namespace InShore\Bookwhen;

use Http\Discovery\Psr18ClientDiscovery;
use InShore\Bookwhen\Transporters\HttpTransporter;
use InShore\Bookwhen\ValueObjects\ApiKey;
use InShore\Bookwhen\ValueObjects\Transporter\BaseUri;
use InShore\Bookwhen\ValueObjects\Transporter\Headers;
use InShore\Bookwhen\ValueObjects\Transporter\QueryParams;
use Psr\Http\Client\ClientInterface;

/**
 * Fluent factory to build a configured Bookwhen Client.
 */
final class Factory
{
    private ?string $apiKey = null;

    private ?ClientInterface $httpClient = null;

    private ?string $baseUri = null;

    /**
     * Custom query parameters for requests.
     *
     * @var array<string, string|int>
     */
    private array $queryParams = [];

    /**
     * Set the API key for requests.
     *
     * @return $this
     */
    public function withApiKey(string $apiKey): self
    {
        $this->apiKey = trim($apiKey);

        return $this;
    }

    /**
     * Set the base URI. If not set, the default Bookwhen API v2 base is used.
     *
     * @return $this
     */
    public function withBaseUri(string $baseUri): self
    {
        $this->baseUri = $baseUri;

        return $this;
    }

    /**
     * Set the PSR-18 HTTP client. If not set, one is discovered via php-http/discovery.
     *
     * @return $this
     */
    public function withHttpClient(ClientInterface $client): self
    {
        $this->httpClient = $client;

        return $this;
    }

    /**
     * Add a query parameter to request URLs.
     *
     * @return $this
     */
    public function withQueryParam(string $name, string $value): self
    {
        $this->queryParams[$name] = $value;

        return $this;
    }

    /**
     * Build and return a Bookwhen Client.
     *
     * @return Client
     */
    public function make(): Client
    {
        $headers = Headers::create();

        if (null !== $this->apiKey) {
            $headers = Headers::withAuthorization(ApiKey::from($this->apiKey));
        }

        $baseUri = BaseUri::from($this->baseUri ?? 'api.bookwhen.com/v2');

        $queryParams = QueryParams::create();
        foreach ($this->queryParams as $name => $value) {
            $queryParams = $queryParams->withParam($name, $value);
        }

        $client = $this->httpClient ??= Psr18ClientDiscovery::find();

        $transporter = new HttpTransporter($client, $baseUri, $headers, $queryParams);

        return new Client($transporter);
    }
}
