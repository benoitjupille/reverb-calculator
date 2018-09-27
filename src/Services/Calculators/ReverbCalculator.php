<?php

namespace App\Services\Calculators;

use App\Services\Converters\BpmToMillisecondsConverter;

/**
 * Service to calculate your decay time from a given bpm, pre-delay and signature
 */
class ReverbCalculator
{

    protected $bpmToMillisecondsConverter;

    public function __construct(BpmToMillisecondsConverter $bpmToMillisecondsConverter)
    {
        $this->bpmToMillisecondsConverter = $bpmToMillisecondsConverter;
    }

    public function calculate($bpm, $preDelay, $signature)
    {
        $decay = $this->bpmToMillisecondsConverter->convert($bpm, $signature);

        return $decay - $preDelay;
    }
}
