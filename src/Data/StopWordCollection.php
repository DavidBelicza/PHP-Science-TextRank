<?php

declare(strict_types=1);

namespace PhpScience\TextRank\Data;

class StopWordCollection implements StopWordCollectionInterface
{
    private array $words = [];

    public function __construct(array $words)
    {
        $this->words = $words;
    }

    public function isExist(string $word): bool
    {
        return array_search($word, $this->words) !== false;
    }
}
