<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Werkspot\CompressUrl\Base62;

class Base62Test extends TestCase
{
    /** @test */
    public function it_should_get_the_base62_by_letter()
    {
        $base62 = new Base62;

        $this->assertEquals('0', $base62->byLetter('a'));
        $this->assertEquals('1', $base62->byLetter('b'));
        $this->assertEquals('26', $base62->byLetter('A'));
        $this->assertEquals('61', $base62->byLetter('9'));
    }

    /** @test */
    public function it_should_get_the_base62_index()
    {
        $base62 = new Base62;

        $this->assertEquals('a', $base62->byIndex('0'));
        $this->assertEquals('b', $base62->byIndex('1'));
        $this->assertEquals('A', $base62->byIndex('26'));
        $this->assertEquals('9', $base62->byIndex('61'));
    }
}
