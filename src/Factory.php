<?php

namespace InShore\Bookwhen;

use Http\Discovery\Psr18ClientDiscovery;
use InShore\Bookwhen\Transporters\HttpTransporter;
use InShore\Bookwhen\ValueObjects\ApiKey;
use InShore\Bookwhen\ValueObjects\Transporter\BaseUri;
use InShore\Bookwhen\ValueObjects\Transporter\Headers;
use InShore\Bookwhen\ValueObjects\Transporter\QueryParams;
use Psr\Http\Client\ClientInterface;
use Symfony\Component\HttpClient\Psr18Client;

final class Factory
{
    /**
     * The API key for the requests.
     */
    private ?string $apiKey = null;

    /**
     * The HTTP client for the requests.
     */
    private ?ClientInterface $httpClient = null;

    /**
     * The base URI for the requests.
     */
    private ?string $baseUri = null;

    /**
     * The query parameters for the requests.
     *
     * @var array<string, string|int>
     */
    private array $queryParams = [];

    /**
     * Sets the API key for the requests.
     */
    public function withApiKey(string $apiKey): self
    {
        $this->apiKey = trim($apiKey);

        return $this;
    }

    /**
     * Sets the base URI for the requests.
     * If no URI is provided the factory will use the default OpenAI API URI.
     */
    public function withBaseUri(string $baseUri): self
    {
        $this->baseUri = $baseUri;

        return $this;
    }

    /**
     * Sets the HTTP client for the requests.
     * If no client is provided the factory will try to find one using PSR-18 HTTP Client Discovery.
     */
    public function withHttpClient(ClientInterface $client): self
    {
        $this->httpClient = $client;

        return $this;
    }

    /**
     * Adds a custom query parameter to the request url.
     */
    public function withQueryParam(string $name, string $value): self
    {
        $this->queryParams[$name] = $value;

        return $this;
    }

    /**
     * Creates a new Open AI Client.
     */
    public function make(): Client
    {
        $headers = Headers::create();

        if (null !== $this->apiKey) {
            $headers = Headers::withAuthorization(ApiKey::from($this->apiKey));
        }

        $baseUri = BaseUri::from($this->baseUri ?: 'api.bookwhen.com/v2');

        $queryParams = QueryParams::create();
        foreach ($this->queryParams as $name => $value) {
            $queryParams = $queryParams->withParam($name, $value);
        }

        $client = $this->httpClient ??= Psr18ClientDiscovery::find();

        $transporter = new HttpTransporter($client, $baseUri, $headers, $queryParams);

        return new Client($transporter);
    }
}
