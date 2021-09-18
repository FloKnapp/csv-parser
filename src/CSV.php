<?php

namespace Webasics\CsvParser;

use Webasics\CsvParser\Exception\FileNotFoundException;
use Webasics\CsvParser\Exception\HeaderColumnMismatchException;

/**
 * @package Webasics\CsvParser
 * @author Flo Knapp <office@florianknapp.de>
 */
class CSV
{

    public const SEPARATOR_DEFAULT = ',';
    public const SEPARATOR_SEMICOLON = ';';

    public const ENCLOSURE_DEFAULT = '"';
    public const ENCLOSURE_SINGLE_QUOTE = '\'';

    public const ESCAPE_DEFAULT = '\\';

    /**
     * @param string $filename
     * @param bool   $hasHeader
     * @param string $separator
     * @param string $enclosure
     * @param string $escape
     * @return array
     */
    public static function parseFromFile(
        string $filename,
        bool $hasHeader = true,
        string $separator = self::SEPARATOR_DEFAULT,
        string $enclosure = self::ENCLOSURE_DEFAULT,
        string $escape = self::ESCAPE_DEFAULT
    ): array {

        if (!\file_exists($filename)) {
            throw new FileNotFoundException("File $filename couldn't be found.");
        }

        $data = file_get_contents($filename);
        return static::parse($data, $hasHeader, $separator, $enclosure, $escape);

    }

    /**
     * @param string $data
     * @param bool   $hasHeader
     * @param string $separator
     * @param string $enclosure
     * @param string $escape
     * @return array
     */
    public static function parseFromString(
        string $data,
        bool $hasHeader = true,
        string $separator = self::SEPARATOR_DEFAULT,
        string $enclosure = self::ENCLOSURE_DEFAULT,
        string $escape = self::ESCAPE_DEFAULT
    ): array {

        return static::parse($data, $hasHeader, $separator, $enclosure, $escape);

    }

    /**
     * @param string $data
     * @param bool   $hasHeader
     * @param string $separator
     * @param string $enclosure
     * @param string $escape
     * @return array
     *
     * @throws HeaderColumnMismatchException
     */
    private static function parse(string $data, bool $hasHeader, string $separator, string $enclosure, string $escape): array
    {
        $header = null;
        $result = [];
        $rows   = str_getcsv($data, PHP_EOL);

        $contents = array_map(function($row) use ($separator, $enclosure, $escape) {
            return str_getcsv(str_replace("\xEF\xBB\xBF", '', $row), $separator, $enclosure, $escape);
        }, $rows);

        if (true === $hasHeader) {
            $header = array_shift($contents);
        }

        foreach ($contents as $row) {

            if (false === $hasHeader) {
                $result[] = $row;
                continue;
            }

            // Throw exception when rows didn't match the amount of header columns
            if (count($row) !== count($header)) {
                throw new HeaderColumnMismatchException('The amount of columns and headers arent\'t the same. Aborting.');
            }

            $result[] = array_combine($header, $row);

        }

        return $result;
    }

}