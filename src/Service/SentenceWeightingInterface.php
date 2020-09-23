<?php

declare(strict_types=1);

namespace PhpScience\TextRank\Service;

use PhpScience\TextRank\Data\TextInterface;
use PhpScience\TextRank\Data\TextRankOutput\OutputValueInterface;

interface SentenceWeightingInterface
{
    /**
     * @param TextInterface          $text
     * @param OutputValueInterface[] $keywords
     *
     * @return OutputValueInterface[]
     */
    public function weight(TextInterface $text, array $keywords): array;
}
