<?php
declare(strict_types = 1);

return [
    \RKW\RkwBasics\Domain\Model\Pages::class => [
        'tableName' => 'pages',
        'properties' => [
            'uid' => [
                'fieldName' => 'uid'
            ],
            'pid' => [
                'fieldName' => 'pid'
            ],
            'sysLanguageUid' => [
                'fieldName' => 'sys_language_uid'
            ],
            'sorting' => [
                'fieldName' => 'sorting'
            ],
            'tstamp' => [
                'fieldName' => 'tstamp'
            ],
            'crdate' => [
                'fieldName' => 'crdate'
            ],
            'hidden' => [
                'fieldName' => 'hidden'
            ],
            'doktype' => [
                'fieldName' => 'doktype'
            ],
            'title' => [
                'fieldName' => 'title'
            ],
            'subtitle' => [
                'fieldName' => 'subtitle'
            ],
            'noSearch' => [
                'fieldName' => 'no_search'
            ],
            'lastUpdated' => [
                'fieldName' => 'lastUpdated'
            ],
            'abstract' => [
                'fieldName' => 'abstract'
            ],
        ],
    ],
    \RKW\RkwBasics\Domain\Model\Category::class => [
        'tableName' => 'sys_category',
    ]
];
