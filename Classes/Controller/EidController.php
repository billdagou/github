<?php
namespace Dagou\Github\Controller;

use Dagou\Github\Domain\Repository\WebhookRepository;
use Dagou\Github\Exception\NoSuchActionException;
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

        $this->webhookRepository = $this->objectManager->get(WebhookRepository::class);
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
        if (($row = $res->fetch())) {
            file_put_contents('./webhook', print_r($this->request->getHeaders(), TRUE), FILE_APPEND);
            file_put_contents('./webhook', print_r($this->request->getBody()->getContents(), TRUE), FILE_APPEND);
        }
    }
}