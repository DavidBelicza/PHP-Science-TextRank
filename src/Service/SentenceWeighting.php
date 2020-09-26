<?php

declare(strict_types=1);

namespace PhpScience\TextRank\Service;

use PhpScience\PageRank\Data\NodeCollectionInterface;
use PhpScience\TextRank\Data\RankDataObject;
use PhpScience\TextRank\Data\RankDataObjectInterface;
use PhpScience\TextRank\Data\TextInterface;

class SentenceWeighting implements SentenceWeightingInterface
{
    public function weight(
        TextInterface $text,
        NodeCollectionInterface $nodeCollection
    ): array {
        $rankMap = $this->createRankMap($nodeCollection);
        $sentenceOutputList = [];

        foreach ($text->getSentences() as $sentence) {
            $vector = $sentence->getVector();
            $weight = .0;

            foreach ($vector as $tokenId) {
                $weight += $rankMap[$tokenId];
            }

            $weight = $weight / max(1, count($vector));

            $sentenceOutputList[] = $this
                ->createSentence(
                    $sentence->getId(),
                    $weight,
                    $sentence->getOriginalValue()
                );
        }

        return $sentenceOutputList;
    }

    private function createSentence(
        int $id,
        float $rank,
        string $originalValue
    ): RankDataObjectInterface {

        $sentence = new RankDataObject();
        $sentence->setId($id);
        $sentence->setRank($rank);
        $sentence->setValue($originalValue);

        return $sentence;
    }

    private function createRankMap(
        NodeCollectionInterface $nodeCollection
    ): array {
        $rankMap = [];

        foreach ($nodeCollection->getNodes() as $node) {
            $rankMap[$node->getId()] = $node->getRank();
        }

        return $rankMap;
    }
}
