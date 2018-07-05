<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use App\Parse\Downloader;
use GuzzleHttp\Client;

class DownloaderTest extends TestCase
{
    public $urls = [
        'http://www.11x11.ru/',
        'http://www.butsa.ru/',
        'http://hrunserzne.ru/'
    ];

    public function test_getUrls()
    {
        $load = new Downloader(new Client());
        $urls = $load->getUrls($this->urls);
        $count = 0;
        foreach ($urls as $url) {
            $count++;
        }
        $this->assertSame($count, count($this->urls));
    }

}
