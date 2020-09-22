<?php

declare(strict_types=1);

namespace PhpScience\TextRank\Strategy;

use PhpScience\PageRank\Builder\NodeBuilder;
use PhpScience\PageRank\Builder\NodeCollectionBuilder;
use PhpScience\PageRank\Data\NodeCollectionInterface;
use PhpScience\PageRank\Service\PageRankAlgorithm;
use PhpScience\PageRank\Service\PageRankAlgorithm\Normalizer;
use PhpScience\PageRank\Service\PageRankAlgorithm\RankComparator;
use PhpScience\PageRank\Service\PageRankAlgorithm\Ranking;
use PhpScience\PageRank\Service\PageRankAlgorithm\RankingInterface;
use PhpScience\PageRank\Service\PageRankAlgorithmInterface;
use PhpScience\PageRank\Strategy\MemorySourceStrategy;
use PhpScience\PageRank\Strategy\NodeDataSourceStrategyInterface;
use PhpScience\TextRank\Builder\PageRankDataSourceBuilder;
use PhpScience\TextRank\Data\TextInterface;

class PageRankStrategy implements RankingAlgorithmStrategyInterface
{
    private PageRankDataSourceBuilder $pageRankDataSourceBuilder;

    public function __construct(
        PageRankDataSourceBuilder $pageRankDataSourceBuilder
    ) {
        $this->pageRankDataSourceBuilder = $pageRankDataSourceBuilder;
    }

    public function rank(TextInterface $text): NodeCollectionInterface
    {
        $dataSource = $this->pageRankDataSourceBuilder->build($text);
        $strategy = $this->createPageRankStrategy($dataSource);
        $ranking = $this->createRanking($strategy);
        $pageRankAlgorithm = $this->createPageRankAlgorithm($ranking, $strategy);
        $maxIteration = 100;

        return $pageRankAlgorithm->run($maxIteration);
    }

    private function createPageRankAlgorithm(
        RankingInterface $ranking,
        NodeDataSourceStrategyInterface $strategy
    ): PageRankAlgorithmInterface {

        $normalizer = new Normalizer();

        return new PageRankAlgorithm(
            $ranking,
            $strategy,
            $normalizer
        );
    }

    private function createPageRankStrategy(
        array $dataSource
    ): NodeDataSourceStrategyInterface {

        $nodeBuilder = new NodeBuilder();
        $nodeCollectionBuilder = new NodeCollectionBuilder();

        return new MemorySourceStrategy(
            $nodeBuilder,
            $nodeCollectionBuilder,
            $dataSource
        );
    }

    private function createRanking(
        NodeDataSourceStrategyInterface $strategy
    ): RankingInterface {

        $rankComparator = new RankComparator();

        return new Ranking(
            $rankComparator,
            $strategy
        );
    }
}
