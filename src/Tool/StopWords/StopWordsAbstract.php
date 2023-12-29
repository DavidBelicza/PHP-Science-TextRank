<?php
/**
 * PHP Science TextRank (http://php.science/)
 *
 * @see     https://github.com/DavidBelicza/PHP-Science-TextRank
 * @license https://opensource.org/licenses/MIT the MIT License
 * @author  David Belicza <david@belicza.com>
 */

declare(strict_types=1);

namespace PhpScience\TextRank\Tool\StopWords;

/**
 * Class StopWordsAbstract
 *
 * @package PhpScience\TextRank\Tool\StopWords
 */
abstract class StopWordsAbstract
{
    /**
     * Stop words for avoid dummy keywords.
     *
     * @var array
     */
    protected $words = [];

    /**
     * It retrieves the word exists or does not in the list of Stop words.
     *
     * @param string $word
     *
     * @return bool It is True when it exists.
     */
    public function exist(string $word): bool
    {
        return array_search($word, $this->words) !== false;
    }
}
