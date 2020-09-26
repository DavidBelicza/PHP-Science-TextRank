<?php

declare(strict_types=1);

namespace PhpScience\TextRank\Data;

class RankDataObject implements RankDataObjectInterface
{
    private int    $id;
    private string $value;
    private float  $rank;

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setValue(string $value): void
    {
        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function setRank(float $rank): void
    {
        $this->rank = $rank;
    }

    public function getRank(): float
    {
        return $this->rank;
    }
}
