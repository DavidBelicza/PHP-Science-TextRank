<?php

declare(strict_types=1);

namespace PhpScience\TextRank\Facade;

use PhpScience\TextRank\Builder\PageRankDataSourceBuilder;
use PhpScience\TextRank\Builder\TextBuilder;
use PhpScience\TextRank\Service\Parser;
use PhpScience\TextRank\Strategy\PageRankStrategy;

class TextRank
{
    public function getKeywords(string $rawText, int $maxKeywords)
    {
        $parser = new Parser(
            new TextBuilder()
        );

        $text = $parser
            ->parse($rawText);

        $pageRankStrategy = new PageRankStrategy(
            new PageRankDataSourceBuilder()
        );

        $nodeCollection = $pageRankStrategy->rank($text);

        echo PHP_EOL;

        $i = 0;
        $nodes = [];

        foreach ($nodeCollection->getNodes() as $node) {
            $nodes[] = $node;
            $i++;

            if ($i === $maxKeywords) {
                break;
            }

            /*echo $text->getTokenMap()->getToken($node->getId());
            echo ' - ';
            echo $node->getRank();
            echo PHP_EOL;*/
        }

        return $nodes;
    }
}
