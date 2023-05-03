<?php declare(strict_types=1);

namespace tests\unit\Responses\Events;

use InShore\Bookwhen\Responses\Events\RetrieveResponse;
use PHPUnit\Framework\TestCase;

final class RetrieveResponseTest extends TestCase
{    
    /**
     * @covers InShore\Bookwhen\Responses\Events\RetrieveResponse::__construct()
     * @covers InShore\Bookwhen\Responses\Events\RetrieveResponse::from()
     */
    public function testValidHydratedEventRetrieveResponse(): void
    {
        $attributes = [
            'attributes' => [ 
                'all_day' => true,
                'attendee_count' => 7,
                'attendee_limit' => 10,
                'details' => 'Details goes here',
                'end_at' => 'End at goes here',
                'max_tickets_per_booking' => 20,
                'start_at' => 'Start at goes here',
                'title' => 'Title goes here',
                'waiting_list' => true,
            ],
            'relationships' => [
                'attachments' => [
                    'data' => [
                        ['id' => '3wepl3we3kq9']
                    ],
                ],
                'location' => [
                    'data' => [
                        'id' => 'sjm7pskr31t3',
                    ],
                ],
                'tickets' => [
                    'data' => [
                        ['id' => 'ti-s4bs-20230501080000-tp9b']
                    ],
                ],
            ],
            'id' => '9v06h1cbv0en',
        ];
        
        
        $event = RetrieveResponse::from($attributes);
        
        $this->assertTrue($event->allDay);
        $this->assertEquals(7, $event->attendeeCount);
        $this->assertEquals(10, $event->attendeeLimit);
        $this->assertEquals('3wepl3we3kq9', $event->attachments[0]->id);
        $this->assertEquals('Details goes here', $event->details);
        $this->assertEquals('End at goes here', $event->endAt);
        $this->assertEquals('9v06h1cbv0en', $event->id);
        $this->assertEquals('sjm7pskr31t3', $event->location->id);
        $this->assertEquals(20, $event->maxTicketsPerBooking);
        $this->assertEquals('Start at goes here', $event->startAt);
        $this->assertEquals('ti-s4bs-20230501080000-tp9b', $event->tickets[0]->id);
        $this->assertEquals('Title goes here', $event->title);
        $this->assertTrue($event->waitingList);
        
    }
    
    /**
     * @covers InShore\Bookwhen\Responses\Events\RetrieveResponse::__construct()
     * @covers InShore\Bookwhen\Responses\Events\RetrieveResponse::from()
     */
//     public function testValidUnhydratedEventRetrieveResponse(): void
//     {
//         $attributes = [
//             'attributes' => [
//                 'content_type' => null,
//                 'file_name' => null,
//                 'file_size_bytes' => null,
//                 'file_size_text' => null,
//                 'file_type' => null,
//                 'file_url' => null,
//                 'title' => null,
//             ],
//             'id' => '9v06h1cbv0en',
//         ];
        
//         $event = RetrieveResponse::from($attributes);
        
//         $this->assertNull($event->contentType);
//         $this->assertNull($event->fileName);
//         $this->assertNull($event->fileSizeBytes);
//         $this->assertNull($event->fileSizeText);
//         $this->assertNull($event->fileType);
//         $this->assertNull($event->fileUrl);
//         $this->assertEquals('9v06h1cbv0en', $event->id);;
//         $this->assertNull($event->title);
//     }
}