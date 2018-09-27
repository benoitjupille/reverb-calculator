<?php

namespace App\Services\Converters;

/**
 * This service gives tool to convert Beat Per Minute of a song to 
 * note lengths in milliseconds, depending on the time signature
 */
class BpmToMillisecondsConverter
{

    /*
     * @var float given Beats Per Minute
     */
    protected $bpm;

    /*
     * @var string the signature of the song
     */
    protected $signature;

    /**
     * @var int the number of pulse for bar 
     */
    protected $beat;

    /**
     * @var length of the bar
     */
    protected $bar;

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

        return $this->compute();
    } 

    /**
     * Check the validity of the given BPM
     *
     * @throws \Exception
     * @return self
     */
    private function checkBpm()
    {
        if ($this->bpm < 1) {
            throw new \Exception("The bpm can't be lower than 1 bpm");
        }

        return $this;
    }

    /**
     * Check the validity of the given signature and split it 
     * in two values
     *
     * @throws \Exception
     * @return self
     */
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
        $this->bar = $exploded[1];

        return $this;
    }

    private function compute()
    {
        return round((60000 / $this->bpm) / ($this->beat / $this->bar));
    }
}
