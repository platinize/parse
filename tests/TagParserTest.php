<?php

namespace Tests\Unit\Parser;

use RuntimeException;
use App\Parser\MetaParser;
use PHPUnit\Framework\TestCase;
use Mockery as m;

class MetaParserTest extends TestCase
{
    /** @var MetaParser */
    public $parser;

    public function setUp()
    {
        parent::setUp();

        $this->parser = new MetaParser;
    }

    public function tearDown()
    {
        parent::tearDown();

        m::close();
    }

    /** @test */
    function it_will_throw_an_exception_if_the_number_of_props_is_less_than_the_number_of_values()
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('The number of props is less than the number of values. Props: [`key`]. Values: [`value1`, `value2`].');

        $this->partial($this->parser)->combine(['key'], ['value1', 'value2']);
    }

    /** @test */
    function it_replaces_empty_values_with_null()
    {
        $expected = ['a', 'b', null, 'c', '0'];

        $actual = $this->partial($this->parser)->filterValues(['a', 'b', '', 'c', '0']);

        $this->assertSame($expected, $actual);
    }

    /** @test */
    function it_returns_the_meta_data_keyed_by_name()
    {
        $content = '
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <meta name="referrer" content="always">
        ';

        $expected = [
            'viewport' => 'width=device-width, initial-scale=1',
            'referrer' => 'always',
        ];

        $this->assertSame($expected, $this->parser->__invoke($content));
    }

    /** @test */
    function it_returns_the_meta_date_keyed_by_name_with_null_values()
    {
        $content = '
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <meta name="referrer">
        ';

        $expected = [
            'viewport' => 'width=device-width, initial-scale=1',
            'referrer' => null,
        ];

        $this->assertSame($expected, $this->parser->__invoke($content));
    }

    public function partial($object)
    {
        return m::mock($object)->makePartial()->shouldAllowMockingProtectedMethods();
    }
}
