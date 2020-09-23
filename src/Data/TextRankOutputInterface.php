<?php

declare(strict_types=1);

namespace PhpScience\TextRank\Data;

use PhpScience\TextRank\Data\TextRankOutput\OutputValueInterface;

interface TextRankOutputInterface
{
    /**
     * @param OutputValueInterface[] $keywords
     */
    public function setKeyWords(array $keywords): void;

    /**
     * @return OutputValueInterface[]|null
     */
    public function getKeyWords(): ?array;

    /**
     * @param OutputValueInterface[] $sentences
     */
    public function setSentences(array $sentences): void;

    /**
     * @return OutputValueInterface[]|null
     */
    public function getSentences(): ?array;

}
