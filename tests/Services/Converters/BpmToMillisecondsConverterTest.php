<?php

namespace App\Tests\Services\Converters;

use PHPUnit\Framework\TestCase;
use App\Services\Converters\BpmToMillisecondsConverter;

class BpmToMillisecondsConverterTest extends TestCase
{

    private $service;

    protected function setUp()
    {
        $this->service = new BpmToMillisecondsConverter();
    }

    /**
     * Bad cases : non valid inputs
     *
     * @return array
     */
    public function provideBadCases()
    {
        return [
            [120, "4"],
            [120, "4/4/4"],
            [120, "4 4"],
            [0, "4/4"],
            [-10, "4/4"],
        ];
    }

    /**
     * @dataProvider provideBadCases
     */
    public function testConvertWithBadCases($bpm, $signature)
    {
        $this->expectException(\Exception::class);
        $this->service->convert($bpm, $signature);
    }

    /**
     * Valid cases
     *
     * @return array
     */
    public function provideGoodCases()
    {
        return [
            [70, "4/4", 857],
        ];
    }

    /**
     * @dataProvider provideGoodCases
     */
    public function testConvert($bpm, $signature, $expectation)
    {
        $milliseconds = $this->service->convert($bpm, $signature);
        $this->assertEquals($milliseconds, $expectation);
    }
}
