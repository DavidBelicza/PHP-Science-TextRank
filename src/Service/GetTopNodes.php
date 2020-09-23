<?php

declare(strict_types=1);

namespace PhpScience\TextRank\Service;

use PhpScience\PageRank\Data\NodeCollectionInterface;

class GetTopNodes implements GetTopNodesInterface
{
    public function execute(
        NodeCollectionInterface $nodeCollection,
        int $top
    ): array {
        $nodes = array_values($nodeCollection->getNodes());
        $size = count($nodes);

        for ($i = 0; $i < $size; $i++) {
            for ($j = 0; $j < $size; $j++) {
                if ($nodes[$i]->getRank() > $nodes[$j]->getRank()) {
                    $tmp = $nodes[$i];
                    $nodes[$i] = $nodes[$j];
                    $nodes[$j] = $tmp;
                }
            }
        }

        return $nodes;
    }
}
