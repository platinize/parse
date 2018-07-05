<?php

namespace App\Parse;

use Generator;

interface Downloader
{
    public function getUrls(array $urls): Generator;

    public function getBodies(array $urls): Generator;
}