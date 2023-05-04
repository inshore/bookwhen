<?php declare(strict_types=1);

namespace InShore\Bookwhen\tests\integration;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use InShore\Bookwhen\Bookwhen;
use InShore\Bookwhen\BookwhenApi;
use InShore\Bookwhen\Client;
use InShore\Bookwhen\Factory;
use InShore\Bookwhen\Exceptions\ConfigurationException;
use InShore\Bookwhen\Exceptions\ValidationException;
use PHPUnit\Framework\TestCase;
use Psr\Http\Client\ClientInterface;

/**
 * @uses InShore\Bookwhen\Validator
 */
class EventTest extends TestCase
{
    
    protected $apiKey;
    
    protected $mockHandler;
    
    protected $client;

    protected $guzzleClient;
    
    public function setUp(): void
    {
        $this->apiKey = 'dfsdsdsd';
        
        $this->mockHandler = new MockHandler();
        
        $this->guzzleClient = new GuzzleClient([
            'handler' => $this->mockHandler,
        ]);
    }
    
    /**
     * @covers InShore\Bookwhen\Bookwhen
     * @covers InShore\Bookwhen\BookwhenApi
     * @covers InShore\Bookwhen\Client
     * @covers InShore\Bookwhen\Domain\Event
     * @covers InShore\Bookwhen\Domain\Location
     * @covers InShore\Bookwhen\Domain\Ticket
     * @covers InShore\Bookwhen\Factory
     * @covers InShore\Bookwhen\Resources\Concerns\Transportable
     * @covers InShore\Bookwhen\Resources\Events
     * @covers InShore\Bookwhen\Responses\Events\RetrieveResponse
     * @covers InShore\Bookwhen\Responses\Locations\RetrieveResponse
     * @covers InShore\Bookwhen\Responses\Tickets\RetrieveResponse
     * @covers InShore\Bookwhen\Transporters\HttpTransporter
     * @covers InShore\Bookwhen\ValueObjects\ApiKey
     * @covers InShore\Bookwhen\ValueObjects\ResourceUri
     * @covers InShore\Bookwhen\ValueObjects\Transporter\BaseUri
     * @covers InShore\Bookwhen\ValueObjects\Transporter\Headers
     * @covers InShore\Bookwhen\ValueObjects\Transporter\Payload
     * @covers InShore\Bookwhen\ValueObjects\Transporter\QueryParams
     */
    public function testValidEventId(): void
    {
        $this->mockHandler->append(new Response(200, [], file_get_contents(__DIR__ . '/../fixtures/event_200.json')));         
        $this->client = BookwhenApi::factory()
        ->withApiKey($this->apiKey)
        ->withHttpClient($this->guzzleClient)
        ->make();

        $bookwhen = new Bookwhen(null, $this->client);
        $event = $bookwhen->event('ev-s4bs-20230501080000');

        $this->assertFalse($event->allDay);
        // $this->assertEquals(1, $event->attachments);
        $this->assertEquals(1, $event->attendeeAvailable);
        $this->assertEquals(0, $event->attendeeCount);
        $this->assertEquals(1, $event->attendeeLimit);
        //long string for details?
        // $this->assertEquals('', $event->details);
        $this->assertEquals('2023-05-01T09:00:00.000Z', $event->endAt);
        $this->assertFalse($event->finished);
        $this->assertEquals('ev-s4bs-20230501080000', $event->id);
        $this->assertEquals('w0uh48ad3fm2', $event->location->id);
        $this->assertEquals(10, $event->maxTicketsPerBooking);
        $this->assertEquals('2023-05-01T08:00:00.000Z', $event->startAt);
        $this->assertFalse($event->soldOut);
        $this->assertEquals('ti-s4bs-20230501080000-tp9b', $event->tickets[0]->id);
        $this->assertEquals('I000 inShore 1 Hour Product Engineer Consultation', $event->title);
        $this->assertTrue($event->waitingList);





    }
}
