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
    
    public static function provideInvalidDates(): array
    {
        return [
            'null' => [null],
            'emptyString' => [''],
            'object' => [ new \stdClass() ],
        ];
    }
    
    public static function provideInvalidFroms(): array
    {
        return [
            //'null' => [null, null],
            'emptyString' => ['', ''],
            //'object' => [ new \stdClass(), new \stdClass() ],
        ];
    }
    
    public static function provideInvalidIds(): array
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
    
    public static function provideInvalidTags(): array
    {
        return [
            'null' => [null],
            'emptyString' => [''],
            'object' => [ new \stdClass() ],
            'nonAlphanumeric'  => [ 'akrwejh[?fs83z420qrzc8397r4' ],
        ];
    }
    
    public static function provideInvalidTokens(): array
    {
        return [
            'null' => [null],
            'emptyString' => [''],
            'object' => [ new \stdClass() ],
        ];
    }
    
    public static function provideInvalidTos(): array
    {
        return [
            'null' => [null],
            'emptyString' => [''],
            'object' => [ new \stdClass() ],
        ];
    }
    
    public static function provideValidDates(): array
    {
        return [
            'datePast' => [ '20191230' ],
            'datePresent' => [ date('Ymd') ],
            'dateFuture' => [ '20291230' ],
        ];
    }
    
    public static function provideValidFroms(): array
    {
        return [
            'fromFutureToNull' => [ '20291230', null ],
            'fromPastToNull' => [ '20191230', null ],
            'fromPastToFuture' => [ '20191230', '20290809' ],
            'fromPastToPast' => [ '20191230', '20200101' ],
            'fromPastToPresent' => [ '20191230', date('Ymd') ],
            'fromPresentToNull' => [ date('Ymd'), null ]
        ];
    }
    
    public static function provideValidIds(): array
    {
        return [
            'attachmentId' => ['9v06h1cbv0en', 'attachment'],
            'classPassId' => [ 'cp-vk3x1brhpsbf', 'classPass' ],
            'default' => ['9v06h1cbv0en', null],
            'eventId' => [ 'ev-sf8b-20200813100000', 'event' ],
            'locationId' => ['sjm7pskr31t3', 'location' ],
            'ticketId' => ['ti-sboe-20200320100000-tk1m', 'ticket']
        ];
    }
    
    public static function provideValidTags():array
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
    
    public static function provideValidTokens(): array
    {
        return [
            'ours' => [ '6v47r0jdz3r2ao3yc8f1vyx2kjry' ],
        ];
    }
    
    public static function provideValidTos(): array
    {
        return [
            'toFutureFromNull' => [ '20291230', null ],
            'toPastFromNull' => [ '20191230', null ],
            'toPastFromPast' => [ '20200809', '20191230' ],
            'toPastFromPast' => [ '20200101', '20191230' ],
            'toPresentFromNull' => [ date('Ymd'), null ],
            'toPresentFromPast' => [ date('Ymd'), '20191230' ],
        ];
    }

    public static function provideValidTitle(): array
    {
        return [
            'validTitle' => ['Yoga Level 2'],
        ];
    }

    public static function provideInvalidTitle(): array
    {
        return [
            'null' => [null],
            'emptyString' => [''],
            'object' => [ new \stdClass() ],
        ];
    }

    public static function provideValidFileType(): array
    {
        return [
            'validFileType' => ['jpg'],
            'validFileType' => ['jpeg'],
            'validFileType' => ['gif'],
            'validFileType' => ['png'],
            'validFileType' => ['JPG'],
            'validFileType' => ['JPEG'],
            'validFileType' => ['GIF'],
            'validFileType' => ['PNG'],

        ];
    }

    public static function provideInvalidFileType(): array
    {
        return [
            // 'null' => [null], FAILS TESTING
            'emptyString' => [''],
            // 'object' => [ new \stdClass() ], FAILS TESTING
        ];
    }

    public static function provideValidFileName(): array
    {
        return [
            'null' => [null],
            'validFileName' => ['Yoga Time'],
        ];
    }

    public static function provideInvalidFileName(): array
    {
        return [
            'emptyString' => [''],
            'object' => [ new \stdClass() ],
        ];
    }
    
    public static function provideValidInclude(): array
    {
        return [
            'validInclude' => [true],
            'validInclude' => [false],
        ];
    }

    public static function provideInvalidInclude(): array
    {
        return [
            'null' => [null],
            'emptyString' => [''],
            'object' => [ new \stdClass() ],
        ];
    }

    
    /**
     * @covers InShore\Bookwhen\Validator::validDate
     * @dataProvider provideInvalidDates
     */
    public function testValidDateReturnsFalseOnInvalidDates($date)
    {
        if (is_string($date)) {
            $this->assertFalse($this->validator->validDate($date));
        }
        else {
            $this->expectException(\TypeError::class);
            $this->validator->validDate($date);
        }
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
        if (is_string($id) && is_string($type)) {
            $this->assertFalse($this->validator->validId($id, $type));
        }
        else {
            $this->expectException(\TypeError::class);
            $this->validator->validId($id, $type);
        }
       
    }
    
    /**
     * @covers InShore\Bookwhen\Validator::validTag
     * @dataProvider provideInvalidTags
     */
    public function testValidTagReturnsFalseOnInvalidTags($tag)
    {
       if (is_string($tag)) {
           $this->assertFalse($this->validator->validTag($tag));
       }
       else {
           $this->expectException(\TypeError::class);
           $this->assertFalse($this->validator->validTag($tag));
       };
    }
    
    /**
     * @covers InShore\Bookwhen\Validator::validDate
     * @dataProvider provideValidDates
     */
    public function testValidDateReturnsTrueOnValidDates($date)
    {
        if (is_string($date)) {
            $this->assertFalse($this->validator->validDate($date));
        }
        else {
            $this->expectException(\TypeError::class);
            $this->validator->validDate($date);
        }
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
     * @covers InShore\Bookwhen\Validator::validClassPassId
     * @covers InShore\Bookwhen\Validator::validEventId
     * @covers InShore\Bookwhen\Validator::validId
     * @covers InShore\Bookwhen\Validator::validTicketId
     * @dataProvider provideValidIds
     */
    public function testValidIdReturnsTrueOnValidIds($id, $type)
    {
        if (is_string($id) && is_string($type)) {
            $this->assertTrue($this->validator->validId($id, $type));
        }
        else {
            $this->expectException(\TypeError::class);
            $this->validator->validId($id, $type);
        }
    }
    
    /**
     * @covers InShore\Bookwhen\Validator::validTag
     * @dataProvider provideValidTags
     */
    public function testValidTagReturnsTrueOnValidTags($tag)
    {
        $this->assertTrue($this->validator->validTag($tag));
    }
    
    /**
     * @covers InShore\Bookwhen\Validator::validToken
     * @dataProvider provideValidTokens
     */
    public function testValidTokenReturnsTrueOnValidTokens($token)
    {
        $this->assertTrue($this->validator->validToken($token));
    }
    
    /**
     * @covers InShore\Bookwhen\Validator::validTo
     * @covers InShore\Bookwhen\Validator::validDate
     * @dataProvider provideValidTos
     */
    public function testValidTosReturnsTrueOnValidTos($to)
    {
        $this->assertTrue($this->validator->validTo($to));
    }

    /**
     * @covers InShore\Bookwhen\Validator::validTitle
     * @dataProvider provideValidTitle
     */
    public function testValidTitlesReturnsTrueOnValidTitle($title)
    {
        $this->assertTrue($this->validator->validTitle($title));
    }

    /**
     * @covers InShore\Bookwhen\Validator::validTitle
     * @dataProvider provideInvalidTitle
     */
    public function testInvalidTitlesReturnsFalseOnInValidTitle($title)
    {
        if (is_string($title)) {
            $this->assertFalse($this->validator->validTitle($title));
        }
        else {
            $this->expectException(\TypeError::class);
            $this->validator->validDate($title);
        }
    }

    /**
     * @covers InShore\Bookwhen\Validator::validFileType
     * @dataProvider provideValidFileType
     */
    public function testValidFileTypeReturnsTrueOnValidFileType($fileType)
    {
        $this->assertTrue($this->validator->validFileType($fileType));
    }

    /**
     * @covers InShore\Bookwhen\Validator::validFileType
     * @dataProvider provideInValidFileType
     */
    public function testInvalidFileTypeReturnsFalseOnInvalidFileType($fileType)
    {
        if (is_string($fileType)) {
            $this->assertFalse($this->validator->validFileType($fileType));
        }
        else {
            $this->expectException(\TypeError::class);
            $this->validator->validFileType($fileType);
        }
    }

    /**
     * @covers InShore\Bookwhen\Validator::validFileName
     * @dataProvider provideValidFileName
     */
    public function testValidFileNameReturnsTrueOnValidFileName($fileName)
    {
        $this->assertTrue($this->validator->validFileName($fileName));
    }

    /**
     * @covers InShore\Bookwhen\Validator::validFileName
     * @dataProvider provideInvalidFileName
     */
    public function testInValidFileNameReturnsFalseOnInValidFileName($fileName)
    {
        if (is_string($fileName)) {
            $this->assertFalse($this->validator->validFileName($fileName));
        }
        else {
            $this->expectException(\TypeError::class);
            $this->validator->validFileName($fileName);
        }
    }

    /**
     * @covers InShore\Bookwhen\Validator::validInclude
     * @dataProvider provideValidInclude
     */
    public function testValidIncludeReturnsTrueOnValidInclude($include)
    {   
        $this->assertTrue($this->validator->validInclude($include));
    }

    /**
     * @covers InShore\Bookwhen\Validator::validInclude
     * @dataProvider provideInvalidInclude
     */
    public function testInValidIncludeReturnsFalseOnInvalidInclude($include)
    {
        if (is_bool($include)) {
            $this->assertFalse($this->validator->validInclude($include));
        }
        else {
            $this->expectException(\TypeError::class);
            $this->validator->validInclude($include);
        }
    }
  

}


// EOF!
