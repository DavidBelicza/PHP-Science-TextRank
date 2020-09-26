<?php

declare(strict_types=1);

namespace PhpScience\TextRank\Data;

interface RankDataObjectInterface
{
    public function setId(int $id): void;

    public function getId(): int;

    public function setValue(string $value): void;

    public function getValue(): string;

    public function setRank(float $rank): void;

    public function getRank(): float;
}
