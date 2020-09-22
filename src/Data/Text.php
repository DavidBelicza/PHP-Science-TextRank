<?php

declare(strict_types=1);

namespace PhpScience\TextRank\Data;

use PhpScience\TextRank\Data\Text\TokenMapInterface;

class Text implements TextInterface
{
    private TokenMapInterface $tokenMap;
    private array             $sentences;

    public function __construct(
        TokenMapInterface $tokenMap,
        array $sentences
    ) {
        $this->tokenMap = $tokenMap;
        $this->sentences = $sentences;
    }

    public function getTokenMap(): TokenMapInterface
    {
        return $this->tokenMap;
    }

    public function getSentences(): array
    {
        return $this->sentences;
    }
}
