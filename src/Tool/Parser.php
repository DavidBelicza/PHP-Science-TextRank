<?php
/**
 * PHP Science TextRank (http://php.science/)
 *
 * @see     https://github.com/DavidBelicza/PHP-Science-TextRank
 * @license https://opensource.org/licenses/MIT the MIT License
 * @author  David Belicza <david@belicza.com>
 */

declare(strict_types=1);

namespace PhpScience\TextRank\Tool;

use PhpScience\TextRank\Tool\StopWords\StopWordsAbstract;

/**
 * Class Parser
 *
 * This class purpose to parse a real text to sentences and array.
 *
 * @package PhpScience\TextRank\Tool
 */
class Parser
{
    /**
     * The number of length of the smallest word. Words bellow it will be
     * ignored.
     *
     * @var int
     */
    protected $minimumWordLength = 0;

    /**
     * A single text, article, book for example.
     *
     * @var string
     */
    protected $rawText = '';

    /**
     * The array of the punctuations. The punctuation is the value. The key
     * refers to the key of its sentence.
     *
     * @var array
     */
    protected $marks = [];

    /**
     * Stop Words to ignore. These words will not be keywords.
     *
     * @var StopWordsAbstract
     */
    protected $stopWords;

    /**
     * It sets the minimum word length. Words bellow it will be ignored.
     *
     * @param int $wordLength
     */
    public function setMinimumWordLength(int $wordLength)
    {
        $this->minimumWordLength = $wordLength;
    }

    /**
     * It sets the raw text.
     *
     * @param string $rawText
     */
    public function setRawText(string $rawText)
    {
        $this->rawText = $rawText;
    }

    /**
     * Set Stop Words.
     *
     * It sets the stop words to remove them from the found keywords.
     *
     * @param StopWordsAbstract $words Stop Words to ignore. These words will
     *                                 not be keywords.
     */
    public function setStopWords(StopWordsAbstract $words)
    {
        $this->stopWords = $words;
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

    /**
     * Parse.
     *
     * It parses the text from the property and retrieves in Text object
     * prepared to scoring and to searching.
     *
     * @return Text Parsed text prepared to scoring.
     */
    public function parse(): Text
    {
        $matrix = [];
        $sentences = $this->getSentences();

        foreach ($sentences as $sentenceIdx => $sentence) {
            $matrix[$sentenceIdx] = $this->getWords($sentence);
        }

        $text = new Text();
        $text->setSentences($sentences);
        $text->setWordMatrix($matrix);
        $text->setMarks($this->marks);

        return $text;
    }

    /**
     * Sentences.
     *
     * It retrieves the sentences in array without junk data.
     *
     * @return array Array from sentences.
     */
    protected function getSentences(): array
    {
        $sentences = $sentences = preg_split(
            '/(\n+)|(\.\s|\?\s|\!\s)(?![^\(]*\))/',
            $this->rawText,
            -1,
            PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE
        );

        return array_values(
            array_filter(
                array_map(
                    [$this, 'cleanSentence'],
                    $sentences
                )
            )
        );
    }

    /**
     * Possible Keywords.
     *
     * It retrieves an array of possible keywords without junk characters,
     * spaces and stop words.
     *
     * @param string $subText It should be a sentence.
     *
     * @return array The array of the possible keywords.
     */
    protected function getWords(string $subText): array
    {
        $words = preg_split(
            '/(?:(^\p{P}+)|(\p{P}*\s+\p{P}*)|(\p{P}+$))/',
            $subText,
            -1,
            PREG_SPLIT_NO_EMPTY
        );

        $words = array_values(
            array_filter(
                array_map(
                    [$this, 'cleanWord'],
                    $words
                )
            )
        );

        if ($this->stopWords) {
            return array_filter($words, function($word) {
                return !ctype_punct($word)
                        && strlen($word) > $this->minimumWordLength
                        && !$this->stopWords->exist($word);
            });
        } else {
            return array_filter($words, function($word) {
                return !ctype_punct($word)
                        && strlen($word) > $this->minimumWordLength;
            });
        }
    }

    /**
     * Clean Sentence.
     *
     * It clean the sentence. If it is a punctuation it will be stored in the
     * property $marks.
     *
     * @param string $sentence A sentence as a string.
     *
     * @return string It is empty string when it's punctuation. Otherwise it's
     *                the trimmed sentence itself.
     */
    protected function cleanSentence(string $sentence): string
    {
        if (strlen(trim($sentence)) == 1) {
            $this->marks[] = trim($sentence);
            return '';

        } else {
            return trim($sentence);
        }
    }

    /**
     * Clean Word.
     *
     * It removes the junk spaces from the word and retrieves it.
     *
     * @param string $word
     *
     * @return string Cleaned word.
     */
    protected function cleanWord(string $word): string
    {
        return mb_strtolower(trim($word));
    }
}
