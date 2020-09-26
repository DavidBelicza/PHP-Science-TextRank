<?php

declare(strict_types=1);

namespace PhpScience\TextRank\Service;

use PhpScience\PageRank\Data\NodeInterface;
use PhpScience\TextRank\Data\RankDataObjectInterface;

interface SortRankDataListInterface
{
    /**
     * @param NodeInterface[]|RankDataObjectInterface $rankDataList
     *
     * @return NodeInterface[]|RankDataObjectInterface
     */
    public function sort(array $rankDataList): array;
}
