<?php
namespace Dagou\Github\Controller;

use TYPO3\CMS\Extbase\Annotation\Inject;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

class WebhookController extends ActionController {
    /**
     * @var \Dagou\Github\Domain\Repository\WebhookRepository
     * @Inject
     */
    protected $webhookRepository;

    protected function listAction() {
        $this->view->assignMultiple([
            'webhooks' => $this->webhookRepository->findAll(),
        ]);
    }
}