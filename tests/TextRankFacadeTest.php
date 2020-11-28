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

use PhpScience\TextRank\Tool\StopWords\English;
use PhpScience\TextRank\Tool\StopWords\Russian;
use PhpScience\TextRank\Tool\Summarize;
use PHPUnit\Framework\TestCase;

class TextRankFacadeTest extends TestCase
{
    protected $sampleText1;

    public function setUp(): void
    {
        parent::setUp();

        $path =  __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'res'
            . DIRECTORY_SEPARATOR . 'sample1.txt';
        $file = fopen($path, 'r');

        $this->sampleText1 = fread($file, filesize($path));

        fclose($file);
    }

    public function testGetOnlyKeyWords()
    {
        $api = new TextRankFacade();
        $stopWords = new English();
        $api->setStopWords($stopWords);

        $result = $api->getOnlyKeyWords($this->sampleText1);

        $this->assertTrue(count($result) > 0);
        $this->assertTrue(array_values($result)[0] == 1);
    }

    public function testGetHighlights()
    {
        $api = new TextRankFacade();
        $stopWords = new English();
        $api->setStopWords($stopWords);

        $result = $api->getHighlights($this->sampleText1);

        $this->assertTrue(count($result) > 0);
    }

    public function testSummarizeTextCompound()
    {
        $api = new TextRankFacade();
        $stopWords = new English();
        $api->setStopWords($stopWords);

        $result = $api->summarizeTextCompound($this->sampleText1);

        $this->assertTrue(count($result) > 0);
    }

    public function testSummarizeTextBasic()
    {
        $api = new TextRankFacade();
        $stopWords = new English();
        $api->setStopWords($stopWords);

        $result = $api->summarizeTextBasic($this->sampleText1);

        $this->assertTrue(count($result) > 0);
    }

    public function testSummarizeTextFreely()
    {
        $api = new TextRankFacade();
        $stopWords = new English();
        $api->setStopWords($stopWords);

        $result = $api->summarizeTextFreely(
            $this->sampleText1,
            5,
            2,
            Summarize::GET_ALL_IMPORTANT
        );

        $this->assertTrue(count($result) == 2);

        $result = $api->summarizeTextFreely(
            $this->sampleText1,
            10,
            1,
            Summarize::GET_FIRST_IMPORTANT_AND_FOLLOWINGS
        );

        $this->assertTrue(count($result) == 1);

        // Stop words.
        $result = $api->summarizeTextFreely(
            'one two. one two. three four.',
            2,
            10,
            Summarize::GET_ALL_IMPORTANT
        );

        $this->assertTrue(count($result) == 0);

        // Less sentences then expected.
        $result = $api->summarizeTextFreely(
            'lorem ipsum. lorem holy ipsum. sit dolor amet.',
            2,
            10,
            Summarize::GET_ALL_IMPORTANT
        );

        $this->assertTrue(count($result) == 2);
    }

    public function testSmallText()
    {
        $api = new TextRankFacade();
        $stopWords = new English();
        $api->setStopWords($stopWords);

        $result = $api->getOnlyKeyWords('lorem ipsum sit');

        $this->assertEquals(2, count($result));

        $result = $api->getOnlyKeyWords('sit');

        $this->assertEquals(0, count($result));

        $result = $api->getOnlyKeyWords('');

        $this->assertEquals(0, count($result));
    }

    public function testSmallTextRu()
    {
        $api = new TextRankFacade();
        $stopWords = new Russian();
        $api->setStopWords($stopWords);
        $result = $api->getOnlyKeyWords('между холодными ладонями');
        $this->assertCount(2, $result);

        $result = $api->getOnlyKeyWords('конец');
        $this->assertCount(0, $result);

        $result = $api->getOnlyKeyWords('');
        $this->assertCount(0, $result);
    }
}
