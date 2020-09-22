<?php

declare(strict_types=1);

namespace PhpScience\TextRank\Builder;

use PhpScience\TextRank\Data\TextInterface;

interface TextBuilderInterface
{
    public function build(array $originalSentences, array $textMap): TextInterface;
}
