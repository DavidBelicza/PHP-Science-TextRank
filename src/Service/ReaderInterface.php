<?php

declare(strict_types=1);

namespace PhpScience\TextRank\Service;

use Generator;

interface ReaderInterface
{
    public function read(string $path): Generator;
}
