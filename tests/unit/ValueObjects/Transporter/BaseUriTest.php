<?php declare(strict_types=1);

use InShore\Bookwhen\ValueObjects\Transporter\BaseUri;
use PHPUnit\Framework\TestCase;

final class BaseUriTest extends TestCase
{

    /**
     * 
     */
    public static function provideInvalidBaseUriResources(): array
    {
        return [
            'null' => [null],
            'emptyString' => [''],
            'object' => [ new \stdClass() ],
        ];
    }
    
    /**
     * 
     */
    public static function provideValidBaseUriResource(): array
    {
        return [
            'string' => [ 'bookwhen.com/api/v2' ],
        ];
    }
    
    /**
     * @covers InShore\Bookwhen\ValueObjects\Transporter\BaseUri::__construct()
     * @covers InShore\Bookwhen\ValueObjects\Transporter\BaseUri::from()
     * @dataProvider provideInvalidBaseUriResources
     */
    public function testInvalidBaseUri($testBaseUri): void
    {
        if(is_string($testBaseUri)) {
            $this->expectException(\InvalidArgumentException::class);
        }
        else {
            $this->expectException(\TypeError::class);
        }
        $resourceUri = BaseUri::from($testBaseUri);
    }
    
    /**
     * @covers InShore\Bookwhen\ValueObjects\Transporter\BaseUri::__construct()
     * @covers InShore\Bookwhen\ValueObjects\Transporter\BaseUri::from()
     * @covers InShore\Bookwhen\ValueObjects\Transporter\BaseUri::toString()
     * @dataProvider provideValidBaseUriResource
     */
    public function testValidBaseUri($testBaseUri): void
    {
        $baseUri = BaseUri::from($testBaseUri);
        $this->assertSame('https://' . $testBaseUri . '/', $baseUri->toString());
    }
}
