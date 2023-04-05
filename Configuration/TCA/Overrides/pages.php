<?php

$tca = [
    'palettes' => [
        'tx_rkwbasics_common' => [
            'label' => 'LLL:EXT:rkw_basics/Resources/Private/Language/locallang_db.xlf:tx_rkwbasics_domain_model_pages.palettes.common',
            'showitem' => 'tx_rkwbasics_department,tx_rkwbasics_document_type',
        ],
        'tx_rkwbasics_extended' => [
            'label' => 'LLL:EXT:rkw_basics/Resources/Private/Language/locallang_db.xlf:tx_rkwbasics_domain_model_pages.palettes.extended',
            'showitem' => 'tx_rkwbasics_series,tx_rkwbasics_enterprisesize,tx_rkwbasics_sector,--linebreak--',
        ],
    ],
    'columns' => [

        'tx_rkwbasics_department' => [
            'exclude' => 0,
            'displayCond' => 'FIELD:tx_rkwpdf2content_is_import_sub:=:0',
            'label' => 'LLL:EXT:rkw_basics/Resources/Private/Language/locallang_db.xlf:tx_rkwbasics_domain_model_pages.tx_rkwbasics_department',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingleBox',
                'foreign_table' => 'tx_rkwbasics_domain_model_department',
                'foreign_table_where' => 'AND tx_rkwbasics_domain_model_department.sys_language_uid = ###REC_FIELD_sys_language_uid### ORDER BY tx_rkwbasics_domain_model_department.sorting ASC',
                'minitems' => 1,
                'maxitems' => 1,
                'items' => [
                    ['---', NULL],
                ],
            ],
        ],

        'tx_rkwbasics_document_type' => [
            'exclude' => 0,
            'displayCond' => 'FIELD:tx_rkwpdf2content_is_import_sub:=:0',
            'label' => 'LLL:EXT:rkw_basics/Resources/Private/Language/locallang_db.xlf:tx_rkwbasics_domain_model_pages.tx_rkwbasics_document_type',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingleBox',
                'foreign_table' => 'tx_rkwbasics_domain_model_documenttype',
                'foreign_table_where' => 'AND tx_rkwbasics_domain_model_documenttype.sys_language_uid = ###REC_FIELD_sys_language_uid### AND tx_rkwbasics_domain_model_documenttype.type != "events" ORDER BY tx_rkwbasics_domain_model_documenttype.name ASC',
                'minitems' => 1,
                'maxitems' => 1,
                'items' => [
                    ['---', NULL],
                ],
            ],
        ],

        'tx_rkwbasics_series' => [
            'exclude' => 0,
            'displayCond' => 'FIELD:tx_rkwpdf2content_is_import_sub:=:0',
            'label' => 'LLL:EXT:rkw_basics/Resources/Private/Language/locallang_db.xlf:tx_rkwbasics_domain_model_pages.tx_rkwbasics_series',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'tx_rkwbasics_domain_model_series',
                'foreign_table_where' => 'AND tx_rkwbasics_domain_model_series.sys_language_uid = ###REC_FIELD_sys_language_uid### ORDER BY tx_rkwbasics_domain_model_series.name ASC',
                'minitems' => 0,
                'maxitems' => 1,
                'items' => [
                    ['---', NULL],
                ],
            ],
        ],

        'tx_rkwbasics_enterprisesize' => [
            'exclude' => 0,
            'displayCond' => 'FIELD:tx_rkwpdf2content_is_import_sub:=:0',
            'label' => 'LLL:EXT:rkw_basics/Resources/Private/Language/locallang_db.xlf:tx_rkwbasics_domain_model_pages.tx_rkwbasics_enterprisesize',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'tx_rkwbasics_domain_model_enterprisesize',
                'foreign_table_where' => 'AND tx_rkwbasics_domain_model_enterprisesize.sys_language_uid = ###REC_FIELD_sys_language_uid### ORDER BY tx_rkwbasics_domain_model_enterprisesize.name ASC',
                'minitems' => 0,
                'maxitems' => 1,
                'items' => [
                    ['---', NULL],
                ],
            ],
        ],

        'tx_rkwbasics_sector' => [
            'exclude' => 0,
            'displayCond' => 'FIELD:tx_rkwpdf2content_is_import_sub:=:0',
            'label' => 'LLL:EXT:rkw_basics/Resources/Private/Language/locallang_db.xlf:tx_rkwbasics_domain_model_pages.tx_rkwbasics_sector',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'tx_rkwbasics_domain_model_sector',
                'foreign_table_where' => 'AND tx_rkwbasics_domain_model_sector.sys_language_uid = ###REC_FIELD_sys_language_uid### ORDER BY tx_rkwbasics_domain_model_sector.name ASC',
                'minitems' => 0,
                'maxitems' => 1,
                'items' => [
                    ['---', NULL],
                ],
            ],
        ],

        'tx_rkwbasics_companytype' => [
            'exclude' => 0,
            'displayCond' => 'FIELD:tx_rkwpdf2content_is_import_sub:=:0',
            'label' => 'LLL:EXT:rkw_basics/Resources/Private/Language/locallang_db.xlf:tx_rkwbasics_domain_model_pages.tx_rkwbasics_companytype',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'tx_rkwbasics_domain_model_companytype',
                'foreign_table_where' => 'AND tx_rkwbasics_domain_model_companytype.sys_language_uid = ###REC_FIELD_sys_language_uid### ORDER BY tx_rkwbasics_domain_model_companytype.name ASC',
                'minitems' => 0,
                'maxitems' => 1,
                'items' => [
                    ['---', NULL],
                ],
            ],
        ],
        'tx_rkwbasics_external_link' => [
            'exclude' => 0,
            'displayCond' => 'FIELD:tx_rkwpdf2content_is_import_sub:=:0',
            'label' => 'LLL:EXT:rkw_basics/Resources/Private/Language/locallang_db.xlf:tx_rkwbasics_domain_model_pages.tx_rkwbasics_external_link',
            'config' => array(
                'type' => 'input',
                'renderType' => 'inputLink',
                'fieldControl' => [
                    'linkPopup' => [
                        'options' => [
                            'blindLinkOptions' => 'mail,page,spec,folder,file'
                        ]
                    ]
                ]
            ),
        ],
    ]
];


//===========================================================================
// Add meta-tab to folders
//===========================================================================
/*$GLOBALS['TCA']['pages']['types'][(string)\TYPO3\CMS\Frontend\Page\PageRepository::DOKTYPE_SYSFOLDER] = [
    'showitem' => '--palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.palettes.standard;standard,
        --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.palettes.title;titleonly,
    --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.tabs.access,
        --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.palettes.visibility;hiddenonly,
    --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.tabs.metadata,
        --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.palettes.abstract;abstract,
        --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.palettes.metatags;metatags,
    --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.tabs.appearance,
        --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.palettes.layout;backend_layout,
    --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.tabs.behaviour,
        --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.palettes.miscellaneous;adminsonly,
        --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.palettes.module;module,
    --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.tabs.resources,
        --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.palettes.media;media,
        --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.palettes.config;config,
    --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.tabs.extended,
    '
];*/

$GLOBALS['TCA']['pages'] = array_replace_recursive($GLOBALS['TCA']['pages'], $tca);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
    'pages',
    '
    --div--;LLL:EXT:rkw_basics/Resources/Private/Language/locallang_db.xlf:tx_rkwbasics_domain_model_pages.tabs.rkw,
        --palette--;;tx_rkwbasics_common,
        --palette--;;tx_rkwbasics_extended',
    (string)\TYPO3\CMS\Frontend\Page\PageRepository::DOKTYPE_DEFAULT,
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
    'pages',
    '
    --div--;LLL:EXT:rkw_basics/Resources/Private/Language/locallang_db.xlf:tx_rkwbasics_domain_model_pages.tabs.rkw,
        --palette--;;tx_rkwbasics_common,
        --palette--;;tx_rkwbasics_extended',
    (string)\TYPO3\CMS\Frontend\Page\PageRepository::DOKTYPE_LINK,
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addFieldsToPalette(
    'pages',
    'media',
    '--linebreak--,tx_rkwbasics_external_link,--linebreak--',
    'after:media'
);
