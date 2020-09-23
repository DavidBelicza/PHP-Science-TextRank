<?php

declare(strict_types=1);

namespace PhpScience\TextRank\Service;

use PhpScience\TextRank\Data\TextInterface;
use PhpScience\TextRank\Data\TextRankOutput\OutputValue;
use PhpScience\TextRank\Data\TextRankOutput\OutputValueInterface;

class SentenceWeighting implements SentenceWeightingInterface
{
    public function weight(TextInterface $text, array $keywords): array
    {
        $keywordRankMap = [];

        /** @var OutputValueInterface $keyword */
        foreach ($keywords as $keyword) {
            $keywordRankMap[$keyword->getId()] = $keyword->getRank();
        }

        $sentenceOutputList = [];

        foreach ($text->getSentences() as $sentence) {
            $vector = $sentence->getVector();
            $score = .0;

            foreach ($vector as $tokenId) {
                if (isset($keywordRankMap[$tokenId])) {
                    $score += $keywordRankMap[$tokenId];
                }
            }

            $score = $score / count($vector);
            $sentenceOutput = new OutputValue();
            $sentenceOutput->setId($sentence->getId());
            $sentenceOutput->setRank($score);
            $sentenceOutput->setValue($sentence->getOriginalValue());

            $sentenceOutputList[] = $sentenceOutput;
        }

        return $sentenceOutputList;
    }
}
