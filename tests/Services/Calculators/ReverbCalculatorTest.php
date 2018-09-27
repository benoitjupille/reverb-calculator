<?php

namespace App\Tests\Services\Calculators;

use PHPUnit\Framework\TestCase;
use App\Services\Converters\BpmToMillisecondsConverter;
use App\Services\Calculators\ReverbCalculator;

class BpmToMillisecondsConverterTest extends TestCase
{

    private $service;

    /**
     * @todo : how to use dependency injection "manually" ?
     */
    protected function setUp()
    {
        $bpmToMillisecondsConverter = new BpmToMillisecondsConverter();
        $this->service = new ReverbCalculator($bpmToMillisecondsConverter);
    }

    /**
     * Valid cases
     *
     * @return array
     */
    public function provideGoodCases()
    {
        return [
            [70, 100, "4/4", 757],
            [70, 29, "8/4", 400],
            [120, 0, "8/8", 500],
        ];
    }

    /**
     * @dataProvider provideGoodCases
     */
    public function testCalculate($bpm, $preDelay, $signature, $expectation)
    {
        $milliseconds = $this->service->calculate($bpm, $preDelay, $signature);
        $this->assertEquals($milliseconds, $expectation);
    }
}
