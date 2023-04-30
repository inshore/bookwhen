<?php declare(strict_types=1);

use InShore\Bookwhen\ValueObjects\ResourceUri;
use PHPUnit\Framework\TestCase;

final class ResourceUriTest extends TestCase
{

    /**
     * 
     */
    public static function provideInvalidListResources(): array
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
    public static function provideValidListResource(): array
    {
        return [
            'string' => [ 'resource' ],
        ];
    }
    
    /**
     * @covers InShore\Bookwhen\ValueObjects\ResourceUri::__construct()
     * @covers InShore\Bookwhen\ValueObjects\ResourceUri::list()
     * @dataProvider provideInvalidListResources
     */
    public function testInvalidList($testResource): void
    {
        if(is_string($testResource)) {
            $this->expectException(\InvalidArgumentException::class);
        }
        else {
            $this->expectException(\TypeError::class);
        }
        $resourceUri = ResourceUri::list($testResource);
    }
    
    /**
     * @covers InShore\Bookwhen\ValueObjects\ResourceUri::__construct()
     * @covers InShore\Bookwhen\ValueObjects\ResourceUri::list()
     * @covers InShore\Bookwhen\ValueObjects\ResourceUri::toString()
     * @dataProvider provideValidListResource
     */
    public function testValidList($testResource): void
    {
        $resourceUri = ResourceUri::list($testResource);
        $this->assertSame($testResource, $resourceUri->toString());
    }
}
