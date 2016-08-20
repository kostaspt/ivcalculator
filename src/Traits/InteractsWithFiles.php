<?php

namespace IVCalculator\Traits;

use Illuminate\Support\Collection;

trait InteractsWithFiles
{
    private function loadDataFile($filename)
    {
        return new Collection(
            $this->parseFile(__DIR__ . '/../../data/' . $filename)
        );
    }

    /**
     * Parse a JSON file.
     *
     * @param $file
     * @return mixed
     */
    private function parseFile($file)
    {
        return json_decode(
            file_get_contents($file)
        );
    }
}
