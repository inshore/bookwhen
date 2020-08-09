<?php

namespace InShore\BookWhen\Test;

use InShore\BookWhen\Client;
use GuzzleHttp\Handler\MockHandler;

class ClientTest extends \PHPUnit_Framework_TestCase
{
    
    protected $client;
    
    public function setUp(): void
    {
        $this->client = new Client('6v47r0jdz3r2ao3yc8f1vyx2kjry');
        $this->mockHandler = new MockHandler();
    }
    
    /**
     * Test that true does in fact equal true
     */
    public function testGetEventValidEventId()
    { 
//         $event = $this->client->getEvent('ev-sf8b-20200813100000');
//         $this->assertInstanceOf('object', $event);
//         $this->assertObjectHasAttribute('title', $event);
    }
}

// EOF!
