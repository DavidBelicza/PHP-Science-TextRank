<?php

declare(strict_types=1);

namespace PhpScience\TextRank\Builder;

use PhpScience\TextRank\Data\AlgorithmOutput;
use PhpScience\TextRank\Data\AlgorithmOutputInterface;
use PhpScience\PageRank\Data\NodeCollectionInterface;
use PhpScience\TextRank\Data\RankDataObject;
use PhpScience\TextRank\Data\TextInterface;
use PhpScience\TextRank\Service\SortRankDataListInterface;

class AlgorithmOutputBuilder implements AlgorithmOutputBuilderInterface
{
    private SortRankDataListInterface $sortRankDataList;

    public function __construct(
        SortRankDataListInterface $getTopNodes
    ) {
        $this->sortRankDataList = $getTopNodes;
    }

    public function build(
        TextInterface $text,
        NodeCollectionInterface $nodeCollection,
        array $sentences,
        int $maxKeywords,
        int $maxSentences
    ): AlgorithmOutputInterface {
        $words = $this->createWordList($text, $nodeCollection, $maxKeywords);
        $sentences = array_slice(
            $this->sortRankDataList->sort($sentences),
            0,
            $maxSentences
        );

        $textRankOutput = new AlgorithmOutput();
        $textRankOutput->setKeyWords($words);
        $textRankOutput->setSentences($sentences);

        return $textRankOutput;
    }

    private function createWordList(
        TextInterface $text,
        NodeCollectionInterface $nodeCollection,
        int $maxKeywords
    ): array {
        $nodes = $this
            ->sortRankDataList
            ->sort(array_values($nodeCollection->getNodes()));
        $words = [];

        for ($i = 0; $i < $maxKeywords; $i++) {
            $nodeId = $nodes[$i]->getId();
            $token = $text->getTokenMap()->getToken($nodeId);
            $word = new RankDataObject();
            $word->setId($nodeId);
            $word->setValue($token);
            $word->setRank($nodes[$i]->getRank());

            $words[] = $word;
        }

        return $words;
    }
}
