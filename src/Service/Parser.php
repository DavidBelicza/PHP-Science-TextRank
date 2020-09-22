<?php

declare(strict_types=1);

namespace PhpScience\TextRank\Service;

use PhpScience\TextRank\Builder\TextBuilderInterface;
use PhpScience\TextRank\Data\TextInterface;

class Parser
{
    private TextBuilderInterface $textBuilder;

    public function __construct(
        TextBuilderInterface $textBuilder
    ) {
        $this->textBuilder = $textBuilder;
    }

    public function parse(string $rawText): TextInterface
    {
        $sentences = preg_split(
            '/(\n+)|(\.\s|\?\s|\!\s)(?![^\(]*\))/',
            $rawText,
            -1,
            PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE
        );

        $textMap = [];

        foreach ($sentences as $sentenceIndex => $sentence) {
            $tokens = preg_split(
                '/(?:(^\p{P}+)|(\p{P}*\s+\p{P}*)|(\p{P}+$))/',
                $sentence,
                -1,
                PREG_SPLIT_NO_EMPTY
            );

            foreach ($tokens as $tokenIndex => $token) {
                $tokens[$tokenIndex] = mb_strtolower(trim($token));
            }

            //@todo stopwords

            $textMap[$sentenceIndex] = $tokens;
        }

        return $this->textBuilder->build(
            $sentences,
            $textMap
        );
    }
}
