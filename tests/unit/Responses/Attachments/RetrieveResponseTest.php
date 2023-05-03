<?php declare(strict_types=1);

namespace tests\unit\Responses\Attachments;

use InShore\Bookwhen\Responses\Attachments\RetrieveResponse;
use PHPUnit\Framework\TestCase;

final class RetrieveResponseTest extends TestCase
{    
    /**
     * @covers InShore\Bookwhen\Responses\Attachments\RetrieveResponse::__construct()
     * @covers InShore\Bookwhen\Responses\Attachments\RetrieveResponse::from()
     */
    public function testValidHydratedAttachmentRetrieveResponse(): void
    {
        $attributes = [
            'attributes' => [ 
                'content_type' => 'Content type goes here',
                'file_name' => 'File name goes here',
                'file_size_bytes' => 'File size bytes goes here',
                'file_size_text' => 'File size text goes here',
                'file_type' => 'File type goes here',
                'file_url' => 'File url goes here',
                'title' => 'Title goes here',
            ],
            'id' => '9v06h1cbv0en',
        ];
        
        $attachment = RetrieveResponse::from($attributes);
        
        $this->assertEquals('Content type goes here', $attachment->contentType);
        $this->assertEquals('File name goes here', $attachment->fileName);
        $this->assertEquals('File size bytes goes here', $attachment->fileSizeBytes);
        $this->assertEquals('File size text goes here', $attachment->fileSizeText);
        $this->assertEquals('File type goes here', $attachment->fileType);
        $this->assertEquals('File url goes here', $attachment->fileUrl);
        $this->assertEquals('9v06h1cbv0en', $attachment->id);
        $this->assertEquals('Title goes here', $attachment->title);
        
    }
    
    /**
     * @covers InShore\Bookwhen\Responses\Attachments\RetrieveResponse::__construct()
     * @covers InShore\Bookwhen\Responses\Attachments\RetrieveResponse::from()
     */
    public function testValidUnhydratedAttachmentRetrieveResponse(): void
    {
        $attributes = [
            'attributes' => [
                'content_type' => null,
                'file_name' => null,
                'file_size_bytes' => null,
                'file_size_text' => null,
                'file_type' => null,
                'file_url' => null,
                'title' => null,
            ],
            'id' => '9v06h1cbv0en',
        ];
        
        $attachment = RetrieveResponse::from($attributes);
        
        $this->assertNull($attachment->contentType);
        $this->assertNull($attachment->fileName);
        $this->assertNull($attachment->fileSizeBytes);
        $this->assertNull($attachment->fileSizeText);
        $this->assertNull($attachment->fileType);
        $this->assertNull($attachment->fileUrl);
        $this->assertEquals('9v06h1cbv0en', $attachment->id);;
        $this->assertNull($attachment->title);
    }
}