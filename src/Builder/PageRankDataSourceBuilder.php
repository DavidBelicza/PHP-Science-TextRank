<?php

declare(strict_types=1);

namespace PhpScience\TextRank\Builder;

use PhpScience\TextRank\Data\TextInterface;

class PageRankDataSourceBuilder
{
    private const ID    = 'id';
    private const LEFT  = 'in';
    private const RIGHT = 'out';

    public function build(TextInterface $text): array
    {
        $dataSource = [];

        foreach ($text->getSentences() as $sentence) {
            foreach ($sentence->getVector() as $index => $tokenId) {
                if (!isset($dataSource[$tokenId])) {
                    $dataSource[$tokenId] = [
                        self::ID    => $tokenId,
                        self::LEFT  => [],
                        self::RIGHT => []
                    ];
                }

                if ($sentence->isIndexExists($index - 1)) {
                    $previousTokenId = $sentence->getTokenId($index - 1);
                    if ($text->getTokenMap()->isExists($previousTokenId)) {
                        $dataSource[$tokenId][self::LEFT][] = $previousTokenId;
                    }
                }

                if ($sentence->isIndexExists($index + 1)) {
                    $nextTokenId = $sentence->getTokenId($index + 1);
                    if ($text->getTokenMap()->isExists($nextTokenId)) {
                        $dataSource[$tokenId][self::RIGHT][] = $nextTokenId;
                    }
                }
            }
        }

        return $dataSource;
    }
}
