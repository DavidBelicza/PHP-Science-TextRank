<?php

declare(strict_types=1);

namespace PhpScience\TextRank\Builder;

use PhpScience\PageRank\Data\NodeCollectionInterface;
use PhpScience\TextRank\Data\TextInterface;
use PhpScience\TextRank\Data\TextRankOutput;
use PhpScience\TextRank\Data\TextRankOutput\OutputValue;
use PhpScience\TextRank\Data\TextRankOutputInterface;
use PhpScience\TextRank\Service\GetTopNodesInterface;
use PhpScience\TextRank\Service\SentenceWeightingInterface;

class TextRankOutputBuilder implements TextRankOutputBuilderInterface
{
    private GetTopNodesInterface       $getTopNodes;
    private SentenceWeightingInterface $sentenceWeighting;

    public function __construct(
        GetTopNodesInterface $getTopNodes,
        SentenceWeightingInterface $sentenceWeighting
    ) {
        $this->getTopNodes = $getTopNodes;
        $this->sentenceWeighting = $sentenceWeighting;
    }

    public function build(
        TextInterface $text,
        NodeCollectionInterface $nodeCollection,
        int $maxKeywords
    ): TextRankOutputInterface {
        $nodes = $this->getTopNodes->execute($nodeCollection, $maxKeywords);
        $words = [];

        foreach ($nodes as $node) {
            $token = $text
                ->getTokenMap()
                ->getToken($node->getId());
            $word = new OutputValue();
            $word->setId($node->getId());
            $word->setValue($token);
            $word->setRank($node->getRank());

            $words[] = $word;
        }

        $textRankOutput = new TextRankOutput();
        $textRankOutput->setKeyWords(array_slice($words, 0, $maxKeywords));

        $sentences = $this->sentenceWeighting->weight($text, $words);



        $textRankOutput->setSentences($sentences);


        return $textRankOutput;
    }
}
