<?php
defined('TYPO3_MODE') or die();

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
    'Dagou.Github',
    'site',
    'webhook',
    '',
    [
        'Webhook' => 'list',
    ],
    [
        'access' => 'admin',
        'icon' => 'EXT:github/Resources/Public/Icons/mod_webhook.png',
        'labels' => 'LLL:EXT:github/Resources/Private/Language/locallang_mod_webhook.xlf'
    ]
);