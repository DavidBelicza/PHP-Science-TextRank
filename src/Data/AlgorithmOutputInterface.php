<?php

declare(strict_types=1);

namespace PhpScience\TextRank\Data;

interface AlgorithmOutputInterface
{
    /**
     * @param RankDataObjectInterface[] $keywords
     */
    public function setKeyWords(array $keywords): void;

    /**
     * @return RankDataObjectInterface[]|null
     */
    public function getKeyWords(): ?array;

    /**
     * @param RankDataObjectInterface[] $sentences
     */
    public function setSentences(array $sentences): void;

    /**
     * @return RankDataObjectInterface[]|null
     */
    public function getSentences(): ?array;

}
