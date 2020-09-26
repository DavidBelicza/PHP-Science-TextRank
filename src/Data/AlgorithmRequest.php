<?php

declare(strict_types=1);

namespace PhpScience\TextRank\Data;

class AlgorithmRequest implements AlgorithmRequestInterface
{
    private string $stopWordCsvPath;
    private string $rawText;
    private int    $maxKeywords;
    private int    $maxKeySentences;
    private int    $pageRankPowerIteration;

    public function __construct(
        string $stopWordCsvPath = __DIR__ . '/../resource/stop-word/english.csv',
        int $maxKeywords = 10,
        int $maxKeySentences = 5,
        int $pageRankPowerIteration = 10
    ) {
        $this->stopWordCsvPath = $stopWordCsvPath;
        $this->maxKeywords = $maxKeywords;
        $this->maxKeySentences = $maxKeySentences;
        $this->pageRankPowerIteration = $pageRankPowerIteration;
    }

    public function getStopWordCsvPath(): string
    {
        return $this->stopWordCsvPath;
    }

    public function setStopWordCsvPath(string $stopWordCsvPath): void
    {
        $this->stopWordCsvPath = $stopWordCsvPath;
    }

    public function getRawText(): string
    {
        return $this->rawText;
    }

    public function setRawText(string $rawText): void
    {
        $this->rawText = $rawText;
    }

    public function getMaxKeywords(): int
    {
        return $this->maxKeywords;
    }

    public function setMaxKeywords(int $maxKeywords): void
    {
        $this->maxKeywords = $maxKeywords;
    }

    public function getMaxKeySentences(): int
    {
        return $this->maxKeySentences;
    }

    public function setMaxKeySentences(int $maxKeySentences): void
    {
        $this->maxKeySentences = $maxKeySentences;
    }

    public function getPageRankPowerIteration(): int
    {
        return $this->pageRankPowerIteration;
    }

    public function setPageRankPowerIteration(int $pageRankPowerIteration): void
    {
        $this->pageRankPowerIteration = $pageRankPowerIteration;
    }
}
