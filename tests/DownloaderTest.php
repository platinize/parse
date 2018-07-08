<?php

namespace Tests\Unit\Parser;

use App\Downloader\Downloader;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Stream;
use PHPUnit\Framework\TestCase;

class DownloaderTest extends TestCase
{
    /**  @test  */
    public function test_download()
    {
        $mock = new MockHandler([
            new Response(),
        ]);

        $handler = HandlerStack::create($mock);

        $client = new Client(['handler' => $handler]);

        $downloader = new Downloader($client);

        $requests = $downloader->download(['/']);
        foreach ($requests as $request) {
            $this->assertInstanceOf(Stream::class, $request);
        }
    }
}
