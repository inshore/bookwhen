<?php declare(strict_types=1);

namespace InShore\Bookwhen\Test;

use InShore\Bookwhen\Bookwhen;
use InShore\Bookwhen\Exceptions\ConfigurationException;
use PHPUnit\Framework\TestCase;
use InShore\Bookwhen\Exceptions\ValidationException;

/**
 * @uses InShore\Bookwhen\Validator
 */
class BookwhenTest extends TestCase
{
    
    protected $bookwhen;
    
    public function setUp(): void
    {
        $this->bookwhen = new Bookwhen('garbage');
    }
    
    /**
     *
     */
    public static function provideAttachmentInvalidAttchmentIds(): array
    {
        return [
            'null' => [null],
            'emptyString' => [''],
            'integer' => [1],
            'object' => [ new \stdClass() ],
        ];
    }
    
    /**
     *
     */
    public static function provideAttachmentValidAttchmentIds(): array
    {
        return [
            'id' => '4ttr1but31d'
        ];
    }
    
    /**
     *
     */
    public static function provideClassPassInvalidClassPassIds(): array
    {
        return [
            'null' => [null],
            'emptyString' => [''],
            'integer' => [1],
            'object' => [ new \stdClass() ],
        ];
    }
    
    /**
     * @covers InShore\Bookwhen\Bookwhen::__construct()
     * @covers InShore\Bookwhen\BookwhenApi
     * @covers InShore\Bookwhen\Client
     * @covers InShore\Bookwhen\Exceptions\ValidationException
     * @covers InShore\Bookwhen\Factory
     * @covers InShore\Bookwhen\Transporters\HttpTransporter
     * @covers InShore\Bookwhen\ValueObjects\ApiKey
     * @covers InShore\Bookwhen\ValueObjects\Transporter\BaseUri
     * @covers InShore\Bookwhen\ValueObjects\Transporter\Headers
     * @covers InShore\Bookwhen\ValueObjects\Transporter\QueryParams
     */
    public function testConstructInvalidApiKey(): void
    {
        $this->expectException(ConfigurationException::class);
        new Bookwhen();
    }
    
    /**
     * @covers InShore\Bookwhen\Bookwhen::__construct()
     * @covers InShore\Bookwhen\Bookwhen::attachment()
     * @covers InShore\Bookwhen\BookwhenApi
     * @covers InShore\Bookwhen\Client
     * @covers InShore\Bookwhen\Exceptions\ValidationException
     * @covers InShore\Bookwhen\Factory
     * @covers InShore\Bookwhen\Transporters\HttpTransporter
     * @covers InShore\Bookwhen\ValueObjects\ApiKey
     * @covers InShore\Bookwhen\ValueObjects\Transporter\BaseUri
     * @covers InShore\Bookwhen\ValueObjects\Transporter\Headers
     * @covers InShore\Bookwhen\ValueObjects\Transporter\QueryParams
     * @dataProvider provideAttachmentInvalidAttchmentIds
     */
    public function testAttachmentInvalidAttachmentId($testAttachmentId): void
    {
        if(is_string($testAttachmentId)) {
            $this->expectException(ValidationException::class);
        }
        else {
            $this->expectException(\TypeError::class);
        }
        $this->bookwhen->attachment($testAttachmentId);
    }
    
    /**
     * @covers InShore\Bookwhen\Bookwhen::__construct()
     * @covers InShore\Bookwhen\Bookwhen::classPass()
     * @covers InShore\Bookwhen\Bookwhen
     * @covers InShore\Bookwhen\BookwhenApi
     * @covers InShore\Bookwhen\Client
     * @covers InShore\Bookwhen\Exceptions\ValidationException
     * @covers InShore\Bookwhen\Factory
     * @covers InShore\Bookwhen\Transporters\HttpTransporter
     * @covers InShore\Bookwhen\ValueObjects\ApiKey
     * @covers InShore\Bookwhen\ValueObjects\Transporter\BaseUri
     * @covers InShore\Bookwhen\ValueObjects\Transporter\Headers
     * @covers InShore\Bookwhen\ValueObjects\Transporter\QueryParams
     * @dataProvider provideClassPassInvalidClassPassIds
     */
    public function testClassPassInvalidClassPassIds($testAttachmentId): void
    {
        if(is_string($testAttachmentId)) {
            $this->expectException(ValidationException::class);
        }
        else {
            $this->expectException(\TypeError::class);
        }
        $this->bookwhen->attachment($testAttachmentId);
    }
    
    /**
     * @covers InShore\Bookwhen\ValueObjects\ResourceUri::__construct()
     * @covers InShore\Bookwhen\ValueObjects\ResourceUri::retrieve()
     * @dataProvider provideInvalidRetrieveResources
     */
//     public function testAtachmentValidattachmentId($testResource, $testId): void
//     {

//     }

}