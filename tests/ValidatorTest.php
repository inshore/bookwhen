<?php

declare(strict_types=1);

namespace InShore\Bookwhen\Test;

use InShore\Bookwhen\Validator;
use PHPUnit\Framework\TestCase;

/**
 * @covers InShore\Bookwhen\Validator::__construct
 * @uses InShore\Bookwhen\Validator
 */
class ValidatorTest extends TestCase
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
            'attachmentIdNull' => [ null, 'attachment' ],
            'attachmentIdEmptyString' => [ '', 'attachment' ],
            'attachmentIdObject' => [ new \stdClass(), 'attachment' ],
            'attachmentIdNonAlphaNumeric' => [ '*&^GLJjklihl', 'attachment' ],
            'attachmentIdShortAlphaNumeric' => [ 'asdfjkld', 'attachment' ],
            'attachmentIdLongAlphaNumeric' => [ 'asdfjksdffdsdfld', 'attachment' ],
            'emptyString' => ['', null],
            'object' => [ new \stdClass(), null ],
            'null' => [null, null],
            'longAlphaNumeric' => [ 'asdfjksdffdsdfld', null ],
            'nonAlphaNumeric' => [ '*&^GLJjklihl', null ],
            'shortAlphaNumeric' => [ 'asdfjkld', null ],
            'classPassIdNull' => [ null, 'classPass' ],
            'classPassIdEmptyString' => [ '', 'classPass' ],
            'classPassIdObject' => [ new \stdClass(), 'classPass' ],
            'eventIdNull' => [ null, 'eventId'],
            'locationIdNull' => [ null, 'location' ],
            'locationEmptyString' => [ '', 'location' ],
            'locationIdObject' => [ new \stdClass(), 'location' ],
            'locationIdNonAlphaNumeric' => [ '*&^GLJjklihl', 'location' ],
            'locationIdShortAlphaNumeric' => [ 'asdfjkld', 'location' ],
            'locationIdLongAlphaNumeric' => [ 'asdfjksdffdsdfld', 'location' ],
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
            'attachmentId' => ['9v06h1cbv0en', 'attachment'],
            'classPassId' => [ 'cp-vk3x1brhpsbf', 'classPass' ],
            'default' => ['9v06h1cbv0en', null],
            'eventId' => [ 'ev-sf8b-20200813100000', 'event' ],
            'locationId' => ['sjm7pskr31t3', 'locationId' ],
            'ticketId' => ['ti-sboe-20200320100000-tk1m', 'ticket']
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
     * @covers InShore\Bookwhen\Validator::validDate
     * @dataProvider provideInvalidDates
     */
    public function testValidDateReturnsFalseOnInvalidDates($date)
    {
       $this->assertFalse($this->validator->validDate($date));
    }
    
    /**
     * @covers InShore\Bookwhen\Validator::validFrom
     * @covers InShore\Bookwhen\Validator::validDate
     * @dataProvider provideInvalidFroms
     */
    public function testValidFromReturnsFalseOnInvalidFroms($from, $to)
    {
       $this->assertFalse($this->validator->validFrom($from, $to));
    }
    
    /**
     * @covers InShore\Bookwhen\Validator::validId
     * @dataProvider provideInvalidIds
     */
    public function testValidIdReturnsFalseOnInvalidIds($id, $type)
    {
       $this->assertFalse($this->validator->validId($id, $type));
    }
    
    /**
     * @covers InShore\Bookwhen\Validator::validTags
     * @dataProvider provideInvalidTags
     */
    public function testValidTagReturnsFalseOnInvalidTags($tag)
    {
       $this->assertFalse($this->validator->validTag($tag));
    }
    
    /**
     * @covers InShore\Bookwhen\Validator::validDate
     * @dataProvider provideValidDates
     */
    public function testValidDateReturnsTrueOnValidDates($date)
    {
        $this->assertTrue($this->validator->validDate($date));
    }
    /**
     * @covers InShore\Bookwhen\Validator::validFrom
     * @covers InShore\Bookwhen\Validator::validDate
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
        $this->assertTrue($this->validator->validId($id, $type));
    }
    
    /**
     * @dataProvider provideValidTags
     */
    public function testValidTagReturnsTrueOnValidTags($tag)
    {
        $this->assertTrue($this->validator->validTag($tag));
    }
    
    /**
     * @dataProvider provideValidTokens
     */
    public function testValidTokenReturnsTrueOnValidTokens($token)
    {
        $this->assertTrue($this->validator->validToken($token));
    }
    
    /**
     * @dataProvider provideValidTos
     */
    public function testValidTosReturnsTrueOnValidTos($to)
    {
        $this->assertTrue($this->validator->validTo($to));
    }
}

// EOF!
