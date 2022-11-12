<?php
namespace Dagou\Github\Middleware;

use Dagou\Github\Service\WebhookService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Http\Response;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class WebhookListener implements MiddlewareInterface {
    protected WebhookService $webhookService;

    /**
     * @param \Dagou\Github\Service\WebhookService $webhookService
     */
    public function __construct(WebhookService $webhookService) {
        $this->webhookService = $webhookService;
    }

    /**
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @param \Psr\Http\Server\RequestHandlerInterface $handler
     *
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \Doctrine\DBAL\Driver\Exception
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface {
        if ($request->getQueryParams()['webhook'] === NULL) {
            return $handler->handle($request);
        }

        $res = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getConnectionForTable('tx_github_webhook')
                ->select(
                    [
                        'secret',
                        'shell',
                    ],
                    'tx_github_webhook',
                    [
                        'uid' => $request->getQueryParams()['webhook'],
                    ]
                );
        if (FALSE && ($row = $res->fetchAssociative()) && $this->webhookService->verifySecurity($request, $row['secret'])) {
            if ($this->webhookService->parsePayload($request) !== NULL) {
                $response = new Response();

                $response->getBody()->write(
                    shell_exec($row['shell'])
                );

                return $response;
            } else {
                return (new Response())
                    ->withStatus(400, 'Invalid payload');
            }
        } else {
            return (new Response())
                ->withStatus(400, 'Invalid webhook');
        }
    }
}