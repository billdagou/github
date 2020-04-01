<?php
namespace Dagou\Github\ViewHelpers\Uri\Webhook;

use Dagou\Github\Domain\Model\Webhook;
use TYPO3\CMS\Backend\Routing\UriBuilder;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

class EditViewHelper extends AbstractViewHelper {
    public function initializeArguments() {
        $this->registerArgument('webhook', Webhook::class, 'Webhook instance', TRUE);
        $this->registerArgument('command', 'string', 'Command name', TRUE);
    }

    public function render(): string {
        $route = 'tce_db';

        switch ($this->arguments['command']) {
            case 'delete':
                $parameters = [
                    'cmd[tx_github_webhook]['.$this->arguments['webhook']->getUid().'][delete]' => 1,
                    'redirect' => GeneralUtility::getIndpEnv('REQUEST_URI'),
                ];
            break;
            case 'hide':
                $parameters = [
                    'data[tx_github_webhook]['.$this->arguments['webhook']->getUid().'][disabled]' => 1,
                    'redirect' => GeneralUtility::getIndpEnv('REQUEST_URI'),
                ];
            break;
            case 'unhide':
                $parameters = [
                    'data[tx_github_webhook]['.$this->arguments['webhook']->getUid().'][disabled]' => 0,
                    'redirect' => GeneralUtility::getIndpEnv('REQUEST_URI'),
                ];
            break;
            default:
                throw new \InvalidArgumentException('Invalid command given to '.static::class, 1585645888);
        }

        return (string)GeneralUtility::makeInstance(UriBuilder::class)
            ->buildUriFromRoute($route, $parameters);
    }
}