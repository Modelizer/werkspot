<?php

namespace Werkspot\CompressUrl\Drivers;

use Shivella\Bitly\Client\BitlyClient;
use Shivella\Bitly\Exceptions\AccessDeniedException;
use Shivella\Bitly\Exceptions\InvalidResponseException;

class BitlyUrlDriver implements UrlCompressorDriverContract
{
    public function __construct(protected BitlyClient $client)
    {
        //
    }

    public function store(string $redirectUrl): string
    {
        try {
            return $this->client->getUrl($redirectUrl);
        } catch (AccessDeniedException | InvalidResponseException $e) {
            // Currently not doing anything to save sometime.
        }
    }

    public function getRedirectUrl(string $shortUrl): string
    {
        return '';
    }

    public function getShortUrl(string $redirectUrl): string
    {
        return '';
    }
}
