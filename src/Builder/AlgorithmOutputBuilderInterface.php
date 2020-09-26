<?php

declare(strict_types=1);

namespace PhpScience\TextRank\Builder;

use PhpScience\PageRank\Data\NodeCollectionInterface;
use PhpScience\TextRank\Data\TextInterface;
use PhpScience\TextRank\Data\AlgorithmOutputInterface;

interface AlgorithmOutputBuilderInterface
{
    public function build(
        TextInterface $text,
        NodeCollectionInterface $nodeCollection,
        array $sentences,
        int  $maxKeywords,
        int $maxSentences
    ): AlgorithmOutputInterface;
}
