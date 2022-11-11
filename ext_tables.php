<?php
defined('TYPO3_MODE') or die();

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addModule(
    'github',
    '',
    '',
    NULL,
    [
        'labels' => 'LLL:EXT:github/Resources/Private/Language/locallang_mod.xlf',
        'name' => 'github',
        'iconIdentifier' => 'modulegroup-github',
    ]
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
    'Github',
    'github',
    'webhook',
    '',
    [
        \Dagou\Github\Controller\WebhookController::class => 'list',
    ],
    [
        'access' => 'admin',
        'iconIdentifier' => 'module-webhook',
        'labels' => 'LLL:EXT:github/Resources/Private/Language/locallang_mod_webhook.xlf',
    ]
);