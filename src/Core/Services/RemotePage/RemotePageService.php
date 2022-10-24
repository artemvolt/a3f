<?php

namespace A3F\Core\Services\RemotePage;

use A3F\Core\Components\Parsers\Html\ContentParser;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Url;
use Symfony\Component\Validator\Validation;
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
        $validator = Validation::createValidator();
        $errors = $validator->validate($request->url, [
            new Url([
                'protocols' => ['http', 'https'],
                'message' => 'The url "{{ value }}" is not a valid url.',
            ]),
            new NotBlank()
        ]);

        if (count($errors) > 0) {
            return Response::validateErrors($errors);
        }

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