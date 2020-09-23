<?php

declare(strict_types=1);

namespace PhpScience\TextRank\Service;

use PhpScience\TextRank\Data\StopWordCollection;

class StopWordFilter
{
    private StopWordCollection $stopWordCollection;

    public function __construct(
        StopWordCollection $stopWordCollection
    ) {
        $this->stopWordCollection = $stopWordCollection;
    }

    public function isStopWord(string $word): bool
    {
        return array_search($word, $this->stopWordCollection->words) !== false;
    }
}
