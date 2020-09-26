<?php

declare(strict_types=1);

namespace PhpScience\TextRank\Data;

interface AlgorithmRequestInterface
{
    /**
     * @return string
     */
    public function getStopWordCsvPath(): string;

    /**
     * @param string $stopWordCsvPath
     */
    public function setStopWordCsvPath(string $stopWordCsvPath): void;

    /**
     * @return int
     */
    public function getMinKeywordLength(): int;

    /**
     * @param int $minKeywordLength
     */
    public function setMinKeywordLength(int $minKeywordLength): void;

    /**
     * @return string
     */
    public function getRawText(): string;

    /**
     * @param string $rawText
     */
    public function setRawText(string $rawText): void;

    /**
     * @return int
     */
    public function getMaxKeywords(): int;

    /**
     * @param int $maxKeywords
     */
    public function setMaxKeywords(int $maxKeywords): void;

    /**
     * @return int
     */
    public function getMaxKeySentences(): int;

    /**
     * @param int $maxKeySentences
     */
    public function setMaxKeySentences(int $maxKeySentences): void;

    /**
     * @return int
     */
    public function getPageRankPowerIteration(): int;

    /**
     * @param int $pageRankPowerIteration
     */
    public function setPageRankPowerIteration(int $pageRankPowerIteration): void;
}
