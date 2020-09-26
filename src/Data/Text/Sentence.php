<?php

declare(strict_types=1);

namespace PhpScience\TextRank\Data\Text;

class Sentence implements SentenceInterface
{
    private array  $vector = [];
    private int    $id;
    private string $originalValue;

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setOriginalValue(string $originalValue): void
    {
        $this->originalValue = $originalValue;
    }

    public function getOriginalValue(): string
    {
        return $this->originalValue;
    }

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
