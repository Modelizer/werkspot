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
        $this->urlCompressor = $this->app->get(UrlCompressorDriverContract::class);
    }

    public function handle(Request $request, Closure $next)
    {
        // If URL exists then we need to inform user without processing anything.
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
        static::isGreatorThan30Percent() ?:
            app()->bind(UrlCompressorDriverContract::class, BitlyUrlDriver::class);

        return $next($request);
    }

    public static function isGreatorThan30Percent(): bool
    {
        return mt_rand(1, 100) >= 30;
    }
}
