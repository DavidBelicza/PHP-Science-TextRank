<?php

declare(strict_types=1);

namespace PhpScience\TextRank\Service;

use PhpScience\PageRank\Data\NodeCollectionInterface;
use PhpScience\PageRank\Data\NodeInterface;

interface GetTopNodesInterface
{
    /**
     * @param NodeCollectionInterface $nodeCollection
     * @param int                     $top
     *
     * @return NodeInterface[]
     */
    public function execute(
        NodeCollectionInterface $nodeCollection,
        int $top
    ): array;
}
