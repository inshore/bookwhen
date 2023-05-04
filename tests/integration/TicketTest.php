<?php declare(strict_types=1);

namespace InShore\Bookwhen\tests\integration;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use InShore\Bookwhen\Bookwhen;
use InShore\Bookwhen\BookwhenApi;
use InShore\Bookwhen\Client;
use InShore\Bookwhen\Domain\Ticket;
use InShore\Bookwhen\Factory;
use InShore\Bookwhen\Exceptions\ConfigurationException;
use InShore\Bookwhen\Exceptions\ValidationException;
use PHPUnit\Framework\TestCase;
use Psr\Http\Client\ClientInterface;
use InShore;

/**
 * @uses InShore\Bookwhen\Validator
 */
class TicketTest extends TestCase
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
     * @covers InShore\Bookwhen\Domain\Ticket
     * @covers InShore\Bookwhen\Domain\Ticket
     * @covers InShore\Bookwhen\Factory
     * @covers InShore\Bookwhen\Resources\Concerns\Transportable
     * @covers InShore\Bookwhen\Resources\Tickets
     * @covers InShore\Bookwhen\Responses\Events\RetrieveResponse
     * @covers InShore\Bookwhen\Responses\Tickets\RetrieveResponse
     * @covers InShore\Bookwhen\Responses\Tickets\RetrieveResponse
     * @covers InShore\Bookwhen\Transporters\HttpTransporter
     * @covers InShore\Bookwhen\ValueObjects\ApiKey
     * @covers InShore\Bookwhen\ValueObjects\ResourceUri
     * @covers InShore\Bookwhen\ValueObjects\Transporter\BaseUri
     * @covers InShore\Bookwhen\ValueObjects\Transporter\Headers
     * @covers InShore\Bookwhen\ValueObjects\Transporter\Payload
     * @covers InShore\Bookwhen\ValueObjects\Transporter\QueryParams
     */
    
    public function testValidTicketId(): void
    {
        $this->mockHandler->append(new Response(200, [], file_get_contents(__DIR__ . '/../fixtures/ticket_200.json')));         
        $this->client = BookwhenApi::factory()
        ->withApiKey($this->apiKey)
        ->withHttpClient($this->guzzleClient)
        ->make();

        $bookwhen = new Bookwhen(null, $this->client);
        $ticket = $bookwhen->ticket('ti-s4bs-20230501080000-tp9b');

        $this->assertInstanceOf(Ticket::class, $ticket);
        $this->assertFalse($ticket->available);
        $this->assertNull($ticket->availableFrom);
        $this->assertNull($ticket->availableTo);
        $this->assertEquals('/inshore/basket_items/apply?basket_item_ids%5Bti-s4bs-20230501080000-tp9b%5D=1', $ticket->builtBasketUrl);
        $this->assertEquals('/inshore/iframe/basket_items/apply?basket_item_ids%5Bti-s4bs-20230501080000-tp9b%5D=1', $ticket->builtBasketIframeUrl);
        $this->assertInstanceOf(\stdClass::class, $ticket->cost);
        $this->assertFalse($ticket->courseTicket);
        $this->assertEquals('', $ticket->details);
        $this->assertFalse($ticket->groupTicket);
        $this->assertEquals(2, $ticket->groupMin);
        $this->assertEquals(5, $ticket->groupMax);
        $this->assertEquals('ti-s4bs-20230501080000-tp9b', $ticket->id);
        $this->assertNull($ticket->numberIssued);
        $this->assertEquals(0, $ticket->numberTaken);
        $this->assertEquals('I000 inShore 1 Hour Consultation', $ticket->title);
    }
}
