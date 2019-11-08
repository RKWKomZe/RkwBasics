<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

$tempColumnsContent = [

    'tx_rkwbasics_images_no_copyright' => [
        'exclude' => 0,
        'label' => 'LLL:EXT:rkw_basics/Resources/Private/Language/locallang_db.xlf:tx_rkwbasics_domain_model_content.tx_rkwbasics_images_no_copyright',
        'config' => [
            'type' => 'check',
            'default' => 0,
			'items' => [
                '1' => [
                    '0' => 'LLL:EXT:rkw_basics/Resources/Private/Language/locallang_db.xlf:tx_rkwbasics_domain_model_content.tx_rkwbasics_images_no_copyright.I.disabled'
                ],
            ],
        ],
    ],

    'tx_rkwbasics_bodytext_mobile' => [
        'exclude' => 0,
        'label' => 'LLL:EXT:rkw_basics/Resources/Private/Language/locallang_db.xlf:tx_rkwbasics_domain_model_content.tx_rkwbasics_bodytext_mobile',
        'config' => [
            'type' => 'text',
            'rows' => 42,
        ],
        'defaultExtras' => 'richtext[]'
    ],

    'tx_rkwbasics_header_link_caption' => [
        'exclude' => 0,
        'label' => 'LLL:EXT:rkw_basics/Resources/Private/Language/locallang_db.xlf:tx_rkwbasics_domain_model_content.tx_rkwbasics_header_link_caption',
        'config' => [
            'type' => 'input',
            'size' => '30',
            'eval' => 'trim'
        ],
    ],
];

// Add TCA
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('tt_content',$tempColumnsContent);

// Add fields
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addFieldsToPalette('tt_content', 'image_settings','tx_rkwbasics_images_no_copyright','after:imageborder');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addFieldsToPalette('tt_content','header', '--linebreak--,tx_rkwbasics_header_link_caption', 'after:header_link');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes('tt_content','tx_rkwbasics_bodytext_mobile', '', 'after:bodytext');