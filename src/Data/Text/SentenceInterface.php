<?php

declare(strict_types=1);

namespace PhpScience\TextRank\Data\Text;

interface SentenceInterface
{
    public function setId(int $id): void;

    public function getId(): int;

    public function setOriginalValue(string $originalValue): void;

    public function getOriginalValue(): string;

    /**
     * @param int[] $vector
     */
    public function setVector(array $vector): void;

    /**
     * @return int[]
     */
    public function getVector(): array;

    public function isIndexExists(int $index): bool;

    public function getTokenId(int $index): int;
}
