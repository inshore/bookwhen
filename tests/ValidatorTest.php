<?php

namespace InShore\BookWhen\Test;

use InShore\BookWhen\Validator;

class ValidatorTest extends \PHPUnit_Framework_TestCase
{
    
    protected $validator;
    
    public function setUp(): void
    {
        $this->validator = new Validator();
    }
    
    public function provideInvalidTags(): array
    {
        return [
            'null' => [null],
            'emptyString' => [''],
            'object' => [ new \stdClass() ], 
            'nonAlphanumeric'  => [ 'akrwejh[?fs83z420qrzc8397r4' ],
        ];
    }
    
    public function provideValidTags():array
    {
        return [
            'alphanumericMixedcase' => [ 'a1D3' ],
            'alphanumericLowercase' => [ 'a1C3' ],
            'alphanumericUppercase' => [ 'A1C3' ],
            'lettersMixedcase' => [ 'aBcD' ],
            'lettersLowercase' => [ 'abcd' ],
            'lettersUppercase' => [ 'ABCD' ],
            'numeric' => [ '1323' ],
        ];
    }
    
    /**
     * @dataProvider provideInvalidTags
     */
    public function testValidTagReturnsFalseOnInvalidTags($tag)
    {
       $this->assertFalse($this->validator->validTag($tag), $tag);
    }
    
    /**
     * @dataProvider provideValidTags
     */
    public function testValidTagReturnsTrueOnValidTags($tag)
    {
        $this->assertTrue($this->validator->validTag($tag), $tag);
    }
}

// EOF!
