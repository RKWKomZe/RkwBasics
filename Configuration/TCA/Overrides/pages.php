<?php

$tempColumnsPages = [

	'tx_rkwbasics_fe_layout_next_level' => [
		'exclude' => 1,
		'label' => 'LLL:EXT:rkw_basics/Resources/Private/Language/locallang_db.xlf:tx_rkwbasics_domain_model_pages.tx_rkwbasics_fe_layout_next_level',
		'config' => [
		    'type' => 'select',
            'renderType' => 'selectSingle',
			'items' => [
				['LLL:EXT:rkw_basics/Resources/Private/Language/locallang_db.xlf:tx_rkwbasics_domain_model_pages.tx_rkwbasics_fe_layout_next_level.I.0', '0'],
				['LLL:EXT:rkw_basics/Resources/Private/Language/locallang_db.xlf:tx_rkwbasics_domain_model_pages.tx_rkwbasics_fe_layout_next_level.I.1', '1'],
				['LLL:EXT:rkw_basics/Resources/Private/Language/locallang_db.xlf:tx_rkwbasics_domain_model_pages.tx_rkwbasics_fe_layout_next_level.I.2', '2'],
				['LLL:EXT:rkw_basics/Resources/Private/Language/locallang_db.xlf:tx_rkwbasics_domain_model_pages.tx_rkwbasics_fe_layout_next_level.I.3', '3'],
			],
			'size' => 1,
			'maxitems' => 1,
		],
	],

	'tx_rkwbasics_css_class' => [
        'exclude' => 1,
        'label' => 'LLL:EXT:rkw_basics/Resources/Private/Language/locallang_db.xlf:tx_rkwbasics_domain_model_pages.tx_rkwbasics_css_class',
        'config' => [
            'type' => 'select',
            'renderType' => 'selectSingle',
            'items' => [
                ['LLL:EXT:rkw_basics/Resources/Private/Language/locallang_db.xlf:tx_rkwbasics_domain_model_pages.tx_rkwbasics_css_class.I.0', '0'],
                ['LLL:EXT:rkw_basics/Resources/Private/Language/locallang_db.xlf:tx_rkwbasics_domain_model_pages.tx_rkwbasics_css_class.I.1', '1'],
                ['LLL:EXT:rkw_basics/Resources/Private/Language/locallang_db.xlf:tx_rkwbasics_domain_model_pages.tx_rkwbasics_css_class.I.2', '2'],
                ['LLL:EXT:rkw_basics/Resources/Private/Language/locallang_db.xlf:tx_rkwbasics_domain_model_pages.tx_rkwbasics_css_class.I.3', '3'],
            ],
            'size' => 1,
            'maxitems' => 1,
        ],
	],
    'tx_rkwbasics_old_domain' => [
        'exclude' => 1,
        'label' => 'LLL:EXT:rkw_basics/Resources/Private/Language/locallang_db.xlf:tx_rkwbasics_domain_model_pages.tx_rkwbasics_old_domain',
        'config' => [
            'type' => 'input',
            'size' => '50',
            'eval' => 'trim,domainname'
        ],
    ],

    'tx_rkwbasics_old_link' => [
        'exclude' => 1,
        'label' => 'LLL:EXT:rkw_basics/Resources/Private/Language/locallang_db.xlf:tx_rkwbasics_domain_model_pages.tx_rkwbasics_old_link',
        'config' => [
            'type' => 'input',
            'size' => '50',
            'eval' => 'trim,nospace'
        ],
    ],
    'tx_rkwbasics_use_as_canonical' => [
        'exclude' => 1,
        'label' => 'LLL:EXT:rkw_basics/Resources/Private/Language/locallang_db.xlf:tx_rkwbasics_domain_model_pages.tx_rkwbasics_use_as_canonical',
        'config' => [
            'type' => 'check',
            'default' => 0,
            'items' => [
                '1' => [
                    '0' => 'LLL:EXT:rkw_basics/Resources/Private/Language/locallang_db.xlf:tx_rkwbasics_domain_model_pages.tx_rkwbasics_use_as_canonical.I.enabled'
                ],
            ],
        ],
    ],
    'tx_rkwbasics_department' => [
		'exclude' => 0,
        'displayCond' => 'FIELD:tx_bmpdf2content_is_import_sub:=:0',
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
        'displayCond' => 'FIELD:tx_bmpdf2content_is_import_sub:=:0',
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
        'displayCond' => 'FIELD:tx_bmpdf2content_is_import_sub:=:0',
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
        'displayCond' => 'FIELD:tx_bmpdf2content_is_import_sub:=:0',
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
        'displayCond' => 'FIELD:tx_bmpdf2content_is_import_sub:=:0',
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
        'displayCond' => 'FIELD:tx_bmpdf2content_is_import_sub:=:0',
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
    'tx_rkwbasics_teaser_image' => [
        'exclude' => 0,
        'label' => 'LLL:EXT:rkw_basics/Resources/Private/Language/locallang_db.xlf:tx_rkwbasics_domain_model_pages.tx_rkwbasics_teaser_image',

        'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig(
            'txRkwBasicsTeaserImage',
            [
                'maxitems' => 1,

                // Use the imageoverlayPalette instead of the basicoverlayPalette
                'foreign_types' => [
                    '0' => [
                        'showitem' => '
                                --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                                --palette--;;filePalette'
                    ],
                    \TYPO3\CMS\Core\Resource\File::FILETYPE_TEXT => [
                        'showitem' => '
                                --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                                --palette--;;filePalette'
                    ],
                    \TYPO3\CMS\Core\Resource\File::FILETYPE_IMAGE => [
                        'showitem' => '
                                --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                                --palette--;;filePalette'
                    ],
                    \TYPO3\CMS\Core\Resource\File::FILETYPE_AUDIO => [
                        'showitem' => '
                                --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                                --palette--;;filePalette'
                    ],
                    \TYPO3\CMS\Core\Resource\File::FILETYPE_VIDEO => [
                        'showitem' => '
                                --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                                --palette--;;filePalette'
                    ],
                    \TYPO3\CMS\Core\Resource\File::FILETYPE_APPLICATION => [
                        'showitem' => '
                                --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                                --palette--;;filePalette'
                    ],
                ],

            ],
            $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext']
        ),
    ],

    'tx_rkwbasics_file' => [
        'exclude' => 0,
        'displayCond' => 'FIELD:tx_bmpdf2content_is_import_sub:=:0',
        'label' => 'LLL:EXT:rkw_basics/Resources/Private/Language/locallang_db.xlf:tx_rkwbasics_domain_model_pages.tx_rkwbasics_file',
        'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig(
            'txRkwbasicsFile',
            ['maxitems' => 1],
            'doc,docx,docm,xls,xlsx,pdf,zip'
        ),
    ],

    'tx_rkwbasics_cover' => [
        'exclude' => 0,
        'displayCond' => 'FIELD:tx_bmpdf2content_is_import_sub:=:0',
        'label' => 'LLL:EXT:rkw_basics/Resources/Private/Language/locallang_db.xlf:tx_rkwbasics_domain_model_pages.tx_rkwbasics_cover',
        'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig(
            'txRkwbasicsCover',
            ['maxitems' => 1],
            $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext']
        ),
    ],

    'tx_rkwbasics_proxy_caching' => [
        'exclude' => 1,
        'label' => 'LLL:EXT:rkw_basics/Resources/Private/Language/locallang_db.xlf:tx_rkwbasics_domain_model_pages.tx_rkwbasics_proxy_caching',
        'config' => [
            'type' => 'select',
            'renderType' => 'selectSingle',
            'default' => 0,
            'maxitems' => 1,
            'items' => [
                ['LLL:EXT:rkw_basics/Resources/Private/Language/locallang_db.xlf:tx_rkwbasics_domain_model_pages.tx_rkwbasics_proxy_caching.I.inherit', 0],
                ['LLL:EXT:rkw_basics/Resources/Private/Language/locallang_db.xlf:tx_rkwbasics_domain_model_pages.tx_rkwbasics_proxy_caching.I.enabled', 1],
                ['LLL:EXT:rkw_basics/Resources/Private/Language/locallang_db.xlf:tx_rkwbasics_domain_model_pages.tx_rkwbasics_proxy_caching.I.disabled', 2],

            ],
        ],
    ],
];

$tempColumnsPagesMulti = [

    'tx_rkwbasics_alternative_title' => [
        'exclude' => 0,
        'label' => 'LLL:EXT:rkw_basics/Resources/Private/Language/locallang_db.xlf:tx_rkwbasics_domain_model_pages.tx_rkwbasics_alternative_title',
        'config' => [
            'type' => 'input',
            'size' => 50,
            'eval' => 'trim'
        ],
    ],

];


/** @deprecated */
$currentVersion = TYPO3\CMS\Core\Utility\VersionNumberUtility::convertVersionNumberToInteger(TYPO3_version);
if ($currentVersion < 8000000) {

    $tempColumnsPages = array_merge(
        $tempColumnsPages,
        [

            'tx_rkwbasics_article_image' => [
                'exclude' => 0,
                'label' => 'LLL:EXT:rkw_basics/Resources/Private/Language/locallang_db.xlf:tx_rkwbasics_domain_model_pages.tx_rkwbasics_article_image',

                'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig(
                    'txRkwBasicsArticleImage',
                    [
                        'maxitems' => 1,

                        // Use the imageoverlayPalette instead of the basicoverlayPalette
                        'foreign_types' => [
                            '0' => [
                                'showitem' => '
                                --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                                --palette--;;filePalette'
                            ],
                            \TYPO3\CMS\Core\Resource\File::FILETYPE_TEXT => [
                                'showitem' => '
                                --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                                --palette--;;filePalette'
                            ],
                            \TYPO3\CMS\Core\Resource\File::FILETYPE_IMAGE => [
                                'showitem' => '
                                --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                                --palette--;;filePalette'
                            ],
                            \TYPO3\CMS\Core\Resource\File::FILETYPE_AUDIO => [
                                'showitem' => '
                                --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                                --palette--;;filePalette'
                            ],
                            \TYPO3\CMS\Core\Resource\File::FILETYPE_VIDEO => [
                                'showitem' => '
                                --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                                --palette--;;filePalette'
                            ],
                            \TYPO3\CMS\Core\Resource\File::FILETYPE_APPLICATION => [
                                'showitem' => '
                                --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                                --palette--;;filePalette'
                            ],
                        ],

                    ],
                    $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext']
                ),
            ],

            'tx_rkwbasics_article_video' => [
                'exclude' => 0,
                'label' => 'LLL:EXT:rkw_basics/Resources/Private/Language/locallang_db.xlf:tx_rkwbasics_domain_model_pages.tx_rkwbasics_article_video',
                'config' => [
                    'type' => 'input',
                    'size' => 50,
                    'eval' => 'trim'
                ],
            ]
        ]
    );


    $tempColumnsPagesMulti = array_merge (
        $tempColumnsPagesMulti,
        [

            'tx_rkwbasics_teaser_text' => [
                'exclude' => 0,
                'label' => 'LLL:EXT:rkw_basics/Resources/Private/Language/locallang_db.xlf:tx_rkwbasics_domain_model_pages.tx_rkwbasics_teaser_text',
                'config' => [
                    'type' => 'text',
                    'cols' => 40,
                    'rows' => 15,
                    'eval' => 'trim',
                ],
            ],

            'tx_rkwbasics_information' => [
                'exclude' => 0,
                'label' => 'LLL:EXT:rkw_basics/Resources/Private/Language/locallang_db.xlf:tx_rkwbasics_domain_model_pages.tx_rkwbasics_information',
                'config' => [
                    'type' => 'text',
                    'rows' => 42,
                ],
                'defaultExtras' => 'richtext[]:rte_transform[flag=rte_enabled|mode=ts_css]'
            ],
        ]
    );



}

//===========================================================================
// Add meta-tab to folders
//===========================================================================
$GLOBALS['TCA']['pages']['types'][(string)\TYPO3\CMS\Frontend\Page\PageRepository::DOKTYPE_SYSFOLDER] = [
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
];

//===========================================================================
// Add fields
//===========================================================================
// Add TCA
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('pages',$tempColumnsPages);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('pages',$tempColumnsPagesMulti);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('pages_language_overlay',$tempColumnsPagesMulti);

// Add field to the existing palette
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addFieldsToPalette('pages', 'title','--linebreak--,tx_rkwbasics_alternative_title','after:title');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addFieldsToPalette('pages_language_overlay', 'title','--linebreak--,tx_rkwbasics_alternative_title','after:title');

// Add field to the existing palette
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addFieldsToPalette('pages', 'layout','tx_rkwbasics_fe_layout_next_level','after:layout');

// Add field to the existing palette
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addFieldsToPalette('pages', 'media','--linebreak--,tx_rkwbasics_teaser_image,--linebreak--,tx_rkwbasics_file,--linebreak--,tx_rkwbasics_cover,--linebreak--','after:media');

// Add field to the existing palette
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addFieldsToPalette('pages', 'access','--linebreak--,tx_rkwbasics_proxy_caching','after:fe_login_mode');

/** @deprecated */
if ($currentVersion < 8000000) {
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addFieldsToPalette('pages', 'abstract','tx_rkwbasics_teaser_text,--linebreak--,tx_rkwbasics_article_image,--linebreak--,tx_rkwbasics_article_video','before:abstract');
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addFieldsToPalette('pages_language_overlay', 'abstract', 'tx_rkwbasics_teaser_text','before:abstract');

    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes('pages','tx_rkwbasics_information', '', 'after:abstract');
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes('pages_language_overlay','tx_rkwbasics_information', '', 'after:abstract');
}

// Add field after another
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes('pages','tx_rkwbasics_css_class', '', 'after:backend_layout_next_level');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes('pages','tx_rkwbasics_old_domain', '', 'after:subtitle');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes('pages','tx_rkwbasics_old_link', '', 'after:tx_rkwbasics_old_domain');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes('pages','tx_rkwbasics_use_as_canonical', '', 'after:tx_rkwbasics_old_link');

// Add new palette for departments etc.
$tempConfig = 'tx_rkwbasics_department,tx_rkwbasics_document_type';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addFieldsToPalette('pages', 'tx_rkwbasics_common', $tempConfig);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addFieldsToPalette('pages_language_overlay', 'tx_rkwbasics_common', '');
$GLOBALS['TCA']['pages']['palettes']['tx_rkwbasics_common']['canNotCollapse'] = 1;
$GLOBALS['TCA']['pages_language_overlay']['palettes']['tx_rkwbasics_common']['canNotCollapse'] = 1;

// Add new empty palette for rkw_basics
$tempConfig = 'tx_rkwbasics_series,tx_rkwbasics_enterprisesize,tx_rkwbasics_sector';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addFieldsToPalette('pages', 'tx_rkwbasics_extended', $tempConfig );
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addFieldsToPalette('pages_language_overlay', 'tx_rkwbasics_extended','');
$GLOBALS['TCA']['pages']['palettes']['tx_rkwbasics_extended']['canNotCollapse'] = 1;
$GLOBALS['TCA']['pages_language_overlay']['palettes']['tx_rkwbasics_extended']['canNotCollapse'] = 1;

// Add new empty palette for rkw_basics
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addFieldsToPalette('pages', 'tx_rkwbasics_extended2','');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addFieldsToPalette('pages_language_overlay', 'tx_rkwbasics_extended2','');
$GLOBALS['TCA']['pages']['palettes']['tx_rkwbasics_extended2']['canNotCollapse'] = 1;
$GLOBALS['TCA']['pages_language_overlay']['palettes']['tx_rkwbasics_extended2']['canNotCollapse'] = 1;

// Add the two palettes to new tab
$tempConfig = '--div--;LLL:EXT:rkw_basics/Resources/Private/Language/locallang_db.xlf:tx_rkwbasics_domain_model_pages.tabs.rkw,--palette--;LLL:EXT:rkw_basics/Resources/Private/Language/locallang_db.xlf:tx_rkwbasics_domain_model_pages.palettes.common;tx_rkwbasics_common,--palette--;LLL:EXT:rkw_basics/Resources/Private/Language/locallang_db.xlf:tx_rkwbasics_domain_model_pages.palettes.extended;tx_rkwbasics_extended,--palette--;LLL:EXT:rkw_basics/Resources/Private/Language/locallang_db.xlf:tx_rkwbasics_domain_model_pages.palettes.extended2;tx_rkwbasics_extended2';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes('pages', $tempConfig , '1,3');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes('pages_language_overlay',$tempConfig , '1,3');

