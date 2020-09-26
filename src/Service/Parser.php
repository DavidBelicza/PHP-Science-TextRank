<?php

declare(strict_types=1);

namespace PhpScience\TextRank\Service;

use PhpScience\TextRank\Builder\StopWordCollectionBuilderInterface;
use PhpScience\TextRank\Builder\TextBuilderInterface;
use PhpScience\TextRank\Data\TextInterface;

class Parser implements ParserInterface
{
    private TextBuilderInterface               $textBuilder;
    private StopWordCollectionBuilderInterface $stopWordCollectionBuilder;

    public function __construct(
        TextBuilderInterface $textBuilder,
        StopWordCollectionBuilderInterface $stopWordCollectionBuilder
    ) {
        $this->textBuilder = $textBuilder;
        $this->stopWordCollectionBuilder = $stopWordCollectionBuilder;
    }

    public function parse(string $rawText, string $stopWordsPath): TextInterface
    {
        $stopWordCollection = $this
            ->stopWordCollectionBuilder
            ->build($stopWordsPath);

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

                if ($stopWordCollection->isExist($token)) {
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
