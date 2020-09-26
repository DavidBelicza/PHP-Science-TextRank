<?php

declare(strict_types=1);

namespace PhpScience\TextRank\Data;

use PhpScience\TextRank\Data\Text\SentenceInterface;
use PhpScience\TextRank\Data\Text\TokenMapInterface;

interface TextInterface
{
    public function getTokenMap(): TokenMapInterface;

    /**
     * @return SentenceInterface[]
     */
    public function getSentences(): array;
}
