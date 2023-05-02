<?php declare(strict_types=1);

namespace tests\unit\Responses\Tickets;

use InShore\Bookwhen\Responses\Tickets\RetrieveResponse;
use PHPUnit\Framework\TestCase;

final class RetrieveResponseTest extends TestCase
{


    /**
     * @covers InShore\Bookwhen\Responses\Tickets\RetrieveResponse::__construct()
     * @covers InShore\Bookwhen\Responses\Tickets\RetrieveResponse::from()
     */
    public function testValidHydratedTicketRetrieveResponse(): void
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
            'id' => 'ti-s4bs-20230501080000-tp9b',
         ];
        
        $ticket = RetrieveResponse::from($attributes);
        
        $this->assertEquals('Additional info goes here', $ticket->additionalInfo);
        $this->assertEquals('Address text goes here', $ticket->addressText);
        $this->assertEquals('w0uh48ad3fm2', $ticket->id);
        $this->assertEquals(49.1649391, $ticket->latitude);
        $this->assertEquals(-2.5272508, $ticket->longitude);
        $this->assertEquals('https://cdn.bookwhen.com/blank_map.png?v=20230422143101', $ticket->mapUrl);
        $this->assertEquals(10, $ticket->zoom);
        
    }
    
    /**
     * @covers InShore\Bookwhen\Responses\Tickets\RetrieveResponse::__construct()
     * @covers InShore\Bookwhen\Responses\Tickets\RetrieveResponse::from()
     */
    public function testValidUnhydratedTicketRetrieveResponse(): void
    {
        $attributes = [
            'attributes' => [
                'available' => null,
                'available_from' => null,
                'available_to' => null,
                'built_basket_url' => null,
                'built_basket_iframe_url' => null,
                //$cost,
                'course_ticket' => null,
                'details' => null,
                'group_ticket' => null,
                'group_min' => null,
                'group_max' => null,
                'number_issued' => null,
                'number_taken' => null,
                'title' => null
            ],
            'id' => 'ti-s4bs-20230501080000-tp9b',
        ];
        
        $ticket = RetrieveResponse::from($attributes);
        $this->assertNull($ticket->availableFrom);
        $this->assertNull($ticket->availableTo);
        $this->assertNull($ticket->builtBasketUrl);
        $this->assertNull($ticket->builtBasketIframeUrl);
            //public readonly object $cost);
        $this->assertNull($ticket->courseTicket);
        $this->assertNull($ticket->details);
        $this->assertNull($ticket->groupTicket);
        $this->assertNull($ticket->groupMin);
        $this->assertNull($ticket->groupMax);
        $this->assertEquals('ti-s4bs-20230501080000-tp9b', $ticket->id);
        $this->assertNull($ticket->numberIssued);
        $this->assertNull($ticket->numberTaken);
        $this->assertNull($ticket->title);
    }
}