<?php

declare(strict_types=1);

namespace PhpScience\TextRank\Data;

interface StopWordCollectionInterface
{
    public function isExist(string $word): bool;
}
