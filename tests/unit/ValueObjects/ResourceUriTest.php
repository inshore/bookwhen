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
     *
     */
    public static function provideInvalidRetrieveResources(): array
    {
        return [
            'null/null' => [ null, null ],
            'emptyString/null' => [ '', null ],
            'object/null' => [ new \stdClass(), null ],
            'resource/null' => [ 'resource', null ],
            'resource/emptyString' => [ 'resource', '' ],
            'resource/object' => [ 'resource', new \stdClass() ],
        ];
    }
    
    /**
     * 
     */
    public static function provideValidRetrieveResource(): array
    {
        return [
            'resource/id' => [ 'resource', 'resource-id-1' ],
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
        ResourceUri::list($testResource);
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
    
    /**
     * @covers InShore\Bookwhen\ValueObjects\ResourceUri::__construct()
     * @covers InShore\Bookwhen\ValueObjects\ResourceUri::retrieve()
     * @dataProvider provideInvalidRetrieveResources
     */
    public function testInvalidRetrieve($testResource, $testId): void
    {
        if(is_string($testResource) && is_string($testId)) {
            $this->expectException(\InvalidArgumentException::class);
        }
        else {
            $this->expectException(\TypeError::class);
        }
        ResourceUri::retrieve($testResource, $testId);
    }
    
    /**
     * @covers InShore\Bookwhen\ValueObjects\ResourceUri::__construct()
     * @covers InShore\Bookwhen\ValueObjects\ResourceUri::retrieve()
     * @covers InShore\Bookwhen\ValueObjects\ResourceUri::toString()
     * @dataProvider provideValidRetrieveResource
     */
    public function testValidRetrieve($testResource, $testId): void
    {
        $resourceUri = ResourceUri::retrieve($testResource, $testId);
        $this->assertSame($testResource . '/' . $testId, $resourceUri->toString());
    }
}
