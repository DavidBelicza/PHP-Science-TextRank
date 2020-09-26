<?php

declare(strict_types=1);

namespace PhpScience\TextRank\Data\Text;

interface TokenMapInterface
{
    /**
     * @param string[] $tokenMap
     */
    public function setTokenMap(array $tokenMap): void;

    public function isExists(int $tokenId): bool;

    public function getToken(int $tokenId): string;
}
