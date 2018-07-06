<?php

namespace App\Parser;

interface ParserInterface
{
    public function __invoke(string $content);
}

