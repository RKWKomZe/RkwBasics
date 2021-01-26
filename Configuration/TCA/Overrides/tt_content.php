<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

//=================================================================
// Register Plugin
//=================================================================

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'RKW.RkwBasics',
    'Rkwmediasources',
    'RKW MediaSources'
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'RKW.RkwBasics',
    'Rkwdepartments',
    'RKW Departments'
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'RKW.RkwBasics',
    'Rkwgoogle',
    'RKW Google Sitemap'
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'RKW.RkwBasics',
    'Rkwnotfound',
    'RKW AssetNotFound'
);

//=================================================================
// Add Flexforms
//=================================================================
$extKey = 'rkw_basics';

$extensionName = strtolower(\TYPO3\CMS\Core\Utility\GeneralUtility::underscoredToUpperCamelCase($extKey));
$pluginName = strtolower('Rkwmediasources');
$pluginSignature = $extensionName.'_'.$pluginName;

$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
    $pluginSignature,
    'FILE:EXT:' . $extKey . '/Configuration/FlexForms/MediaSources.xml'
);

//$pluginName = strtolower('Rkwdepartments');
//$pluginSignature = $extensionName.'_'.$pluginName;
//$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
//\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($pluginSignature, 'FILE:EXT:' . $extKey . '/Configuration/FlexForms/Departments.xml');


//=================================================================
// OTHER STUFF
//=================================================================

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

];

/** @deprecated */
$currentVersion = TYPO3\CMS\Core\Utility\VersionNumberUtility::convertVersionNumberToInteger(TYPO3_version);
if ($currentVersion < 8000000) {

    $tempColumnsContent = array_merge(
        $tempColumnsContent,
        [
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
        ]
    );
}

// Add TCA
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('tt_content',$tempColumnsContent);

// Add fields
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addFieldsToPalette('tt_content', 'image_settings','tx_rkwbasics_images_no_copyright','after:imageborder');

/** @deprecated */
$currentVersion = TYPO3\CMS\Core\Utility\VersionNumberUtility::convertVersionNumberToInteger(TYPO3_version);
if ($currentVersion < 8000000) {
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addFieldsToPalette('tt_content','header', '--linebreak--,tx_rkwbasics_header_link_caption', 'after:header_link');
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes('tt_content', 'tx_rkwbasics_bodytext_mobile', '', 'after:bodytext');
}