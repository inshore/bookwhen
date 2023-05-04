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
class TicketsTest extends TestCase
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
     * @covers InShore\Bookwhen\Responses\Tickets\ListResponse
     * @covers InShore\Bookwhen\Responses\Tickets\RetrieveResponse
     * @covers InShore\Bookwhen\Transporters\HttpTransporter
     * @covers InShore\Bookwhen\ValueObjects\ApiKey
     * @covers InShore\Bookwhen\ValueObjects\ResourceUri
     * @covers InShore\Bookwhen\ValueObjects\Transporter\BaseUri
     * @covers InShore\Bookwhen\ValueObjects\Transporter\Headers
     * @covers InShore\Bookwhen\ValueObjects\Transporter\Payload
     * @covers InShore\Bookwhen\ValueObjects\Transporter\QueryParams
     */
    
    public function testTickets(): void
    {
        $this->mockHandler->append(new Response(200, [], file_get_contents(__DIR__ . '/../fixtures/tickets_200.json')));         
        $this->client = BookwhenApi::factory()
        ->withApiKey($this->apiKey)
        ->withHttpClient($this->guzzleClient)
        ->make();

        $bookwhen = new Bookwhen(null, $this->client);
        $tickets = $bookwhen->tickets('ev-siyg-20230501080000');

        $this->assertIsArray($tickets);
        
        $this->assertInstanceOf(Ticket::class, $tickets[0]);
        $this->assertFalse($tickets[0]->available);
        $this->assertNull($tickets[0]->availableFrom);
        $this->assertNull($tickets[0]->availableTo);
        $this->assertEquals('/inshore/basket_items/apply?basket_item_ids%5Bti-s4bs-20230501080000-tp9b%5D=1', $tickets[0]->builtBasketUrl);
        $this->assertEquals('/inshore/iframe/basket_items/apply?basket_item_ids%5Bti-s4bs-20230501080000-tp9b%5D=1', $tickets[0]->builtBasketIframeUrl);
        $this->assertInstanceOf(\stdClass::class, $tickets[0]->cost);
        $this->assertFalse($tickets[0]->courseTicket);
        $this->assertEquals('', $tickets[0]->details);
        $this->assertFalse($tickets[0]->groupTicket);
        $this->assertEquals(2, $tickets[0]->groupMin);
        $this->assertEquals(5, $tickets[0]->groupMax);
        $this->assertEquals('ti-s4bs-20230501080000-tp9b', $tickets[0]->id);
        $this->assertNull($tickets[0]->numberIssued);
        $this->assertEquals(0, $tickets[0]->numberTaken);
        $this->assertEquals('I000 inShore 1 Hour Consultation', $tickets[0]->title);
    }
}
