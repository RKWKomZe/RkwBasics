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
// Add tables
//=================================================================
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_rkwbasics_domain_model_companytype', 'EXT:rkw_basics/Resources/Private/Language/locallang_csh_tx_rkwbasics_domain_model_companytype.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_rkwbasics_domain_model_companytype');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_rkwbasics_domain_model_department', 'EXT:rkw_basics/Resources/Private/Language/locallang_csh_tx_rkwbasics_domain_model_department.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_rkwbasics_domain_model_department');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_rkwbasics_domain_model_documenttype', 'EXT:rkw_basics/Resources/Private/Language/locallang_csh_tx_rkwbasics_domain_model_documenttype.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_rkwbasics_domain_model_documenttype');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_rkwbasics_domain_model_enterprisesize', 'EXT:rkw_basics/Resources/Private/Language/locallang_csh_tx_rkwbasics_domain_model_enterprisesize.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_rkwbasics_domain_model_enterprisesize');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_rkwbasics_domain_model_mediasources', 'EXT:rkw_basics/Resources/Private/Language/locallang_csh_tx_rkwbasics_domain_model_mediasources.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_rkwbasics_domain_model_mediasources');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_rkwbasics_domain_model_sector', 'EXT:rkw_basics/Resources/Private/Language/locallang_csh_tx_rkwbasics_domain_model_sector.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_rkwbasics_domain_model_sector');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_rkwbasics_domain_model_series', 'EXT:rkw_basics/Resources/Private/Language/locallang_csh_tx_rkwbasics_domain_model_series.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_rkwbasics_domain_model_series');
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

        if (\TYPO3\CMS\Core\Utility\GeneralUtility::getApplicationContext()->__toString() === 'Production/Staging') {
            $TBE_STYLES['inDocStyles_TBEstyle'] .= '@import "/typo3conf/ext/rkw_basics/Resources/Public/Css/BackendStaging.css";';
        } else {
            $TBE_STYLES['inDocStyles_TBEstyle'] .= '@import "/typo3conf/ext/rkw_basics/Resources/Public/Css/BackendProduction.css";';
        }

    } else {
        $TBE_STYLES['inDocStyles_TBEstyle'] .= '@import "/typo3conf/ext/rkw_basics/Resources/Public/Css/BackendDevelopment.css";';
    }
}
