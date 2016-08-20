<?php

namespace IVCalculator\Traits;

trait InteractsWithFiles
{
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
