<?php

declare(strict_types=1);

namespace PhpScience\TextRank\Builder;

use PhpScience\TextRank\Data\StopWordCollectionInterface;

interface StopWordCollectionBuilderInterface
{
    public function build(string $path): StopWordCollectionInterface;
}
