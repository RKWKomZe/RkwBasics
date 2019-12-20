<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function($extKey)
    {

        //=================================================================
        // Configure Plugins
        //=================================================================
        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'RKW.' . $extKey,
            'Rkwmediasources',
            array(
                'MediaSources' => 'list, listPage',
            ),
            // non-cacheable actions
            array(

            )
        );

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'RKW.' . $extKey,
            'Rkwgoogle',
            array(
                'Google' => 'sitemap',
            ),
            // non-cacheable actions
            array(

            )
        );

        //=================================================================
        // Register Hooks for CDN
        //=================================================================
        $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['tslib/class.tslib_fe.php']['contentPostProc-output'][] = 'RKW\\RkwBasics\\Hooks\\CdnSearchReplaceHook->hook_contentPostProc';

        //=================================================================
        // Register Hook for Varnish
        //=================================================================
        $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['tslib/class.tslib_fe.php']['contentPostProc-output'][] = 'RKW\\RkwBasics\\Hooks\\ProxyCachingHook->sendHeader';

        //=================================================================
        // Add Rootline Fields
        //=================================================================
        $GLOBALS['TYPO3_CONF_VARS']['FE']['pageOverlayFields'] .= ',keywords,abstract,description,tx_rkwbasics_teaser_text,tx_rkwbasics_information';

        $rootlineFields = &$GLOBALS['TYPO3_CONF_VARS']['FE']['addRootLineFields'];
        $newRootlineFields = 'keywords,abstract,description,tx_rkwbasics_css_class,tx_rkwbasics_fe_layout_next_level,tx_rkwbasics_proxy_caching,tx_rkwbasics_cover,tx_rkwbasics_file,tx_rkwbasics_teaser_text,tx_rkwbasics_teaser_image,tx_rkwbasics_article_image,tx_rkwbasics_information,tx_rkwbasics_department,tx_rkwbasics_document_type';
        $rootlineFields .= (empty($rootlineFields))? $newRootlineFields : ',' . $newRootlineFields;

        //=================================================================
        // Configure Logger
        //=================================================================
        $GLOBALS['TYPO3_CONF_VARS']['LOG']['RKW']['RkwBasics']['writerConfiguration'] = array(

            // configuration for WARNING severity, including all
            // levels with higher severity (ERROR, CRITICAL, EMERGENCY)
            \TYPO3\CMS\Core\Log\LogLevel::WARNING => array(
                // add a FileWriter
                'TYPO3\\CMS\\Core\\Log\\Writer\\FileWriter' => array(
                    // configuration for the writer
                    'logFile' => 'typo3temp/logs/tx_rkwbasics.log'
                )
            ),
        );

    },
    $_EXTKEY
);


