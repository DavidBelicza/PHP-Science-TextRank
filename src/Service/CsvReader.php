<?php

declare(strict_types=1);

namespace PhpScience\TextRank\Service;

use Generator;
use PhpScience\TextRank\Exception\IoException;

class CsvReader implements ReaderInterface
{
    public function read(string $path): Generator
    {
        $resource = $this->getResource($path);

        while (false !== ($row = fgetcsv($resource))) {
            yield array_values($row);
        }

        fclose($resource);
    }

    private function getResource(string $path)
    {
        $resource = fopen($path, 'r');

        if (false === $resource) {
            throw new IoException(sprintf('Can\'t read file [%s]', $path));
        }

        return $resource;
    }
}
