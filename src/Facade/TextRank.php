<?php

declare(strict_types=1);

namespace PhpScience\TextRank\Facade;

use PhpScience\TextRank\Builder\TextRankOutputBuilderInterface;
use PhpScience\TextRank\Data\TextRankOutputInterface;
use PhpScience\TextRank\Service\Parser;
use PhpScience\TextRank\Strategy\RankingAlgorithmStrategyInterface;

class TextRank
{
    private Parser                            $parser;
    private RankingAlgorithmStrategyInterface $rankingAlgorithmStrategy;
    private TextRankOutputBuilderInterface    $textRankOutputBuilder;

    public function __construct(
        Parser $parser,
        RankingAlgorithmStrategyInterface $rankingAlgorithmStrategy,
        TextRankOutputBuilderInterface $textRankOutputBuilder
    ) {
        $this->parser = $parser;
        $this->rankingAlgorithmStrategy = $rankingAlgorithmStrategy;
        $this->textRankOutputBuilder = $textRankOutputBuilder;
    }

    public function getKeywords(
        string $rawText,
        int $maxKeywords
    ): TextRankOutputInterface {

        $text = $this->parser->parse($rawText);
        $nodeCollection = $this->rankingAlgorithmStrategy->rank($text);

        return $this->textRankOutputBuilder->build(
            $text,
            $nodeCollection,
            $maxKeywords
        );
    }
}
