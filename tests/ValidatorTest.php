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
        return [
            'null' => [null],
            'emptyString' => [''],
            'object' => [ new \stdClass() ],
        ];
    }
    
    public function provideInvalidFroms(): array
    {
        return [
            'null' => [null, null],
            'emptyString' => ['', ''],
            'object' => [ new \stdClass(), new \stdClass() ],
        ];
    }
    
    public function provideInvalidIds(): array
    {
        return [
            'null' => [null],
            'emptyString' => [''],
            'object' => [ new \stdClass() ],
        ];
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
        return [
            'null' => [null],
            'emptyString' => [''],
            'object' => [ new \stdClass() ],
        ];
    }
    
    public function provideInvalidTos(): array
    {
        return [
            'null' => [null],
            'emptyString' => [''],
            'object' => [ new \stdClass() ],
        ];
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
        return [
            'fromFutureToNull' => [ '20211230', null ],
            'fromPastToNull' => [ '20191230', null ],
            'fromPastToFuture' => [ '20191230', '20200809' ],
            'fromPastToPast' => [ '20191230', '20200101' ],
            'fromPastToPresent' => [ '20191230', '20200809' ],
            'fromPresentToNull' => [ '20200809', null ]
        ];
    }
    
    public function provideValidIds(): array
    {
        return [
            'eventId' => [ 'ev-sf8b-20200813100000', 'event' ],
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
    
    public function provideValidTokens(): array
    {
        return [
            'ours' => [ '6v47r0jdz3r2ao3yc8f1vyx2kjry' ],
        ];
    }
    
    public function provideValidTos(): array
    {
        return [
            'toFutureFromNull' => [ '20211230', null ],
            'toPastFromNull' => [ '20191230', null ],
            'toPastFromPast' => [ '20200809', '20191230' ],
            'toPastFromPast' => [ '20200101', '20191230' ],
            'toPresentFromNull' => [ '20200809', null ],
            'toPresentFromPast' => [ '20200809', '20191230' ],
        ];
    }
    
    /**
     * @dataProvider provideInvalidDates
     */
    public function testValidDateReturnsFalseOnInvalidDates($date)
    {
       $this->assertFalse($this->validator->validTag($date), $date);
    }
    
    /**
     * @dataProvider provideInvalidFroms
     */
    public function testValidFromReturnsFalseOnInvalidFroms($from, $to)
    {
       $this->assertFalse($this->validator->validFrom($from, $to), $from);
    }
    
    /**
     * @dataProvider provideInvalidIds
     */
    public function testValidTagReturnsFalseOnInvalidIds($id)
    {
       $this->assertFalse($this->validator->validId($id), $id);
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
    public function testValidFromReturnsTrueOnValidFroms($from, $to)
    {
        $this->assertTrue($this->validator->validTag($from, $to), $from);
    }
    /**
     * @dataProvider provideValidIds
     */
    public function testValidIdReturnsTrueOnValidIds($id, $type)
    {
        $this->assertTrue($this->validator->validId($id, $type), $id);
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
