<?php

namespace Tests\Feature;

use Tests\TestCase;
use Werkspot\CompressUrl\Base62;
use Werkspot\CompressUrl\UrlGenerator;

class UrlGeneratorTest extends TestCase
{
    /** @test */
    public function it_should_return_next_possible_url()
    {
        $urlGenerator = new UrlGenerator(new Base62);

        $this->assertEquals('a2', $urlGenerator->next('a1'));
        $this->assertEquals('aZ91Te', $urlGenerator->next('aZ91Td'));
        $this->assertEquals('aZ91Ua', $urlGenerator->next('aZ91T9'));
        $this->assertEquals('aabaa', $urlGenerator->next('aaa99'));
        $this->assertEquals('abaaa', $urlGenerator->next('aa999'));
        $this->assertEquals('baaaa', $urlGenerator->next('a9999'));
        $this->assertEquals('baaaaaaa', $urlGenerator->next('a9999999'));
        $this->assertEquals('aaa', $urlGenerator->next('99'));
        $this->assertEquals('a', $urlGenerator->next(''));
    }
}
