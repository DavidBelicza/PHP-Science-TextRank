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
 * Class Graph
 *
 * This graph store the sentences and their words with the indexes. This graph
 * is the full map of the whole text.
 *
 * @package PhpScience\TextRank\Tool
 */
class Graph
{
    /**
     * Key is the word, value is an array with the sentence IDs.
     *
     * @var array
     */
    protected $graph = [];

    /**
     * Create Graph.
     *
     * It creates a graph and save it into the graph property.
     *
     * @param Text $text Text object contains the parsed and prepared text
     *                   data.
     */
    public function createGraph(Text &$text)
    {
        $wordMatrix = $text->getWordMatrix();

        foreach ($wordMatrix as $sentenceIdx => $words) {
            $idxArray = array_keys($words);

            foreach ($idxArray as $idxKey => $idxValue) {
                $connections = [];

                if (isset($idxArray[$idxKey - 1])) {
                    $connections[] = $idxArray[$idxKey - 1];
                }

                if (isset($idxArray[$idxKey + 1])) {
                    $connections[] = $idxArray[$idxKey + 1];
                }

                $this->graph[$words[$idxValue]][$sentenceIdx][$idxValue] = $connections;
            }
        }
    }

    /**
     * Graph.
     *
     * It retrieves the graph. Key is the word, value is an array with the
     * sentence IDs.
     *
     * <code>
     *       array(
     *           'apple' => array(    // word
     *               2 => array(      // ID of the sentence
     *                   52 => array( // ID of the word in the sentence
     *                       51, 53   // IDs of the closest words to the apple word
     *                   ),
     *                   10 => array( // IDs of the closest words to the apple word
     *                       9, 11    // IDs of the closest words to the apple word
     *                   ),
     *                   5 => array(6)
     *               ),
     *               6 => array(
     *                   9 => array(8, 10)
     *               ),
     *           ),
     *           'orange' => array(
     *               1  => array(
     *                   30 => array(29, 31)
     *               )
     *           )
     *       );
     * </code>
     *
     * @return array
     */
    public function getGraph(): array
    {
        return $this->graph;
    }
}
