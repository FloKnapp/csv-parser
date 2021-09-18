<?php

namespace Webasics\CsvParser\Test\Unit;

use PHPUnit\Framework\TestCase;
use Webasics\CsvParser\CSV;
use Webasics\CsvParser\Exception\HeaderColumnMismatchException;

class CSVParserExtendedTest extends TestCase
{

    /**
     * @test
     * @covers \Webasics\CsvParser\CSV
     */
    public function itShouldRenderTwoColumnsWithDifferentSeparator()
    {
        $result = CSV::parseFromString(<<<CSV
header1;header2;header3
column1;column2;column3
column1;column2;column3
CSV, true, CSV::SEPARATOR_SEMICOLON);

        $this->assertCount(2, $result);
        $this->assertCount(3, $result[0], 'Got the row as string, it seems that the delimiter is wrong.');
    }

    /**
     * @test
     * @covers \Webasics\CsvParser\CSV
     * @covers \Webasics\CsvParser\Exception\HeaderColumnMismatchException
     */
    public function itShouldThrowExceptionWhenHeaderAndColumnCountMismatch()
    {
        $this->expectException(HeaderColumnMismatchException::class);

        CSV::parseFromString(<<<CSV
header1,header2,header3
column1,column2,column3
column1,column2
CSV);
    }

}