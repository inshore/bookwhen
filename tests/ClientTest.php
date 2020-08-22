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
    public function testGetAttachments()
    {
        $this->mockHandler->append(new Response('200', [], file_get_contents(__DIR__ . '/fixtures/attachment_200.json')));
        $this->client->setGuzzleClient($this->guzzleClient);
        $attachments = $this->client->getAttachments('9v06h1cbv0en');
        $this->assertEquals('9v06h1cbv0en', $attachments[0]->id);
    }
    
    /**
     * Test that true does in fact equal true
     */
    public function testGetAttachmentWithValidAttachmentId()
    {
        $this->mockHandler->append(new Response('200', [], file_get_contents(__DIR__ . '/fixtures/attachments_200.json')));
        $this->client->setGuzzleClient($this->guzzleClient);
        $attachment = $this->client->getAttachments('9v06h1cbv0en');
        $this->assertEquals('9v06h1cbv0en', $attachment->id);
    }
    
    
    /**
     * Test that true does in fact equal true
     */
    public function testGetEventWithValidEventId()
    { 
        $this->mockHandler->append(new Response('200', [], file_get_contents(__DIR__ . '/fixtures/event_200.json')));
        $this->client->setGuzzleClient($this->guzzleClient);
        $event = $this->client->getEvent('ev-sf8b-20200813100000');
        $this->assertEquals('ev-sboe-20200320100000', $event->id);
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
    }
    
    public function testGetTicketWithValidTicketId()
    {
        $this->mockHandler->append(new Response('200', [], file_get_contents(__DIR__ . '/fixtures/ticket_200.json')));
        $this->client->setGuzzleClient($this->guzzleClient);
        $ticket = $this->client->getTicket('ti-sboe-20200320100000-tk1m');
        $this->assertEquals('ti-sboe-20200320100000-tk1m', $ticket->id);
    }
}

// EOF!
