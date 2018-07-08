<?php

namespace Tests\Unit\Parser;

use RuntimeException;
use App\Parser\TagParser;
use PHPUnit\Framework\TestCase;
use Mockery as m;

class TagParserTest extends TestCase
{
    /** @var MetaParser */
    public $parser;

    public function setUp()
    {
        parent::setUp();

        $this->parser = new TagParser;
    }

    public function tearDown()
    {
        parent::tearDown();

        m::close();
    }

    /** @test */
    function it_will_throw_an_exception_if_the_number_of_attributes_is_less_than_the_number_of_values()
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('The number of attribute is less than the number of values. Attribute: [`key1`]. Values: [`value3`, `value4`].');

        $this->partial($this->parser)->combine(['key1'], ['value3', 'value4']);
    }

    /** @test */
    function it_replaces_empty_values_with_null()
    {
        $expected = ['a', 'b', null, 'c', '0'];

        $actual = $this->partial($this->parser)->filterValues(['a', 'b', '', 'c', '0']);

        $this->assertSame($expected, $actual);
    }

    /** @test */
    function it_returns_the_tags_values_keyed_by_attribute()
    {
        $content = '
            <a href="/users/3887771">qwerty03</a>
            <a href="/finances">Money:</a>
        ';

        $expected = [
            'href="/users/3887771"' => 'qwerty03',
            'href="/finances"' => 'Money:',
        ];

        $this->assertSame($expected, $this->parser->__invoke($content, 'a'));
    }

    /** @test */
    function it_returns_the_tags_keyed_by_attribute_with_null_values()
    {
        $content = '
            <a href="/users/3887771">qwerty03</a>
            <a href="/finances"></a>
        ';

        $expected = [
            'href="/users/3887771"' => 'qwerty03',
            'href="/finances"' => null,
        ];

        $this->assertSame($expected, $this->parser->__invoke($content, 'a'));
    }

    public function partial($object)
    {
        return m::mock($object)->makePartial()->shouldAllowMockingProtectedMethods();
    }
}
