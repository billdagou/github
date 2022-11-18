<?php
return [
    'ctrl' => [
        'title' => 'LLL:EXT:github/Resources/Private/Language/locallang_tca.xlf:tx_github_webhook',
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
                'type' => 'passthrough',
            ]
        ],
        'title' => [
            'label' => 'LLL:EXT:github/Resources/Private/Language/locallang_tca.xlf:tx_github_webhook.title',
            'config' => [
                'type' => 'input',
            ],
        ],
        'secret' => [
            'label' => 'LLL:EXT:github/Resources/Private/Language/locallang_tca.xlf:tx_github_webhook.secret',
            'config' => [
                'type' => 'slug',
                'appearance' => [
                    'prefix' => \Dagou\Github\UserFunction\TCA\Slug::class.'->appearancePrefix',
                ],
                'generatorOptions' => [
                    'postModifiers' => [
                        \Dagou\Github\UserFunction\TCA\Slug::class.'->postModifier',
                    ],
                ],
            ],
        ],
        'shell' => [
            'label' => 'LLL:EXT:github/Resources/Private/Language/locallang_tca.xlf:tx_github_webhook.shell',
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