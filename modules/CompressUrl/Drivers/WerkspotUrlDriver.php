<?php

namespace Werkspot\CompressUrl\Drivers;

use Illuminate\Contracts\Redis\Factory;
use Redis;
use Werkspot\CompressUrl\Exceptions\UrlNotFoundException;
use Werkspot\CompressUrl\UrlGenerator;

class WerkspotUrlDriver implements UrlCompressorDriverContract
{
    protected Redis $redis;

    public function __construct(Factory $redis, protected UrlGenerator $urlGenerator)
    {
        $this->redis = $redis->connection('url')->client();
    }

    public function store(string $redirectUrl): string
    {
        try {
            return $this->getShortUrl($redirectUrl);
        } catch (UrlNotFoundException $exception) {
            // Getting last saved short url so that we can know next url to generator.
            // Saving short and redirect url.
            $lastShortUrl = $this->redis->get('last-shorter-url-added') ?: '';
            $shortUrl = $this->urlGenerator->next($lastShortUrl);
            $this->redis->hSet('short-url', md5($redirectUrl), $shortUrl);
            $this->redis->hSet('redirect-url', $shortUrl, $redirectUrl);

            // Overriding last short url.
            $this->redis->del('last-shorter-url-added');
            $this->redis->set('last-shorter-url-added', $shortUrl);

            return $shortUrl;
        }
    }

    public function getRedirectUrl(string $shortUrl): string
    {
        if ($actualUrl = $this->redis->hGet('redirect-url', $shortUrl)) {
            return $actualUrl;
        }

        throw new UrlNotFoundException;
    }

    public function getShortUrl(string $redirectUrl): string
    {
        $hash = md5($redirectUrl);

        if ($this->redis->hExists('short-url', $hash)) {
            return $this->redis->hGet('short-url', $hash);
        }

        throw new UrlNotFoundException;
    }
}
