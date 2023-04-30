<?php declare(strict_types=1);

use InShore\Bookwhen\ValueObjects\ApiKey;
use PHPUnit\Framework\TestCase;

final class ApiKeyTest extends TestCase
{

    public static function provideInvalidApiKeys(): array
    {
        return [
            'null' => [null],
            'emptyString' => [''],
            'object' => [ new \stdClass() ],
        ];
    }
    
    public static function provideValidApiKeys(): array
    {
        return [
            'string' => [ 'fdhldfhjsflkds' ],
        ];
    }
    
    /**
     * @covers InShore\Bookwhen\ValueObjects\ApiKey::__construct()
     * @covers InShore\Bookwhen\ValueObjects\ApiKey::from()
     * @dataProvider provideInvalidApiKeys
     */
    public function testInvalidApiKey($testApiKey): void
    {
        if(is_string($testApiKey)) {
            $this->expectException(\InvalidArgumentException::class);
        }
        else {
            $this->expectException(\TypeError::class);
        }
        $apiKey = ApiKey::from($testApiKey);
    }
    
    /**
     * @covers InShore\Bookwhen\ValueObjects\ApiKey::__construct()
     * @covers InShore\Bookwhen\ValueObjects\ApiKey::from
     * InShore\Bookwhen\ValueObjects\ApiKey::toString()
     * @dataProvider provideValidApiKeys
     */
    public function testValidApiKey($testApiKey): void
    {
        $apiKey = ApiKey::from($testApiKey);
        $this->assertSame($testApiKey, $apiKey->toString());
    }
    
}