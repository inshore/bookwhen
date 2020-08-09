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
    
    protected $mockHandler;
    
    public function setUp(): void
    {
        $this->mockHandler = new MockHandler();
        
        $this->guzzleClient = new GuzzleClient([
            'handler' => $this->mockHandler,
        ]);
        
        $this->client = new Client('6v47r0jdz3r2ao3yc8f1vyx2kjry');
    }
    
    /**
     * Test that true does in fact equal true
     */
    public function testGetEventWithValidEventId()
    { 
        $this->mockHandler->append(new Response('200', [], file_get_contents(__DIR__ . '/fixtures/event_200.json')));
        $this->client->setGuzzleClient($this->guzzleClient);
        $event = $this->client->getEvent('ev-sf8b-20200813100000');
        $this->assertFalse($event->soldOut, 'Not sold Out');
    }
    
    /**
     * Test that true does in fact equal true
     */
    public function testGetTicketsWithValidEventId()
    {
        $this->mockHandler->append(new Response('200', [], file_get_contents(__DIR__ . '/fixtures/tickets_200.json')));
        $this->client->setGuzzleClient($this->guzzleClient);
        $tickets = $this->client->getTickets('ev-sf8b-20200813100000');
        var_export($tickets);
        die();
    }
}

// EOF!
