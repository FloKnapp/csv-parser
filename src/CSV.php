<?php

namespace Webasics\CsvParser;

/**
 * @package Webasics\CsvParser
 * @author Flo Knapp <office@florianknapp.de>
 */
class CSV
{
    /**
     * @param string $filename
     * @param string $separator
     * @param string $enclosure
     * @param string $escape
     * @return array
     */
    public static function parseFromFile(string $filename, string $separator = ',', string $enclosure = '"', string $escape = '\\'): array
    {
        if (!\file_exists($filename)) {
            throw new \LogicException("File $filename couldn't be found.");
        }

        $data = file_get_contents($filename);
        return static::parse($data, $separator, $enclosure, $escape);
    }

    /**
     * @param string $data
     * @param string $separator
     * @param string $enclosure
     * @param string $escape
     * @return array
     */
    public static function parseFromString(string $data, string $separator = ',', string $enclosure = '"', string $escape = '\\'): array
    {
        return static::parse($data, $separator, $enclosure, $escape);
    }

    /**
     * @param string $data
     * @param string $separator
     * @param string $enclosure
     * @param string $escape
     * @return array
     */
    private static function parse(string $data, string $separator = ',', string $enclosure = '"', string $escape = '\\'): array
    {
        $result = [];
        $rows   = str_getcsv($data, PHP_EOL);

        $contents = array_map(function($row) use ($separator, $enclosure, $escape) {
            return str_getcsv(str_replace("\xEF\xBB\xBF", '', $row), $separator, $enclosure, $escape);
        }, $rows);

        $header = array_shift($contents);

        foreach ($contents as $rowIndex => $row) {

            if (count($row) !== count($header)) {
                continue;
            }

            $result[] = array_combine($header, $row);

        }

        return $result;
    }

}