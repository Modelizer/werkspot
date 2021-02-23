<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Werkspot\CompressUrl\Url;

class UrlGeneratorTest extends TestCase
{
    /** @test */
    public function it_should_get_the_base62_by_letter()
    {
        $url = new Url;

        $this->assertEquals('0', $url->getBase62ByLetter('a'));
        $this->assertEquals('1', $url->getBase62ByLetter('b'));
        $this->assertEquals('26', $url->getBase62ByLetter('A'));
        $this->assertEquals('61', $url->getBase62ByLetter('9'));
    }
    /** @test */
    public function it_should_get_the_base62_index()
    {
        $url = new Url;

        $this->assertEquals('a', $url->getBase62ByIndex('0'));
        $this->assertEquals('b', $url->getBase62ByIndex('1'));
        $this->assertEquals('A', $url->getBase62ByIndex('26'));
        $this->assertEquals('9', $url->getBase62ByIndex('61'));
    }

    /** @test */
    public function it_should_return_next_possible_url()
    {
        $url = new Url;

        $this->assertEquals('a2', $url->compress('a1'));
        $this->assertEquals('aZ91Te', $url->compress('aZ91Td'));
        $this->assertEquals('aZ91Ua', $url->compress('aZ91T9'));
        $this->assertEquals('aabaa', $url->compress('aaa99'));
        $this->assertEquals('abaaa', $url->compress('aa999'));
        $this->assertEquals('baaaa', $url->compress('a9999'));
        $this->assertEquals('baaaaaaa', $url->compress('a9999999'));
        $this->assertEquals('aaa', $url->compress('99'));
        $this->assertEquals('a', $url->compress(''));
    }

    /** @test */
    public function it_should_check_request()
    {
        // This is a sample test to know if we use mt_rand to generate a random number between 1 to 100. Then the
        // probability of sending ~30% request is much closer in sending 1000 or more requests.
        // The more requests more data will be more accurate.
        $werkspotUrlCompressRequests = 0;

        // 10000 is the total request we sent
        for ($i = 1; $i <= 10000; $i++) {
            mt_rand(1, 100) <= 30 ? $werkspotUrlCompressRequests++ : null;
        }

        $roundingPercentage = ceil($werkspotUrlCompressRequests / 100);

        // This shows the percentage is between 29,30 and 31.
        $this->assertTrue(in_array($roundingPercentage, [29, 30, 31]));
    }
}
