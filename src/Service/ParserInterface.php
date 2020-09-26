<?php

declare(strict_types=1);

namespace PhpScience\TextRank\Service;

use PhpScience\TextRank\Data\TextInterface;

interface ParserInterface
{
    public function parse(string $rawText, string $stopWordsPath): TextInterface;
}
