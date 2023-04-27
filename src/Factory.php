<?php

namespace InShore\Bookwhen;

use Closure;
use Exception;
use GuzzleHttp\Client as GuzzleClient;
use Http\Discovery\Psr18ClientDiscovery;
use InShore\Bookwhen\Transporters\HttpTransporter;
use InShore\Bookwhen\ValueObjects\ApiKey;
use InShore\Bookwhen\ValueObjects\Transporter\BaseUri;
use InShore\Bookwhen\ValueObjects\Transporter\Headers;
use InShore\Bookwhen\ValueObjects\Transporter\QueryParams;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
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
     * The HTTP headers for the requests.
     *
     * @var array<string, string>
     */
    private array $headers = [];

    /**
     * The query parameters for the requests.
     *
     * @var array<string, string|int>
     */
    private array $queryParams = [];

    private ?Closure $streamHandler = null;

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

        if ($this->apiKey !== null) {
            $headers = Headers::withAuthorization(ApiKey::from($this->apiKey));
        }

        $baseUri = BaseUri::from($this->baseUri ?: 'api.bookwhen.com/v2');

        $queryParams = QueryParams::create();
        foreach ($this->queryParams as $name => $value) {
            $queryParams = $queryParams->withParam($name, $value);
        }

        $client = $this->httpClient ??= Psr18ClientDiscovery::find();

       // $sendAsync = $this->makeStreamHandler($client);

        $transporter = new HttpTransporter($client, $baseUri, $headers, $queryParams);

        return new Client($transporter);
    }
}
