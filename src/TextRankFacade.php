<?php
/**
 * PHP Science TextRank (http://php.science/)
 *
 * @see     https://github.com/doveid/php-science-textrank
 * @license https://opensource.org/licenses/MIT the MIT License
 * @author  David Belicza <87.bdavid@gmail.com>
 */

declare(strict_types=1);

namespace PhpScience\TextRank;

use PhpScience\TextRank\Tool\Graph;
use PhpScience\TextRank\Tool\Parser;
use PhpScience\TextRank\Tool\Score;
use PhpScience\TextRank\Tool\StopWords\StopWordsAbstract;
use PhpScience\TextRank\Tool\Summarize;

/**
 * Class TextRankFacade
 *
 * This Facade class is capable to find the keywords in a raw text, weigh them
 * and retrieve the most important sentences from the whole text. It is an
 * implementation of the TextRank algorithm.
 *
 * <code>
 *      $stopWords = new English();
 *
 *      $textRank = new TextRankFacade();
 *      $textRank->setStopWords($stopWords);
 *
 *      $sentences = $textRank->summarizeTextFreely(
 *          $rawText,
 *          5,
 *          2,
 *          Summarize::GET_ALL_IMPORTANT
 *      );
 * </code>
 *
 * @package PhpScience\TextRank
 */
class TextRankFacade
{
    /**
     * Stop Words
     *
     * Stop Words to ignore because of dummy words. These words will not be Key
     * Words. A, like, no yes, one, two, I, you for example.
     *
     * @see \PhpScience\TextRank\Tool\StopWords\English
     *
     * @var StopWordsAbstract
     */
    protected $stopWords;

    /**
     * Set Stop Words.
     *
     * @param StopWordsAbstract $stopWords Stop Words to ignore because of
     *                                     dummy words.
     */
    public function setStopWords(StopWordsAbstract $stopWords)
    {
        $this->stopWords = $stopWords;
    }

    /**
     * Only Keywords
     *
     * It retrieves the possible keywords with their scores from a text.
     *
     * @param string $rawText A single raw text.
     *
     * @return array Array from Keywords. Key is the parsed word, value is the
     *               word score.
     */
    public function getOnlyKeyWords(string $rawText): array
    {
        $parser = new Parser();
        $parser->setMinimumWordLength(3);
        $parser->setRawText($rawText);

        if ($this->stopWords) {
            $parser->setStopWords($this->stopWords);
        }

        $text = $parser->parse();

        $graph = new Graph();
        $graph->createGraph($text);

        $score = new Score();

        return $score->calculate(
            $graph, $text
        );
    }

    /**
     * Highlighted Texts
     *
     * It finds the most important sentences from a text by the most important
     * keywords and these keywords also found by automatically. It retrieves
     * the most important sentences what are 20 percent of the full text.
     *
     * @param string $rawText A single raw text.
     *
     * @return array An array from sentences.
     */
    public function getHighlights(string $rawText): array
    {
        $parser = new Parser();
        $parser->setMinimumWordLength(3);
        $parser->setRawText($rawText);

        if ($this->stopWords) {
            $parser->setStopWords($this->stopWords);
        }

        $text = $parser->parse();
        $maximumSentences = (int) (count($text->getSentences()) * 0.2);

        $graph = new Graph();
        $graph->createGraph($text);

        $score = new Score();
        $scores = $score->calculate($graph, $text);

        $summarize = new Summarize();

        return $summarize->getSummarize(
            $scores,
            $graph,
            $text,
            12,
            $maximumSentences,
            Summarize::GET_ALL_IMPORTANT
        );
    }

    /**
     * Compounds a Summarized Text
     *
     * It finds the three most important sentences from a text by the most
     * important keywords and these keywords also found by automatically. It
     * retrieves these important sentences.
     *
     * @param string $rawText A single raw text.
     *
     * @return array An array from sentences.
     */
    public function summarizeTextCompound(string $rawText): array
    {
        $parser = new Parser();
        $parser->setMinimumWordLength(3);
        $parser->setRawText($rawText);

        if ($this->stopWords) {
            $parser->setStopWords($this->stopWords);
        }

        $text = $parser->parse();

        $graph = new Graph();
        $graph->createGraph($text);

        $score = new Score();
        $scores = $score->calculate($graph, $text);

        $summarize = new Summarize();

        return $summarize->getSummarize(
            $scores,
            $graph,
            $text,
            10,
            3,
            Summarize::GET_ALL_IMPORTANT
        );
    }

    /**
     * Summarized Text
     *
     * It finds the most important sentence from a text by the most important
     * keywords and these keywords also found by automatically. It retrieves
     * the most important sentence and its following sentences.
     *
     * @param string $rawText A single raw text.
     *
     * @return array An array from sentences.
     */
    public function summarizeTextBasic(string $rawText): array
    {
        $parser = new Parser();
        $parser->setMinimumWordLength(3);
        $parser->setRawText($rawText);

        if ($this->stopWords) {
            $parser->setStopWords($this->stopWords);
        }

        $text = $parser->parse();

        $graph = new Graph();
        $graph->createGraph($text);

        $score = new Score();
        $scores = $score->calculate($graph, $text);

        $summarize = new Summarize();

        return $summarize->getSummarize(
            $scores,
            $graph,
            $text,
            10,
            3,
            Summarize::GET_FIRST_IMPORTANT_AND_FOLLOWINGS
        );
    }

    /**
     * Freely Summarized Text.
     *
     * It retrieves the most important sentences from a text by the most important
     * keywords and these keywords also found by automatically.
     *
     * @param string $rawText           A single raw text.
     * @param int    $analyzedKeyWords  Maximum number of the most important
     *                                  Key Words to analyze the text.
     * @param int    $expectedSentences How many sentence should be retrieved.
     * @param int    $summarizeType     Highlights from the text or a part of
     *                                  the text.
     *
     * @return array An array from sentences.
     */
    public function summarizeTextFreely(
        string $rawText,
        int $analyzedKeyWords,
        int $expectedSentences,
        int $summarizeType
    ): array {
        $parser = new Parser();
        $parser->setMinimumWordLength(3);
        $parser->setRawText($rawText);

        if ($this->stopWords) {
            $parser->setStopWords($this->stopWords);
        }

        $text = $parser->parse();

        $graph = new Graph();
        $graph->createGraph($text);

        $score = new Score();
        $scores = $score->calculate($graph, $text);

        $summarize = new Summarize();

        return $summarize->getSummarize(
            $scores,
            $graph,
            $text,
            $analyzedKeyWords,
            $expectedSentences,
            $summarizeType
        );
    }
}
