<?php

namespace App\Parse;

use Generator;

interface TagsInterface
{
    public function getTags(array $urls, array $tags): Generator;
}