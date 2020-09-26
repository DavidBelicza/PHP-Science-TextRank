<?php

declare(strict_types=1);

namespace PhpScience\TextRank\Facade;

use PhpScience\TextRank\Builder\AlgorithmOutputBuilderInterface;
use PhpScience\TextRank\Data\AlgorithmOutputInterface;
use PhpScience\TextRank\Data\AlgorithmRequestInterface;
use PhpScience\TextRank\Factory\GeneralFactoryInterface;
use PhpScience\TextRank\Service\ParserInterface;
use PhpScience\TextRank\Service\SentenceWeightingInterface;
use PhpScience\TextRank\Strategy\RankingAlgorithmStrategyInterface;

class TextRank
{
    private ParserInterface                   $parser;
    private RankingAlgorithmStrategyInterface $pageRankAlgorithm;
    private AlgorithmOutputBuilderInterface   $algorithmOutputBuilder;
    private SentenceWeightingInterface        $sentenceWeighting;

    public function __construct(
        GeneralFactoryInterface $generalFactory
    ) {
        $this->parser = $generalFactory->createParser();
        $this->pageRankAlgorithm = $generalFactory->createAlgorithmStrategy();
        $this->algorithmOutputBuilder = $generalFactory->createAlgorithmBuilder();
        $this->sentenceWeighting = $generalFactory->createSentenceWeighting();
    }

    public function rank(
        AlgorithmRequestInterface $algorithmRequest
    ): AlgorithmOutputInterface {

        $text = $this->parser->parse(
            $algorithmRequest->getRawText(),
            $algorithmRequest->getStopWordCsvPath(),
            $algorithmRequest->getMinKeywordLength()
        );

        $nodeCollection = $this->pageRankAlgorithm->rank(
            $text,
            $algorithmRequest->getPageRankPowerIteration()
        );

        $sentences = $this->sentenceWeighting->weight(
            $text,
            $nodeCollection
        );

        return $this->algorithmOutputBuilder->build(
            $text,
            $nodeCollection,
            $sentences,
            $algorithmRequest->getMaxKeywords(),
            $algorithmRequest->getMaxKeySentences()
        );
    }
}
