<h1 align="center">
TextRank
</h1>

<p align="center">
    <a href="https://github.com/PHP-Science/TextRank/actions">
		<img src="https://github.com/php-science/textrank/workflows/tests/badge.svg"/>
	</a>
	<a href="https://packagist.org/packages/php-science/textrank">
	    <img src="https://poser.pugx.org/php-science/textrank/v/stable.svg" />
	</a>
	<a href="https://packagist.org/packages/php-science/textrank">
        <img src="https://poser.pugx.org/php-science/textrank/downloads"/>
    </a>
	<a href="https://github.com/PHP-Science/TextRank/blob/master/LICENSE">
        <img src="https://img.shields.io/badge/license-MIT-FFF300.svg"/>
    </a>
</p>

<p align="center">
This source code is an implementation of TextRank algorithm in PHP programming language, under MIT licence.<br />
<br />
</p>

# TextRank vs. ChatGPT
GPTs like ChatGPT are supervised language models that understand the context and generate new content from the given
input using vast resources while TextRank is a cost-efficient/low-cost text extraction algorithm. TextRank algorithm 
also can be used as a pre-processor to a GPT model to reduce the text size to save on resource consumption.

# TextRank or Automatic summarization
> Automatic summarization is the process of reducing a text document with a computer program in order to create a summary that retains the most important points of the original document. Technologies that can make a coherent summary take into account variables such as length, writing style and syntax. Automatic data summarization is part of machine learning and data mining. The main idea of summarization is to find a representative subset of the data, which contains the information of the entire set. Summarization technologies are used in a large number of sectors in industry today. - Wikipedia

The algorithm of this implementation is:
* Extracts sentences,
* Removes stopwords,
* Adds integer values to words by finding and counting the matching words,
* Weights the values of the words,
* Normalizes values to get the scores,
* Sorts by scores

# Install to use it in your project
```
cd your-project-folder
composer require php-science/textrank
```

# Install for contributing
```
cd git-project-folder
docker-compose build
docker-compose up -d
composer install
composer test
```

# Examples
```php

use PhpScience\TextRank\Tool\StopWords\English;

// String contains a long text, see the /res/sample1.txt file.
$text = "Lorem ipsum...";

$api = new TextRankFacade();
// English implementation for stopwords/junk words:
$stopWords = new English();
$api->setStopWords($stopWords);

// Array of the most important keywords:
$result = $api->getOnlyKeyWords($text); 

// Array of the sentences from the most important part of the text:
$result = $api->getHighlights($text); 

// Array of the most important sentences from the text:
$result = $api->summarizeTextBasic($text);
```
More examples: 
* [tests/TextRankFacadeTest.php](https://github.com/DavidBelicza/PHP-Science-TextRank/blob/master/tests/TextRankFacadeTest.php)
* https://php.science

# Authors, Contributors

Name | GitHub user
--- | ---
David Belicza | @DavidBelicza
Riccardo Marton | @riccardomarton
Syndesi | @Syndesi 
vincentsch | @vincentsch
Andrew Welch | @khalwat 
Andrey Astashov | @mvcaaa
Leo Toneff | @bragle
Willy Arisky | @willyarisky
Robert-Jan Keizer | @KeizerDev
Morty | @evil1morty
Sezer Fidancı | @SezerFidanci
