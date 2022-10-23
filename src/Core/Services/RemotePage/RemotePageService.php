<?php

namespace A3F\Core\Services\RemotePage;

use A3F\Core\Components\Parsers\Html\ContentParser;
use Throwable;

/**
 * class RemotePageUseCase
 */
class RemotePageService
{
    private ContentParser $parser;
    private Transport $transport;

    public function __construct(
        Transport $transport,
        ContentParser $parser
    ) {

        $this->transport = $transport;
        $this->parser = $parser;
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function tagsInfo(Request $request):Response {
        try {
            $response = $this->transport->send($request->url);
            $tags = $this->parser->parse($response->getContent());
        } catch (Throwable $e) {
            return Response::error($e);
        }

        $response = Response::success();
        $response->tags = $tags;
        return $response;
    }
}