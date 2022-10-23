<?php

namespace A3F\App\Commands;

use A3F\Core\Components\Clients\ResponseHandler;
use A3F\Core\Components\Parsers\Html\ContentParser;
use A3F\Core\Components\Parsers\Html\Tag;
use A3F\Core\Services\RemotePage\RemotePageService;
use A3F\Core\Services\RemotePage\Request;
use A3F\Core\Services\RemotePage\transport\DefaultTransport;
use A3F\Core\Services\RemotePage\transport\WithResponseHandle;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\HttpClient\CurlHttpClient;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface as TransportExceptionInterfaceAlias;

/**
 * class ParserCommand
 */
#[AsCommand(
    name: 'parser',
    description: 'Вывод тегов и их кол-ва на странице',
    hidden: false
)]
class ParserCommand extends Command
{
    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $service = new RemotePageService(
            new WithResponseHandle(
                new DefaultTransport(new CurlHttpClient()),
                new ResponseHandler()
            ),
            new ContentParser()
        );
        $request = new Request('https://ru.wikipedia.org/wiki/Синтаксический_анализ');
        $response = $service->tagsInfo($request);
        if ($response->isSuccess()) {
            foreach ($response->tags->slice(10)->getItems() as $tag) {
                /**
                 * @var Tag $tag
                 */
                $output->writeln('-- tag: '. $tag->getTag());
            }
            $output->writeln("Show first 10 tags.");
            $output->writeln("Count tags: " . $response->countTags());
            return Command::SUCCESS;
        }

        $output->writeln("We have some error on response: {$response->getErrorText()}");
        return Command::FAILURE;
    }
}