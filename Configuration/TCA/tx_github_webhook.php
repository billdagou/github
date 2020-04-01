<?php
return [
    'ctrl' => [
        'title' => 'LLL:EXT:github/Resources/Private/Language/locallang_db.xlf:tx_github_webhook',
        'label' => 'title',
        'crdate' => 'crdate',
        'tstamp' => 'tstamp',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'disabled',
        ],
        'rootLevel' => 1,
    ],
    'interface' => [
        'maxDBListItems' => 5,
        'maxSingleDBListItems' => 20,
        'showRecordFieldList' => 'title, secret, shell',
    ],
    'columns' => [
        'disabled' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.enabled',
            'config' => [
                'type' => 'check',
                'renderType' => 'checkboxToggle',
                'items' => [
                    [
                        0 => '',
                        1 => '',
                        'invertStateDisplay' => TRUE,
                    ]
                ],
            ]
        ],
        'title' => [
            'label' => 'LLL:EXT:github/Resources/Private/Language/locallang_db.xlf:tx_github_webhook.title',
            'config' => [
                'type' => 'input',
            ],
        ],
        'secret' => [
            'label' => 'LLL:EXT:github/Resources/Private/Language/locallang_db.xlf:tx_github_webhook.secret',
            'config' => [
                'type' => 'input',
                'default' => (new \TYPO3\CMS\Core\Crypto\Random())->generateRandomHexString(16),
            ],
        ],
        'shell' => [
            'label' => 'LLL:EXT:github/Resources/Private/Language/locallang_db.xlf:tx_github_webhook.shell',
            'config' => [
                'type' => 'text',
            ],
        ],
    ],
    'types' => [
        '0' => [
            'showitem' => 'title, shell, secret',
        ],
    ],
];