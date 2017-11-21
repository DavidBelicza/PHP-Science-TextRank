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
 * Class Text
 *
 * This class is for store the parsed texts.
 *
 * @package PhpScience\TextRank\Tool
 */
class Text
{
    /**
     * Multidimensional array from words of the text. Key is index of the
     * sentence, value is an array from words where key is the index of the
     * word and value is the word.
     *
     * @var array
     */
    protected $wordMatrix = [];

    /**
     * Array from sentences where key is the index and value is the sentence.
     *
     * @var array
     */
    protected $sentences = [];

    /**
     * Array from punctuations where key is the index to link to the sentence
     * and value is the punctuation.
     *
     * @var array
     */
    protected $marks = [];

    /**
     * It set the Words' matrix to the property.
     *
     * @param array $wordMatrix Multidimensional array from integer keys and
     *                          string values.
     */
    public function setWordMatrix(array $wordMatrix)
    {
        $this->wordMatrix = $wordMatrix;
    }

    /**
     * It sets the sentences.
     *
     * @param array $sentences Array's key should be an int and value should be
     *                         string.
     */
    public function setSentences(array $sentences)
    {
        $this->sentences = $sentences;
    }

    /**
     * It set the punctuations to the property.
     *
     * @param array $marks Array's key should be an int and value should be
     *                     string.
     */
    public function setMarks(array $marks)
    {
        $this->marks = $marks;
    }

    /**
     * It retrieves the words in sentence groups.
     *
     * @return array Multidimensional array from words of the text. Key is
     *               index of the sentence, value is an array from words
     *               where key is the index of the word and value is the word.
     */
    public function getWordMatrix(): array
    {
        return $this->wordMatrix;
    }

    /**
     * It retrieves the sentences.
     *
     * @return array Array from sentences where key is the index and value is
     *               the sentence.
     */
    public function getSentences(): array
    {
        return $this->sentences;
    }

    /**
     * It retrieves the punctuations.
     *
     * @return array Array from punctuations where key is the index to link to
     *               the sentence and value is the punctuation.
     */
    public function getMarks(): array
    {
        return $this->marks;
    }
}
