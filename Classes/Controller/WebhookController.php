<?php
namespace Dagou\Github\Controller;

use Dagou\Github\Domain\Repository\WebhookRepository;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Backend\Routing\UriBuilder as BackendUriBuilder;
use TYPO3\CMS\Backend\Template\ModuleTemplate;
use TYPO3\CMS\Backend\Template\ModuleTemplateFactory;
use TYPO3\CMS\Core\Http\HtmlResponse;
use TYPO3\CMS\Core\Imaging\Icon;
use TYPO3\CMS\Core\Imaging\IconFactory;
use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Mvc\View\ViewInterface;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

class WebhookController extends ActionController {
    protected ModuleTemplateFactory $moduleTemplateFactory;
    protected BackendUriBuilder $backendUriBuilder;
    protected IconFactory $iconFactory;
    protected WebhookRepository $webhookRepository;
    protected ?ModuleTemplate $moduleTemplate = NULL;

    /**
     * @param \TYPO3\CMS\Backend\Template\ModuleTemplateFactory $moduleTemplateFactory
     * @param \TYPO3\CMS\Backend\Routing\UriBuilder $backendUriBuilder
     * @param \TYPO3\CMS\Core\Imaging\IconFactory $iconFactory
     * @param \Dagou\Github\Domain\Repository\WebhookRepository $webhookRepository
     */
    public function __construct(
        ModuleTemplateFactory $moduleTemplateFactory,
        BackendUriBuilder $backendUriBuilder,
        IconFactory $iconFactory,
        WebhookRepository $webhookRepository
    ) {
        $this->moduleTemplateFactory = $moduleTemplateFactory;
        $this->backendUriBuilder = $backendUriBuilder;
        $this->iconFactory = $iconFactory;
        $this->webhookRepository = $webhookRepository;
    }

    protected function initializeAction() {
        $this->moduleTemplate = $this->moduleTemplateFactory->create($this->request)
            ->setTitle(LocalizationUtility::translate('LLL:EXT:github/Resources/Private/Language/locallang_mod.xlf:mlang_tabs_tab'));
    }

    /**
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \TYPO3\CMS\Backend\Routing\Exception\RouteNotFoundException
     */
    protected function listAction(): ResponseInterface {
        $this->view->assign('webhooks', $this->webhookRepository->findAll());

        $buttonBar = $this->moduleTemplate->getDocHeaderComponent()->getButtonBar();

        $buttonBar->addButton(
            $buttonBar->makeLinkButton()
                ->setIcon($this->iconFactory->getIcon('actions-add', Icon::SIZE_SMALL))
                ->setTitle(LocalizationUtility::translate('button.create.webhook', 'Github'))
                ->setHref(
                    $this->backendUriBuilder->buildUriFromRoute('record_edit', [
                        'edit' => [
                            'tx_github_webhook' => [
                                'new',
                            ],
                        ],
                        'returnUrl' => $this->request->getAttribute('normalizedParams')->getRequestUri(),
                    ])
                )
        );

        return new HtmlResponse(
            $this->moduleTemplate->setContent($this->view->render())
                ->renderContent()
        );
    }
}