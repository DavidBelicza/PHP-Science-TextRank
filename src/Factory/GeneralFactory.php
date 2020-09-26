<?php

declare(strict_types=1);

namespace PhpScience\TextRank\Factory;

use PhpScience\TextRank\Builder\AlgorithmOutputBuilder;
use PhpScience\TextRank\Builder\AlgorithmOutputBuilderInterface;
use PhpScience\TextRank\Builder\PageRankDataSourceBuilder;
use PhpScience\TextRank\Builder\StopWordCollectionBuilder;
use PhpScience\TextRank\Builder\TextBuilder;
use PhpScience\TextRank\Service\CsvReader;
use PhpScience\TextRank\Service\Parser;
use PhpScience\TextRank\Service\ParserInterface;
use PhpScience\TextRank\Service\SentenceWeighting;
use PhpScience\TextRank\Service\SentenceWeightingInterface;
use PhpScience\TextRank\Service\SortRankDataList;
use PhpScience\TextRank\Strategy\PageRankStrategy;
use PhpScience\TextRank\Strategy\RankingAlgorithmStrategyInterface;

class GeneralFactory implements GeneralFactoryInterface
{
    public function createParser(): ParserInterface
    {
        $textBuilder = new TextBuilder();
        $reader = new CsvReader();
        $stopWordCollectionBuilder = new StopWordCollectionBuilder(
            $reader
        );

        return new Parser(
            $textBuilder,
            $stopWordCollectionBuilder
        );
    }

    public function createAlgorithmStrategy(): RankingAlgorithmStrategyInterface
    {
        $pageRankDataSourceBuilder = new PageRankDataSourceBuilder();

        return new PageRankStrategy(
            $pageRankDataSourceBuilder
        );
    }

    public function createAlgorithmBuilder(): AlgorithmOutputBuilderInterface
    {
        $sortRankDataList = new SortRankDataList();

        return new AlgorithmOutputBuilder(
            $sortRankDataList
        );
    }

    public function createSentenceWeighting(): SentenceWeightingInterface
    {
        return new SentenceWeighting();
    }
}
