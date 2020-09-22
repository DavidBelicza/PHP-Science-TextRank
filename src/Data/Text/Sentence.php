<?php

declare(strict_types=1);

namespace PhpScience\TextRank\Data\Text;

class Sentence implements SentenceInterface
{
    private array $vector = [];

    public function setVector(array $vector): void
    {
        $this->vector = $vector;
    }

    public function getVector(): array
    {
        return $this->vector;
    }

    public function isIndexExists(int $index): bool
    {
        return isset($this->vector[$index]);
    }

    public function getTokenId(int $index): int
    {
        return $this->vector[$index];
    }
}
