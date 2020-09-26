<?php

declare(strict_types=1);

namespace PhpScience\TextRank\Service;

class SortRankDataList implements SortRankDataListInterface
{
    /**
     * @inheritDoc
     */
    public function sort(array $rankList): array
    {
        $rankIndex = $this->getIndexedRank($rankList);
        arsort($rankIndex);
        $rankCollection = [];

        foreach ($rankIndex as $index => $rank) {
            $rankCollection[] = $rankList[$index];
        }

        return $rankCollection;
    }

    private function getIndexedRank(array $rankList): array
    {
        $rankIndex = [];

        foreach ($rankList as $index => $rankObject) {
            $rankIndex[$index] = $rankObject->getRank();
        }

        return $rankIndex;
    }
}
