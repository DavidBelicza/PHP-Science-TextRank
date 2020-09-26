<?php

declare(strict_types=1);

namespace PhpScience\TextRank\Builder;

use PhpScience\TextRank\Data\Text;
use PhpScience\TextRank\Data\Text\Sentence;
use PhpScience\TextRank\Data\Text\TokenMap;
use PhpScience\TextRank\Data\TextInterface;

class TextBuilder implements TextBuilderInterface
{
    public function build(array $originalSentences, array $textMap): TextInterface
    {
        $sentences = [];
        $tokens = [];
        $i = 1;

        foreach ($textMap as $sentenceIndex => $sentenceTokenList) {
            $sentenceVector = [];
            foreach ($sentenceTokenList as $token) {
                $token = (string)$token;
                if (!isset($tokens[$token])) {
                    $tokens[$token] = $i;
                    $tokenId = $i;
                    $i++;
                } else {
                    $tokenId = $tokens[$token];
                }

                $sentenceVector[] = $tokenId;
            }

            $sentence = new Sentence();
            $sentence->setId($sentenceIndex);
            $sentence->setVector($sentenceVector);
            $sentence->setOriginalValue($originalSentences[$sentenceIndex]);
            $sentences[] = $sentence;
        }

        $tokenMap = new TokenMap();
        $tokenMap->setTokenMap(
            array_map(
                'strval',
                array_flip($tokens)
            )
        );

        return new Text(
            $tokenMap,
            $sentences
        );
    }
}
