<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Werkspot\CompressUrl\Drivers\BitlyUrlDriver;
use Werkspot\CompressUrl\Drivers\UrlCompressorDriverContract;
use Werkspot\CompressUrl\Drivers\WerkspotUrlDriver;
use Werkspot\CompressUrl\Exceptions\UrlNotFoundException;

class SplitTesting
{
    protected UrlCompressorDriverContract $urlCompressor;

    public function __construct(protected Application $app, protected UrlGenerator $urlGenerator)
    {
        // Werkspot's url driver is a default url shortener driver.
        $this->app->bind(UrlCompressorDriverContract::class, WerkspotUrlDriver::class);
        $this->urlCompressor = $this->app->get(UrlCompressorDriverContract::class);
    }

    public function handle(Request $request, Closure $next)
    {
        // If URL exists then we need to check do we already have it or not.
        if ($url = $request['url']) {
            try {
                return new JsonResponse([
                    'message' => 'Url already exists.',
                    'shorter-url' => url($this->urlCompressor->getShortUrl($url)),
                ]);
            } catch (UrlNotFoundException $exception) {
                // If the url is not saved then we can move to AB testing
            }
        }

        // Binding Url shortener driver according to 30/70 AB testing rule.
        static::isLessThanThirtyOne() ?:
            app()->bind(UrlCompressorDriverContract::class, BitlyUrlDriver::class);

        return $next($request);
    }

    public static function isLessThanThirtyOne(): bool
    {
        return mt_rand(1, 100) <= 30;
    }
}
