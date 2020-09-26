<?php

declare(strict_types=1);

namespace PhpScience\TextRank\Factory;

use PhpScience\TextRank\Builder\AlgorithmOutputBuilderInterface;
use PhpScience\TextRank\Service\ParserInterface;
use PhpScience\TextRank\Service\SentenceWeightingInterface;
use PhpScience\TextRank\Strategy\RankingAlgorithmStrategyInterface;

interface GeneralFactoryInterface
{
    public function createParser(): ParserInterface;

    public function createAlgorithmStrategy(): RankingAlgorithmStrategyInterface;

    public function createAlgorithmBuilder(): AlgorithmOutputBuilderInterface;

    public function createSentenceWeighting(): SentenceWeightingInterface;
}
