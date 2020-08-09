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
    
    public function provideInvalidDates(): array
    {
        return [];
    }
    
    public function provideInvalidFroms(): array
    {
        return [];
    }
    
    public function provideInvalidIds(): array
    {
        return [];
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
    
    public function provideInvalidTokens(): array
    {
        return [];
    }
    
    public function provideInvalidTos(): array
    {
        return [];
    }
    
    public function provideValidDates(): array
    {
        return [
            'datePast' => [ '20191230' ],
            'datePresent' => [ '20200809' ],
            'dateFuture' => [ '20211230' ],
        ];
    }
    
    public function provideValidFroms(): array
    {
        return [];
    }
    
    public function provideValidIds(): array
    {
        return [];
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
    
    public function provideValidTokens(): array
    {
        return [];
    }
    
    public function provideValidTos(): array
    {
        return [];
    }
    
    /**
     * @dataProvider provideInvalidTags
     */
    public function testValidTagReturnsFalseOnInvalidTags($tag)
    {
       $this->assertFalse($this->validator->validTag($tag), $tag);
    }
    
    /**
     * @dataProvider provideValidDates
     */
    public function testValidDateReturnsTrueOnValidDates($date)
    {
        $this->assertTrue($this->validator->validDate($date), $date);
    }
    /**
     * @dataProvider provideValidFroms
     */
    public function testValidFromReturnsTrueOnValidFroms($tag)
    {
        $this->assertTrue($this->validator->validTag($tag), $tag);
    }
    /**
     * @dataProvider provideValidIds
     */
    public function testValidIdReturnsTrueOnValidIds($id)
    {
        $this->assertTrue($this->validator->validId($id), $id);
    }
    
    /**
     * @dataProvider provideValidTags
     */
    public function testValidTagReturnsTrueOnValidTags($tag)
    {
        $this->assertTrue($this->validator->validTag($tag), $tag);
    }
    
    /**
     * @dataProvider provideValidTokens
     */
    public function testValidTokenReturnsTrueOnValidTokens($token)
    {
        $this->assertTrue($this->validator->validToken($token), $token);
    }
    
    /**
     * @dataProvider provideValidTos
     */
    public function testValidTosReturnsTrueOnValidTos($to)
    {
        $this->assertTrue($this->validator->validTo($to), $to);
    }
}

// EOF!
