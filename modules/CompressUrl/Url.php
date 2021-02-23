<?php

namespace Werkspot\CompressUrl;

class Url
{
    protected array $base62Letter = [];

    protected array $base62Index = [];

    public function __construct()
    {
        $this->base62Letter = array_flip(
            array_merge(range('a', 'z'), range('A', 'Z'), range(0, 9))
        );

        $this->base62Index = array_combine(range(0, 61), array_keys($this->base62Letter));
    }

    public function getBase62ByLetter(string $letter): string
    {
        return $this->base62Letter[$letter];
    }

    public function getBase62ByIndex(string $index): string
    {
        return $this->base62Index[$index];
    }

    public function compress(string $currentUrl): string
    {
        $currentUrl = str_split($currentUrl);

        return $this->nextBase62ByLetter(array_pop($currentUrl), $currentUrl);
    }

    protected function nextBase62ByLetter(string $currentLetter = null, array $previousLetters = []): string
    {
        // First base letter is "a"
        $firstBaseLetter = $this->base62Index[0];

        if (! $currentLetter) {
            return $firstBaseLetter . implode($previousLetters);
        }

        if (! $nextLetter = @$this->base62Index[$this->base62Letter[$currentLetter] + 1]) {
            return $this->nextBase62ByLetter(array_pop($previousLetters), $previousLetters) . $firstBaseLetter;
        }

        return implode($previousLetters) . $nextLetter;
    }
}
