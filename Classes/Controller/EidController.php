<?php
namespace Dagou\Github\Controller;

use Dagou\Github\Domain\Repository\WebhookRepository;
use Dagou\Github\Exception\NoSuchActionException;
use Dagou\Github\Service\WebhookService;
use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Http\Response;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;

class EidController {
    /**
     * @var \TYPO3\CMS\Extbase\Object\ObjectManager
     */
    protected $objectManager;
    /**
     * @var ServerRequestInterface
     */
    protected $request;
    /**
     * @var Response
     */
    protected $response;
    /**
     * @var string
     */
    protected $actionMethodName;

    public function __construct() {
        $this->objectManager = GeneralUtility::makeInstance(ObjectManager::class);
    }

    /**
     * @param \Psr\Http\Message\ServerRequestInterface $request
     *
     * @return \TYPO3\CMS\Core\Http\Response
     */
    public function processRequest(ServerRequestInterface $request): Response {
        $this->request = $request;
        $this->response = new Response();

        $this->actionMethodName = ($request->getParsedBody()['action'] ?? $request->getQueryParams()['action']).'Action';
        if (!method_exists($this, $this->actionMethodName)) {
            throw new NoSuchActionException('An action "'.$this->actionMethodName.'" does not exist in controller "'.static::class.'".', 1585709001);
        }

        $actionResult = $this->{$this->actionMethodName}();

        if (is_string($actionResult) && $actionResult !== '') {
            $this->response->getBody()->write($actionResult);
        } elseif (is_object($actionResult) && method_exists($actionResult, '__toString')) {
            $this->response->getBody()->write((string)$actionResult);
        }

        return $this->response;
    }

    protected function webhookAction() {
        $webhookService = $this->objectManager->get(WebhookService::class);

        $res = GeneralUtility::makeInstance(ConnectionPool::class)->getConnectionForTable('tx_github_webhook')
            ->select(
                [
                    '*'
                ],
                'tx_github_webhook',
                [
                    'uid' => $this->request->getQueryParams()['webhook'],
                ]
            );
        if (($row = $res->fetch()) && $webhookService->securityVerification($this->request, $row['secret'])) {
            if (($payload = $webhookService->parsePayload($this->request)) !== NULL) {
                exec($row['shell']);

                return 'Done';
            } else {
                return 'Invalid payload';
            }
        } else {
            return 'Security verification failed';
        }
    }
}