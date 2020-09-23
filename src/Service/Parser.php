<?php

declare(strict_types=1);

namespace PhpScience\TextRank\Service;

use PhpScience\TextRank\Builder\TextBuilderInterface;
use PhpScience\TextRank\Data\TextInterface;

class Parser
{
    private TextBuilderInterface $textBuilder;
    private StopWordFilter       $stopWordFilter;

    public function __construct(
        TextBuilderInterface $textBuilder,
        StopWordFilter $stopWordFilter
    ) {
        $this->textBuilder = $textBuilder;
        $this->stopWordFilter = $stopWordFilter;
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
                $token = mb_strtolower(trim($token));

                if ($this->stopWordFilter->isStopWord($token)) {
                    unset($tokens[$tokenIndex]);
                } else {
                    $tokens[$tokenIndex] = mb_strtolower(trim($token));
                }
            }

            $textMap[$sentenceIndex] = $tokens;
        }

        return $this->textBuilder->build(
            $sentences,
            $textMap
        );
    }
}
