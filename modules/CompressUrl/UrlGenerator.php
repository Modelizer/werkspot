<?php

namespace Werkspot\CompressUrl;

class UrlGenerator
{
    protected Base62 $base62;

    public function __construct(Base62 $base62)
    {
        $this->base62 = $base62;
    }

    public function next(string $currentUrl): string
    {
        $currentUrl = str_split($currentUrl);

        return $this->nextBase62Letter(array_pop($currentUrl), $currentUrl);
    }

    protected function nextBase62Letter(string $currentLetter = null, array $previousLetters = []): string
    {
        // First base letter is "a"
        $firstBaseLetter = $this->base62->byIndex(0);

        if (! $currentLetter) {
            return $firstBaseLetter . implode($previousLetters);
        }

        if (! $nextLetter = $this->base62->byIndex($this->base62->byLetter($currentLetter) + 1)) {
            return $this->nextBase62Letter(array_pop($previousLetters), $previousLetters) . $firstBaseLetter;
        }

        return implode($previousLetters) . $nextLetter;
    }
}
