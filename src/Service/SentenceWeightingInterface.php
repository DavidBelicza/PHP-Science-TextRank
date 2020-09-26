<?php

declare(strict_types=1);

namespace PhpScience\TextRank\Service;

use PhpScience\PageRank\Data\NodeCollectionInterface;
use PhpScience\TextRank\Data\RankDataObjectInterface;
use PhpScience\TextRank\Data\TextInterface;

interface SentenceWeightingInterface
{
    /**
     * @param TextInterface           $text
     * @param NodeCollectionInterface $nodeCollection
     *
     * @return RankDataObjectInterface[]
     */
    public function weight(
        TextInterface $text,
        NodeCollectionInterface $nodeCollection
    ): array;
}
