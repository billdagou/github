<?php
return [
    'frontend' => [
        'github/webhook' => [
            'target' => \Dagou\Github\Middleware\WebhookListener::class,
            'after' => [
                'typo3/cms-core/normalized-params-attribute',
            ],
            'before' => [
                'typo3/cms-frontend/eid',
            ],
        ],
    ]
];