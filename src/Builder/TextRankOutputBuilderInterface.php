<?php

declare(strict_types=1);

namespace PhpScience\TextRank\Builder;

use PhpScience\PageRank\Data\NodeCollectionInterface;
use PhpScience\TextRank\Data\TextInterface;
use PhpScience\TextRank\Data\TextRankOutputInterface;

interface TextRankOutputBuilderInterface
{
    public function build(
        TextInterface $text,
        NodeCollectionInterface $nodeCollection,
        int  $maxKeywords
    ): TextRankOutputInterface;
}
