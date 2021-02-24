<?php

namespace Werkspot\CompressUrl\Drivers;

interface UrlCompressorDriverContract
{
    public function store(string $redirectUrl): string;

    public function getRedirectUrl(string $shortUrl): string;

    public function getShortUrl(string $redirectUrl): string;
}
