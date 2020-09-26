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
        $size = count($rankList);

        for ($i = 0; $i < $size; $i++) {
            for ($j = 0; $j < $size; $j++) {
                if ($rankList[$i]->getRank() > $rankList[$j]->getRank()) {
                    $tmp = $rankList[$i];
                    $rankList[$i] = $rankList[$j];
                    $rankList[$j] = $tmp;
                }
            }
        }

        return $rankList;
    }
}
