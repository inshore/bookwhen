<?php declare(strict_types=1);

namespace tests\unit\Responses\ClassPasses;

use InShore\Bookwhen\Responses\ClassPasses\RetrieveResponse;
use PHPUnit\Framework\TestCase;

final class RetrieveResponseTest extends TestCase
{    
    /**
     * @covers InShore\Bookwhen\Responses\ClassPasses\RetrieveResponse::__construct()
     * @covers InShore\Bookwhen\Responses\ClassPasses\RetrieveResponse::from()
     */
    public function testValidHydratedclassPassRetrieveResponse(): void
    {
        $attributes = [
            'attributes' => [ 
                'details' => 'Details goes here',
                'number_available' => 20,
                'title' => 'Title goes here',
                'usage_allowance' => 10,
                'usage_type' => 'personal',
                'use_restricted_for_days' => 60,
            ],
            'id' => 'cp-vk3x1brhpsbf',
         ];
        
        $classPass = RetrieveResponse::from($attributes);
        
        $this->assertEquals('Details goes here', $classPass->details);
        $this->assertEquals(20, $classPass->numberAvailable);
        $this->assertEquals('cp-vk3x1brhpsbf', $classPass->id);
        $this->assertEquals('Title goes here', $classPass->title);
        $this->assertEquals(10, $classPass->usageAllowance);
        $this->assertEquals('personal', $classPass->usageType);
        $this->assertEquals(60, $classPass->useRestrictedForDays);
        
    }
    
    /**
     * @covers InShore\Bookwhen\Responses\
     * ClassPasses\RetrieveResponse::__construct()
     * @covers InShore\Bookwhen\Responses\ClassPasses\RetrieveResponse::from()
     */
    public function testValidUnhydratedclassPassRetrieveResponse(): void
    {
        $attributes = [
            'attributes' => [
                'details' => null,
                'number_available' => null,
                'title' => null,
                'usage_allowance' => null,
                'usage_type' => null,
                'use_restricted_for_days' => null
            ],
            'id' => 'cp-vk3x1brhpsbf',
        ];
        
        $classPass = RetrieveResponse::from($attributes);
        
        $this->assertNull($classPass->details);
        $this->assertNull($classPass->numberAvailable);
        $this->assertEquals('cp-vk3x1brhpsbf', $classPass->id);;
        $this->assertNull($classPass->title);
        $this->assertNull($classPass->usageAllowance);
        $this->assertNull($classPass->usageType);
        $this->assertNull($classPass->useRestrictedForDays);;
    }
}