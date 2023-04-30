<?php declare(strict_types=1);

use InShore\Bookwhen\Responses\Locations\RetrieveResponse;
use PHPUnit\Framework\TestCase;

final class RetrieveResponseTest extends TestCase
{


    /**
     * @covers InShore\Bookwhen\Responses\Locations\RetrieveResponse::__construct()
     * @covers InShore\Bookwhen\Responses\Locations\RetrieveResponse::from()
     */
    public function testValidHydratedLocationRetrieveResponse(): void
    {
        $attributes = [
            'attributes' => [ 
                'additional_info' => 'Additional info goes here',
                'address_text' => 'Address text goes here',
                'latitude' => 49.1649391,
                'longitude' => -2.5272508,
                'map_url' => 'https://cdn.bookwhen.com/blank_map.png?v=20230422143101',
                'zoom' => 10
            ],
            'id' => 'w0uh48ad3fm2',
         ];
        
        $location = RetrieveResponse::from($attributes);
        
        $this->assertEquals('Additional info goes here', $location->additionalInfo);
        $this->assertEquals('Address text goes here', $location->addressText);
        $this->assertEquals('w0uh48ad3fm2', $location->id);
        $this->assertEquals(49.1649391, $location->latitude);
        $this->assertEquals(-2.527250, $location->longitude);
        $this->assertEquals('https://cdn.bookwhen.com/blank_map.png?v=20230422143101', $location->mapUrl);
        $this->assertEquals(10, $location->zoom);
        
    }
    
    /**
     * @covers InShore\Bookwhen\Responses\Locations\RetrieveResponse::__construct()
     * @covers InShore\Bookwhen\Responses\Locations\RetrieveResponse::from()
     */
    public function testValidUnhydratedLocationRetrieveResponse(): void
    {
        $attributes = [
            'attributes' => [
                'additional_info' => null,
                'address_text' => null,
                'latitude' => null,
                'longitude' => null,
                'map_url' => null,
                'zoom' => null
            ],
            'id' => 'w0uh48ad3fm2',
        ];
        
        $location = RetrieveResponse::from($attributes);
        
        $this->assertNull($location->additionalInfo);
        $this->assertNull($location->addressText);
        $this->assertEquals('w0uh48ad3fm2', $location->id);
        $this->assertNull($location->latitude);
        $this->assertNull($location->longitude);
        $this->assertNull($location->mapUrl);
        $this->assertNull($location->zoom);
    }
}