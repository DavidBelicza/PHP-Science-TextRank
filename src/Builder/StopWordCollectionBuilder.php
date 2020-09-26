<?php

declare(strict_types=1);

namespace PhpScience\TextRank\Builder;

use PhpScience\TextRank\Data\StopWordCollection;
use PhpScience\TextRank\Data\StopWordCollectionInterface;
use PhpScience\TextRank\Service\ReaderInterface;

class StopWordCollectionBuilder implements StopWordCollectionBuilderInterface
{
    private ReaderInterface $reader;

    public function __construct(
        ReaderInterface $reader
    ) {
        $this->reader = $reader;
    }

    public function build(string $path): StopWordCollectionInterface
    {
        $words = [];

        foreach ($this->reader->read($path) as $row) {
            $words[] = current($row);
        }

        return new StopWordCollection($words);
    }
}
