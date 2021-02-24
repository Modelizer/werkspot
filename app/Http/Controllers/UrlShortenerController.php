<?php

namespace App\Http\Controllers;

use App\Http\Requests\UrlShortenerRequest;
use Illuminate\Http\JsonResponse;
use Werkspot\CompressUrl\Drivers\UrlCompressorDriverContract;
use Werkspot\CompressUrl\Exceptions\UrlNotFoundException;

class UrlShortenerController extends Controller
{
    public function index($shortUrl, UrlCompressorDriverContract $urlCompressor)
    {
        try {
            return redirect()->to($urlCompressor->getRedirectUrl($shortUrl));
        } catch (UrlNotFoundException $exception) {
            abort(404);
        }
    }

    public function store(UrlShortenerRequest $request, UrlCompressorDriverContract $urlCompressor): JsonResponse
    {
        $shorterUrl = $urlCompressor->store($request['url']);

        return new JsonResponse([
            'message' => 'Successfully stored the URL.',
            'shorter-url' => url($shorterUrl),
        ]);
    }
}
