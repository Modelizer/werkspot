<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JetBrains\PhpStorm\NoReturn;
use Tests\TestCase;
use Werkspot\CompressUrl\Drivers\WerkspotUrlDriver;

class UrlShortenerControllerTest extends TestCase
{
    use WithFaker;

    /** @test */
    public function it_should_return_a_short_url()
    {
        $response = $this->post('/api/url', [
            'url' => $this->faker->url,
        ]);

        $response->assertStatus(200);
        $content = json_decode($response->content(), true);
        $this->assertArrayHasKey('message', $content);
        $this->assertArrayHasKey('shorter-url', $content);
    }

    /** @test */
    public function it_should_return_already_saved_url()
    {
        $redirectUrl = $this->faker->url;
        $driver = $this->app->get(WerkspotUrlDriver::class);
        $shortUrl = url($driver->store($redirectUrl));

        $response = $this->post('/api/url', [
            'url' => $redirectUrl,
        ]);

        $response->assertStatus(200);
        $content = json_decode($response->content(), true);
        $this->assertEquals('Url already exists.', $content['message']);
        $this->assertEquals($shortUrl, $content['shorter-url']);
    }
}
