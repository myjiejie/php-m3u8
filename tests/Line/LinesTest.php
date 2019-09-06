<?php

namespace Chrisyue\PhpM3u8\Test\Line;

use Chrisyue\PhpM3u8\Line\Line;
use Chrisyue\PhpM3u8\Line\Lines;
use Chrisyue\PhpM3u8\Stream\StreamInterface;
use PHPUnit\Framework\TestCase;

class LinesTest extends TestCase
{
    public function testValid()
    {
        $stream = $this->prophesize(StreamInterface::class);
        $stream->valid()->shouldBeCalledOnce()->willReturn(false);
        $lines = new Lines($stream->reveal());

        $this->assertSame(false, $lines->valid());

        $tag = 'EXT-X-FOO:1';
        $stream = $this->prophesize(StreamInterface::class);
        $stream->valid()->shouldBeCalledOnce()->willReturn(true);
        $stream->current()->shouldBeCalled()->willReturn($tag);
        $lines = new Lines($stream->reveal());

        $this->assertEquals(true, $lines->valid());
        $this->assertEquals(Line::fromString($tag), $lines->current());
    }
}
