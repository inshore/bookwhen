<?php 

declare(strict_types=1);

namespace InShore\Bookwhen\Test;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\HandlerStack;
use InShore\Bookwhen\Client;
use InShore\Bookwhen\Exceptions\ConfigurationException;
use InShore\Bookwhen\Exceptions\RestException;
use InShore\Bookwhen\Exceptions\ValidationException;
use PHPUnit\Framework\TestCase;

/**
 * @author Daniel Mullin daniel@inshore.je
 * @author Brandon Lubbehusen brandon@inshore.je
 * 
 * @uses InShore\Bookwhen\Client
 */
class ClientTest extends TestCase
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
     * @covers InShore\Bookwhen\Client::getAttachments
     * @uses InShore\Bookwhen\Validator
     */
    public function testGetAttachments()
    {
        $this->mockHandler->append(new Response('200', [], file_get_contents(__DIR__ . '/fixtures/attachments_200.json')));
        $this->client->setGuzzleClient($this->guzzleClient);
        $attachments = $this->client->getAttachments();
        $this->assertIsArray($attachments);
        $this->assertEquals('9v06h1cbv0en', $attachments[0]->id);
    }
    
    /**
     * @covers InShore\Bookwhen\Client::getAttachment
     */
    public function testGetAttachmentWithInValidAttachmentId()
    {
        $this->expectException(ValidationException::class);
        $this->mockHandler->append(new Response('200', [], file_get_contents(__DIR__ . '/fixtures/attachments_200.json')));
        $this->client->setGuzzleClient($this->guzzleClient);
        $attachment = $this->client->getAttachment(null);
    }
    
    /**
     * @covers InShore\Bookwhen\Client::getAttachment
     */
    public function testGetAttachmentWithValidAttachmentId()
    {
        $this->mockHandler->append(new Response('200', [], file_get_contents(__DIR__ . '/fixtures/attachments_200.json')));
        $this->client->setGuzzleClient($this->guzzleClient);
        $attachment = $this->client->getAttachment('9v06h1cbv0en');
        $this->assertEquals('9v06h1cbv0en', $attachment->id);
    }
    
    
    /**
     * @covers InShore\Bookwhen\Client::getEvent
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
     * @covers InShore\Bookwhen\Client::getTicket
     */
    public function testGetTicketWithValidTicketId()
    {
        $this->mockHandler->append(new Response('200', [], file_get_contents(__DIR__ . '/fixtures/ticket_200.json')));
        $this->client->setGuzzleClient($this->guzzleClient);
        $ticket = $this->client->getTicket('ti-sboe-20200320100000-tk1m');
        $this->assertEquals('ti-sboe-20200320100000-tk1m', $ticket->id);
    }
    
    /**
     * @covers InShore\Bookwhen\Client::getTickets
     */
    public function testGetTicketsWithInValidEventId()
    {
        $this->expectException(ValidationException::class);
        $this->mockHandler->append(new Response('200', [], file_get_contents(__DIR__ . '/fixtures/tickets_200.json')));
        $this->client->setGuzzleClient($this->guzzleClient);
        $tickets = $this->client->getTickets('ti-sboe-20200320100000-tk1m');
        $this->assertIsArray($tickets);
    }
    
    /**
     * @covers InShore\Bookwhen\Client::getTickets
     */
    public function testGetTicketsWithValidEventId()
    {
        $this->mockHandler->append(new Response('200', [], file_get_contents(__DIR__ . '/fixtures/tickets_200.json')));
        $this->client->setGuzzleClient($this->guzzleClient);
        $tickets = $this->client->getTickets('ev-sf8b-20200813100000');
        $this->assertIsArray($tickets);
    }
    
    
}

// EOF!
