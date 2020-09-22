<?php

declare(strict_types=1);

namespace PhpScience\TextRank\Strategy;

use PhpScience\PageRank\Data\NodeCollectionInterface;
use PhpScience\TextRank\Data\TextInterface;

interface RankingAlgorithmStrategyInterface
{
    public function rank(TextInterface $text): NodeCollectionInterface;
}
