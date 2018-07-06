<?php

namespace App\Parser;

class Parser implements ParserInterface
{
    /** @var ParserInterface[] */
    protected static $parsers;

    public static function setParsers(array $parsers): void
    {
        static::$parsers = $parsers;
    }

    public function __invoke(string $content)
    {
        $results = [];

        foreach (static::$parsers as $alias => $parser) {
            $results[$alias] = $parser($content);
        }
        
        return $results;
    }
}