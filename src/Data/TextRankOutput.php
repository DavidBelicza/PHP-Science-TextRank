<?php

declare(strict_types=1);

namespace PhpScience\TextRank\Data;

class TextRankOutput implements TextRankOutputInterface
{
    private ?array $keyWords;
    private ?array $sentences;

    public function setKeyWords(array $keywords): void
    {
        $this->keyWords = $keywords;
    }

    public function getKeyWords(): ?array
    {
        return $this->keyWords;
    }

    public function setSentences(array $sentences): void
    {
        $this->sentences = $sentences;
    }

    public function getSentences(): ?array
    {
        return $this->sentences;
    }
}
