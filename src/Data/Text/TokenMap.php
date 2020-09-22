<?php

declare(strict_types=1);

namespace PhpScience\TextRank\Data\Text;

class TokenMap implements TokenMapInterface
{
    private array $tokenMap = [];

    public function setTokenMap(array $tokenMap): void
    {
        $this->tokenMap = $tokenMap;
    }

    public function isExists(int $tokenId): bool
    {
        return isset($this->tokenMap[$tokenId]);
    }

    public function getToken(int $tokenId): string
    {
        return $this->tokenMap[$tokenId];
    }
}
