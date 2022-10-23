<?php

namespace Tests\Unit\Core\Services;

use A3F\Core\Components\Clients\ResponseHandler;
use A3F\Core\Components\Parsers\Html\ContentParser;
use A3F\Core\Components\Parsers\Html\Tag;
use A3F\Core\Services\RemotePage\RemotePageService;
use A3F\Core\Services\RemotePage\Request;
use A3F\Core\Services\RemotePage\transport\DefaultTransport;
use A3F\Core\Services\RemotePage\transport\WithResponseHandle;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\MockResponse;
use Tests\Support\UnitTester;

class RemotePageServiceTest extends \Codeception\Test\Unit
{
    protected UnitTester $tester;

    /**
     * @return void
     */
    public function testTagsInfo():void
    {
        $service = $this->service(new MockResponse("    
           <html lang='en'>
                <head>
                    <meta charset='utf-8'>
                    <link rel='dns-prefetch' href='https://github.githubassets.com'>
                </head>
                <body>
                   <div class='hello_1'>
                      <span>Hello</span>
                      <a href='sss'>Link</a>
                      <div>
                         <div></div>                     
                      </div>
                   </div>
                   <div class='hello_2'></div>
                </body>
           </html>
        "));
        $request = new Request('http://test.local');
        $response = $service->tagsInfo($request);
        $this->tester->assertTrue($response->isSuccess());
        $this->tester->assertEquals([
            'html',
            'head',
            'meta',
            'link',
            'body',
            'div',
            'span',
            'a',
            'div',
            'div',
            'div'
        ], array_map(
            static fn(Tag $tag) => $tag->getTag(),
            $response->tags->getItems()
        ));
        $this->tester->assertEquals(11, $response->countTags());
    }

    /**
     * @return void
     */
    public function testTagsInfoWithError():void
    {
        $service = $this->service(new MockResponse($errorMessage = 'Wrong with out site', ['http_code' => '500']));
        $request = new Request('http://test.local');
        $response = $service->tagsInfo($request);
        $this->tester->assertFalse($response->isSuccess());
        $this->tester->assertEquals(
            "Remote server with another response code: 500. {$errorMessage}",
            $response->getErrorText()
        );
    }

    /**
     * @param $response
     * @return RemotePageService
     */
    protected function service($response): RemotePageService
    {
        return new RemotePageService(
            new WithResponseHandle(
                new DefaultTransport(
                    new MockHttpClient([$response])
                ),
                new ResponseHandler()
            ),
            new ContentParser()
        );
    }
}
