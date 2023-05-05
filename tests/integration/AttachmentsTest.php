<?php declare(strict_types=1);

namespace InShore\Bookwhen\tests\integration;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use InShore\Bookwhen\Bookwhen;
use InShore\Bookwhen\BookwhenApi;
use InShore\Bookwhen\Client;
use InShore\Bookwhen\Domain\Attachment;
use InShore\Bookwhen\Factory;
use InShore\Bookwhen\Exceptions\ConfigurationException;
use InShore\Bookwhen\Exceptions\ValidationException;
use PHPUnit\Framework\TestCase;
use Psr\Http\Client\ClientInterface;
use InShore;

/**
 * @uses InShore\Bookwhen\Validator
 */
class AttachmentsTest extends TestCase
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
     * @covers InShore\Bookwhen\Domain\Attachment
     * @covers InShore\Bookwhen\Factory
     * @covers InShore\Bookwhen\Resources\Concerns\Transportable
     * @covers InShore\Bookwhen\Resources\Attachments
     * @covers InShore\Bookwhen\Responses\Attachments\ListResponse
     * @covers InShore\Bookwhen\Responses\Attachments\RetrieveResponse
     * @covers InShore\Bookwhen\Transporters\HttpTransporter
     * @covers InShore\Bookwhen\ValueObjects\ApiKey
     * @covers InShore\Bookwhen\ValueObjects\ResourceUri
     * @covers InShore\Bookwhen\ValueObjects\Transporter\BaseUri
     * @covers InShore\Bookwhen\ValueObjects\Transporter\Headers
     * @covers InShore\Bookwhen\ValueObjects\Transporter\Payload
     * @covers InShore\Bookwhen\ValueObjects\Transporter\QueryParams
     */
    public function testAttachments(): void
    {
        $this->mockHandler->append(new Response(200, [], file_get_contents(__DIR__ . '/../fixtures/attachments_200.json')));         
        $this->client = BookwhenApi::factory()
        ->withApiKey($this->apiKey)
        ->withHttpClient($this->guzzleClient)
        ->make();

        $bookwhen = new Bookwhen(null, $this->client);
        $attachments = $bookwhen->attachments();

        $this->assertIsArray($attachments);
        
        $this->assertInstanceOf(Attachment::class, $attachments[0]);
        $this->assertEquals('application/pdf', $attachments[0]->contentType);
        $this->assertEquals('3wepl3we3kq9', $attachments[0]->id);
        $this->assertEquals('CV_2023_daniel_mullin_april.pdf', $attachments[0]->fileName);
        $this->assertEquals('pdf', $attachments[0]->fileType);
        $this->assertEquals(75020, $attachments[0]->fileSizeBytes);
        $this->assertEquals('73.3 KB', $attachments[0]->fileSizeText);
        $this->assertEquals('Cv 2023 Daniel Mullin April', $attachments[0]->title);
    }
}
