<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function($extKey)
    {

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            'RKW.' . $extKey,
            'Rkwmediasources',
            'RKW MediaSources'
        );

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            'RKW.' . $extKey,
            'Rkwdepartments',
            'RKW Departments'
        );

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            'RKW.' . $extKey,
            'Rkwgoogle',
            'RKW Google Sitemap'
        );

        //=================================================================
        // Add tables
        //=================================================================
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages(
            'tx_rkwbasics_domain_model_companytype'
        );

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('
            tx_rkwbasics_domain_model_department'
        );

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages(
            'tx_rkwbasics_domain_model_documenttype'
        );

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages(
            'tx_rkwbasics_domain_model_enterprisesize'
        );

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages(
            'tx_rkwbasics_domain_model_mediasources'
        );

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages(
            'tx_rkwbasics_domain_model_sector'
        );

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages(
            'tx_rkwbasics_domain_model_series'
        );


        //=================================================================
        // Add Flexforms
        //=================================================================
        $extensionName = strtolower(\TYPO3\CMS\Core\Utility\GeneralUtility::underscoredToUpperCamelCase($extKey));
        $pluginName = strtolower('Rkwmediasources');
        $pluginSignature = $extensionName.'_'.$pluginName;

        $TCA['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
            $pluginSignature,
            'FILE:EXT:' . $extKey . '/Configuration/FlexForms/MediaSources.xml'
        );

        //$pluginName = strtolower('Rkwdepartments');
        //$pluginSignature = $extensionName.'_'.$pluginName;
        //$TCA['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
        //\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($pluginSignature, 'FILE:EXT:' . $extKey . '/Configuration/FlexForms/Departments.xml');


        //=================================================================
        // Add TypoScript
        //=================================================================
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
            $extKey,
            'Configuration/TypoScript',
            'RKW Basics'
        );

    },
    $_EXTKEY
);



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