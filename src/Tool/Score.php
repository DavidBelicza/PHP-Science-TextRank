<?php

declare(strict_types=1);

namespace PhpScience\TextRank\Tool;

class Score
{
    /**
     * The maximum connections by a word in the current text.
     *
     * @var int
     */
    protected $maximumValue = 0;

    /**
     * The minimum connection by a word in the current text.
     *
     * @var int
     */
    protected $minimumValue = 0;

    /**
     * Calculate Scores.
     *
     * It calculates the scores from word's connections and the connections'
     * scores. It retrieves the scores in a form of a matrix where the key is
     * the word and value is the score. The score is between 0 and 1.
     *
     * @param Graph $graph The graph of the text.
     * @param Text  $text  Text object what stores all text data.
     *
     * @return array Key is the word and value is the float or int type score
     *               between 1 and 0.
     */
    public function calculate(Graph $graph, Text &$text): array
    {
        $graphData = $graph->getGraph();
        $wordMatrix = $text->getWordMatrix();
        $wordConnections = $this->calculateConnectionNumbers($graphData);
        $scores = $this->calculateScores(
            $graphData,
            $wordMatrix,
            $wordConnections
        );

        return $this->normalizeAndSortScores($scores);
    }

    /**
     * Connection Numbers.
     *
     * It calculates the number of connections for each word and retrieves it
     * in array where key is the word and value is the number of connections.
     *
     * @param array $graphData Graph data from a Graph type object.
     *
     * @return array Key is the word and value is the number of the connected
     *               words.
     */
    protected function calculateConnectionNumbers(array &$graphData): array
    {
        $wordConnections = [];

        foreach ($graphData as $wordKey => $sentences) {
            $connectionCount = 0;

            foreach ($sentences as $sentenceIdx => $wordInstances) {
                foreach ($wordInstances as $connections) {
                    $connectionCount += count($connections);
                }
            }

            $wordConnections[$wordKey] = $connectionCount;
        }

        return $wordConnections;
    }

    /**
     * Calculate Scores.
     *
     * It calculates the score of the words and retrieves it in array where key
     * is the word and value is the score. The score depends on the number of
     * the connections and the closest word's connection numbers.
     *
     * @param array $graphData       Graph data from a Graph type object.
     * @param array $wordMatrix      Multidimensional array from integer keys
     *                               and string values.
     * @param array $wordConnections Key is the word and value is the number of
     *                               the connected words.
     *
     * @return array Scores where key is the word and value is the score.
     */
    protected function calculateScores(
        array &$graphData,
        array &$wordMatrix,
        array &$wordConnections
    ): array {
        $scores = [];

        foreach ($graphData as $wordKey => $sentences) {
            $value = 0;

            foreach ($sentences as $sentenceIdx => $wordInstances) {
                foreach ($wordInstances as $connections) {
                    foreach ($connections as $wordIdx) {
                        $word = $wordMatrix[$sentenceIdx][$wordIdx];
                        $value += $wordConnections[$word];
                    }
                }
            }

            $scores[$wordKey] = $value;

            if ($value > $this->maximumValue) {
                $this->maximumValue = $value;
            }

            if ($value < $this->minimumValue || $this->minimumValue == 0) {
                $this->minimumValue = $value;
            }
        }

        return $scores;
    }

    /**
     * Normalize and Sort Scores.
     *
     * It recalculates the scores by normalize the score numbers to between 0
     * and 1.
     *
     * @param array $scores Keywords with scores. Score is the key.
     *
     * @return array Keywords with normalized and ordered scores.
     */
    protected function normalizeAndSortScores(array &$scores): array
    {
        foreach ($scores as $key => $value) {
            $v = $this->normalize(
                $value,
                $this->minimumValue,
                $this->maximumValue
            );

            $scores[$key] = $v;
        }

        arsort($scores);

        return $scores;
    }

    /**
     * It normalizes a number.
     *
     * @param int $value Current weight.
     * @param int $min   Minimum weight.
     * @param int $max   Maximum weight.
     *
     * @return float|int Normalized weight aka score.
     */
    protected function normalize(int $value, int $min, int $max): float
    {
        $divisor = $max - $min;

        if ($divisor == 0) {
            return 0.0;
        }

        $normalized = ($value - $min) / $divisor;

        return $normalized;
    }
}
