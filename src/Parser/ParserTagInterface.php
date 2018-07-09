<?php

namespace App\Parser;

interface ParserTagInterface
{
    public function __invoke(string $content, string $tag);
}

