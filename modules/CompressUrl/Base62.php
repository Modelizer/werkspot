<?php

namespace Werkspot\CompressUrl;

class Base62
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

    public function byLetter(string $letter):? string
    {
        return @$this->base62Letter[$letter];
    }

    public function byIndex(string $index):? string
    {
        return @$this->base62Index[$index];
    }

}
