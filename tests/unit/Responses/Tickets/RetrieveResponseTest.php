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
                'available' => true,
                'available_from' => 'Available from goes here',
                'available_to' => 'Available to goes here',
                'built_basket_url' => 'Built basket url goes here',
                'built_basket_iframe_url' => 'Built basket iframe url goes here',
                'course_ticket' => false,
                'details' => 'Details go here',
                'group_ticket' => true,
                'group_min' => 1,
                'group_max' => 10,
                'number_issued' => 10,
                'number_taken' => 5,
                'title' => 'Title goes here'
            ],
            'id' => 'ti-s4bs-20230501080000-tp9b',
         ];
        
        $ticket = RetrieveResponse::from($attributes);
        
        $this->assertTrue($ticket->available);
        $this->assertEquals('Available from goes here', $ticket->availableFrom);
        $this->assertEquals('Available to goes here', $ticket->availableTo);
        $this->assertEquals('Built basket url goes here', $ticket->builtBasketUrl);
        $this->assertEquals('Built basket iframe url goes here', $ticket->builtBasketIframeUrl);
        $this->assertEquals('ti-s4bs-20230501080000-tp9b', $ticket->id);
        $this->assertFalse($ticket->courseTicket);
        $this->assertEquals('Details go here', $ticket->details);
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