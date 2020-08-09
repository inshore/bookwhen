<?php

namespace InShore\BookWhen\Test;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\HandlerStack;
use InShore\BookWhen\Client;

class ClientTest extends \PHPUnit_Framework_TestCase
{
    
    protected $client;
    
    public function setUp(): void
    {
        $this->client = new Client('6v47r0jdz3r2ao3yc8f1vyx2kjry');
    }
    
    /**
     * Test that true does in fact equal true
     */
    public function testGetEventValidEventId()
    { 
        $mock = new MockHandler([
            new Response('200', [], '{}'),
        ]);
        $handlerStack = HandlerStack::create($mock);
        $guzzleClient = new GuzzleClient(['handler' => $handlerStack]);
        $this->client->setGuzzleClient($guzzleClient);
        $event = $this->client->getEvent('ev-sf8b-20200813100000');
        var_export($event);
        die();
        $this->assertInstanceOf('object', $event);
        $this->assertObjectHasAttribute('title', $event);
    }
}

// EOF!
