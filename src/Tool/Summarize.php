<?php
/**
 * PHP Science TextRank (http://php.science/)
 *
 * @see     https://github.com/doveid/php-science-textrank
 * @license https://opensource.org/licenses/MIT the MIT License
 * @author  David Belicza <87.bdavid@gmail.com>
 */

declare(strict_types=1);

namespace PhpScience\TextRank\Tool;

/**
 * Class Summarize
 *
 * This is for summarize the text from parsed data.
 *
 * @package PhpScience\TextRank\Tool
 */
class Summarize
{
    /**
     * To find all important sentences.
     *
     * @var int
     */
    const GET_ALL_IMPORTANT = 0;

    /**
     * To find the most important sentence and its following sentences.
     *
     * @var int
     */
    const GET_FIRST_IMPORTANT_AND_FOLLOWINGS = 1;

    /**
     * Array of sentence weight. Key is the index of the sentence and value is
     * the weight of the sentence.
     *
     * @var array
     */
    protected $sentenceWeight = [];

    /**
     * Summarize text.
     *
     * It retrieves the summarized text in array.
     *
     * @param array $scores        Keywords with scores. Score is the key.
     * @param Graph $graph         The graph of the text.
     * @param Text  $text          Text object what stores all text data.
     * @param int   $keyWordLimit  How many keyword should be used to find the
     *                             important sentences.
     * @param int   $sentenceLimit How many sentence should be retrieved.
     * @param int   $type          The type of summarizing. Possible values are
     *                             the constants of this class.
     *
     * @return array An array from sentences.
     */
    public function getSummarize(array &$scores, Graph &$graph, Text &$text,
                                 int $keyWordLimit, int $sentenceLimit,
                                 int $type): array
    {
        $graphData = $graph->getGraph();
        $sentences = $text->getSentences();
        $marks = $text->getMarks();
        $this->findAndWeightSentences($scores, $graphData, $keyWordLimit);

        if ($type == Summarize::GET_ALL_IMPORTANT) {
            return $this->getAllImportant($sentences, $marks, $sentenceLimit);

        } else if ($type == Summarize::GET_FIRST_IMPORTANT_AND_FOLLOWINGS) {
            return $this->getFirstImportantAndFollowings(
                $sentences,
                $marks,
                $sentenceLimit
            );
        }

        return [];
    }

    /**
     * Find and Weight Sentences.
     *
     * It finds the most important sentences and stores them into the property.
     *
     * @param array $scores       Keywords with scores. Score is the key.
     * @param array $graphData    Graph data from a Graph type object.
     * @param int   $keyWordLimit How many keyword should be used to find the
     *                            important sentences.
     */
    protected function findAndWeightSentences(array &$scores, array &$graphData,
                                              int $keyWordLimit)
    {
        $i = 0;

        foreach ($scores as $word => $score) {
            if ($i >= $keyWordLimit) {
                break;
            }

            $i++;
            $wordMap = $graphData[$word];

            foreach ($wordMap as $key => $value) {
                $this->updateSentenceWeight($key);
            }
        }

        arsort($this->sentenceWeight);
    }

    /**
     * Important Sentences.
     *
     * It retrieves the important sentences.
     *
     * @param array $sentences     Sentences, ordered by weights.
     * @param array $marks         Array of punctuations. Key is the reference
     *                             to the sentence, value is the punctuation.
     * @param int   $sentenceLimit How many sentence should be retrieved.
     *
     * @return array An array from sentences what are the most important
     *               sentences.
     */
    protected function getAllImportant(array &$sentences, array &$marks,
                                       int $sentenceLimit): array
    {
        $summary = [];
        $i = 0;

        foreach ($this->sentenceWeight as $sentenceIdx => $weight) {
            if ($i >= $sentenceLimit) {
                break;
            }

            $i++;
            $summary[$sentenceIdx] = $sentences[$sentenceIdx]
                . $this->getMark($marks, $sentenceIdx);
        }

        ksort($summary);

        return $summary;
    }

    /**
     * Most Important Sentence and Next.
     *
     * It retrieves the first most important sentence and its following
     * sentences.
     *
     * @param array $sentences     Sentences, ordered by weights.
     * @param array $marks         Array of punctuations. Key is the reference
     *                             to the sentence, value is the punctuation.
     * @param int   $sentenceLimit How many sentence should be retrieved.
     *
     * @return array An array from sentences what contains the most important
     *               sentence and its following sentences.
     */
    protected function getFirstImportantAndFollowings(array &$sentences,
                                                      array &$marks,
                                                      int $sentenceLimit): array
    {
        $summary = [];
        $startIdx = 0;

        foreach ($this->sentenceWeight as $sentenceIdx => $weight) {
            $summary[$sentenceIdx] = $sentences[$sentenceIdx] .
                $this->getMark($marks, $sentenceIdx);

            $startIdx = $sentenceIdx;
            break;
        }

        $i = 0;

        foreach ($sentences as $sentenceIdx => $sentence) {
            if ($sentenceIdx <= $startIdx) {
                continue;
            } else if ($i >= $sentenceLimit - 1) {
                break;
            }

            $i++;
            $summary[$sentenceIdx] = $sentences[$sentenceIdx] .
                $this->getMark($marks, $sentenceIdx);
        }

        return $summary;
    }

    /**
     * Update Sentence Weight.
     *
     * It updates the sentence weight what is stored in the property.
     *
     * @param int $sentenceIdx Index of the sentence.
     */
    protected function updateSentenceWeight(int $sentenceIdx)
    {
        if (isset($this->sentenceWeight[$sentenceIdx])) {
            $this->sentenceWeight[$sentenceIdx] = $this->sentenceWeight[$sentenceIdx] + 1;
        } else {
            $this->sentenceWeight[$sentenceIdx] = 1;
        }
    }

    /**
     * Punctuations.
     *
     * It retrieves the punctuation of the sentence.
     *
     * @param array $marks The punctuation. Key is the reference to the
     *                     sentence, value is the punctuation.
     * @param int   $idx   Key of the punctuation.
     *
     * @return string The punctuation of the sentence.
     */
    protected function getMark(array &$marks, int $idx)
    {
        return isset($marks[$idx]) ? $marks[$idx] : '';
    }
}