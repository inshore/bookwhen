<?php

require 'vendor/autoload.php';

use GuzzleHttp\Client;

// require 'vendor/autoload.php';

// use GuzzleHttp\Client;

// $client = new Client([
//     'base_uri' => 'http://www.google.com',
// ]);

// $response = $client->request('GET', 'search', [
//     'query' => ['q' => 'curl']
// ]);

// echo $response->getBody();

/**
 * Class Diffbot
 *
 * The main class for API consumption
 *
 * @package Swader\Diffbot
 */
class BookNowClient
{
    /** @var string The API access token */
    private static $token = null;

    /** @var string The instance token, settable once per new instance */
    private $instanceToken;

    /**
     * @param string|null $token The API access token, as obtained on diffbot.com/dev
     * @throws DiffbotException When no token is provided
     */
    public function __construct($token = null)
    {
        if ($token === null) {
            if (self::$token === null) {
                $msg = 'No token provided, and none is globally set. ';
                $msg .= 'Use Diffbot::setToken, or instantiate the Diffbot class with a $token parameter.';
                throw new DiffbotException($msg);
            }
        } else {
            self::validateToken($token);
            $this->instanceToken = $token;
        }
    }

    /**
     * Sets the token for all future new instances
     * @param $token string The API access token, as obtained on diffbot.com/dev
     * @return void
     */
    public static function setToken($token)
    {
        self::validateToken($token);
        self::$token = $token;
    }

    private static function validateToken($token)
    {
        if (!is_string($token)) {
            throw new \InvalidArgumentException('Token is not a string.');
        }
        if (strlen($token) < 4) {
            throw new \InvalidArgumentException('Token "' . $token . '" is too short, and thus invalid.');
        }
        return true;
    }

    public function getEvents($eventId)
    {
        $client = new GuzzleHttp\Client(['base_uri' => 'https://api.bookwhen.com']);
        $response = $client->request('GET', "/v2/events/$eventId", [
            'auth' => ['username', 'password'],
        ]);

    }

    public function locations($locationId) 
    {
        $client = new GuzzleHttp\Client(['base_uri' => 'https://api.bookwhen.com']);
        $response = $client->request('GET', "/v2/locations/$locationId", [
            'auth' => ['username', 'password'],
        ]);
    }
    
}
