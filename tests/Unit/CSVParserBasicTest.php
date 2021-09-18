<?php

namespace Webasics\CsvParser\Test\Unit;

use PHPUnit\Framework\TestCase;
use Webasics\CsvParser\CSV;
use Webasics\CsvParser\Exception\FileNotFoundException;

class CSVParserBasicTest extends TestCase
{

    /**
     * @test
     * @covers \Webasics\CsvParser\CSV
     */
    public function itShouldRenderTwoColumnsWithAHeaderFromString()
    {
        $result = CSV::parseFromString(<<<CSV
header1,header2,header3
column1,column2,column3
column1,column2,column3
CSV);

        $this->assertCount(2, $result);
        $this->assertCount(3, $result[0], 'Got the row as string, it seems that the delimiter is wrong.');
    }

    /**
     * @test
     * @covers \Webasics\CsvParser\CSV
     */
    public function itShouldRenderTwoColumnsWithoutAHeaderFromString()
    {
        $result = CSV::parseFromString(<<<CSV
column1,column2,column3
column1,column2,column3
CSV, false);

        $this->assertCount(2, $result);
        $this->assertCount(3, $result[0], 'Got the row as string, it seems that the delimiter is wrong.');
    }

    /**
     * @test
     * @covers \Webasics\CsvParser\CSV
     */
    public function itShouldRenderTwoColumnsWithHeaderFromFile()
    {
        $result = CSV::parseFromFile(__DIR__ . '/../fixtures/two-columns-with-header.csv');
        $this->assertCount(2, $result);
        $this->assertCount(3, $result[0], 'Got the row as string, it seems that the delimiter is wrong.');
    }

    /**
     * @test
     * @covers \Webasics\CsvParser\CSV
     */
    public function itShouldRenderTwoColumnsWithoutHeaderFromFile()
    {
        $result = CSV::parseFromFile(__DIR__ . '/../fixtures/two-columns-without-header.csv', false);
        $this->assertCount(2, $result);
        $this->assertCount(3, $result[0], 'Got the row as string, it seems that the delimiter is wrong.');
    }

    /**
     * @test
     * @covers \Webasics\CsvParser\CSV
     * @covers \Webasics\CsvParser\Exception\FileNotFoundException
     * @throws FileNotFoundException
     */
    public function itShouldThrowAnExceptionBecauseOfMissingFile()
    {
        $this->expectException(FileNotFoundException::class);
        CSV::parseFromFile(__DIR__ . '/../fixtures/non-existent.csv');
    }

}