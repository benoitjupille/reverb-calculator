<?php

namespace App\Services\Converters;

/**
 * This service gives tool to convert Beat Per Minute of a song to 
 * note lengths in milliseconds, depending on the time signature
 */
class BpmToMillisecondsConverter
{

    protected $bpm;
    protected $signature;
    protected $beat;
    protected $kind;

    /**
     * Gives you the time in milliseconds between each pulse
     *
     * @param float $bpm beats per minutes
     * @param string signature
     *
     * @return int
     */
    public function convert(float $bpm, string $signature = "4/4")
    {
        $this->bpm = $bpm;
        $this->signature = $signature;
        $this->checkBpm();
        $this->unserializeSignature();

        return round(60000 / $bpm);
    } 

    private function checkBpm()
    {
        if ($this->bpm < 1) {
            throw new \Exception("The bpm can't be lower than 1 bpm");
        }

        return $this;
    }

    private function unserializeSignature()
    {
        $exploded = explode("/", $this->signature);

        if (!is_array($exploded)) {
            throw new \Exception("The signature can't be readen");
        }

        if (sizeof($exploded) !== 2) {
            throw new \Exception("The signature is not valid");
        }

        $this->beat = $exploded[0];
        $this->kind = $exploded[1];

        return $this;
    }
}
