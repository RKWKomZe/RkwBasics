<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	'RKW.' . $_EXTKEY,
    'Rkwmediasources',
    'RKW MediaSources'
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	'RKW.' . $_EXTKEY,
	'Rkwdepartments',
	'RKW Departments'
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	'RKW.' . $_EXTKEY,
	'Rkwgoogle',
	'RKW Google Sitemap'
);

//=================================================================
// Add Flexforms
//=================================================================
$extensionName = strtolower(\TYPO3\CMS\Core\Utility\GeneralUtility::underscoredToUpperCamelCase($_EXTKEY));
$pluginName = strtolower('Rkwmediasources');
$pluginSignature = $extensionName.'_'.$pluginName;

$TCA['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($pluginSignature, 'FILE:EXT:' . $_EXTKEY . '/Configuration/FlexForms/MediaSources.xml');

//$pluginName = strtolower('Rkwdepartments');
//$pluginSignature = $extensionName.'_'.$pluginName;
//$TCA['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
//\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($pluginSignature, 'FILE:EXT:' . $_EXTKEY . '/Configuration/FlexForms/Departments.xml');

//=================================================================
// Add TypoScript
//=================================================================
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'RKW Basics');


//=================================================================
// Add CSS style to cache-delete menu according to application context
//=================================================================
if (TYPO3_MODE == "BE") {
    if (\TYPO3\CMS\Core\Utility\GeneralUtility::getApplicationContext()->isProduction()) {
        $TBE_STYLES['inDocStyles_TBEstyle'] .= '@import "/typo3conf/ext/rkw_basics/Resources/Public/Css/BackendProduction.css";';

    } else {
        $TBE_STYLES['inDocStyles_TBEstyle'] .= '@import "/typo3conf/ext/rkw_basics/Resources/Public/Css/BackendDevelopment.css";';
    }
}

?>