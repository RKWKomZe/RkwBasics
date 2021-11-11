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

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'RKW.' . $extKey,
            'Rkwnotfound',
            array(
                'NotFound' => 'assets',
            ),
            // non-cacheable actions
            array(
                'NotFound' => 'assets',
            )
        );

        //=================================================================
        // Register Hooks
        //=================================================================
        if (TYPO3_MODE !== 'BE') {
            $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['tslib/class.tslib_fe.php']['contentPostProc-output'][] = 'RKW\\RkwBasics\\Hooks\\ReplaceExtensionPathsHook->hook_contentPostProc';
            $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['tslib/class.tslib_fe.php']['contentPostProc-output'][] = 'RKW\\RkwBasics\\Hooks\\PseudoCdnHook->hook_contentPostProc';
            $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['tslib/class.tslib_fe.php']['contentPostProc-output'][] = 'RKW\\RkwBasics\\Hooks\\HtmlMinifyHook->hook_contentPostProc';
            $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['tslib/class.tslib_fe.php']['contentPostProc-output'][] = 'RKW\\RkwBasics\\Hooks\\ProxyCachingHook->sendHeader';
            $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_pagerenderer.php']['render-preProcess'][] = 'RKW\\RkwBasics\\Hooks\\CriticalCssHook->render_preProcess';
            $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_pagerenderer.php']['render-postTransform'][] = 'RKW\\RkwBasics\\Hooks\\CriticalCssHook->render_postTransform';
            //$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_pagerenderer.php']['render-postTransform'][] = 'RKW\\RkwBasics\\Hooks\\InlineCssHook->render_postTransform';
        }

        //=================================================================
        // Register Caching
        //=================================================================

        if( !is_array($GLOBALS['TYPO3_CONF_VARS'] ['SYS']['caching']['cacheConfigurations'][$extKey] ) ) {
            $GLOBALS['TYPO3_CONF_VARS'] ['SYS']['caching']['cacheConfigurations'][$extKey] = array();
        }

        if( !isset($GLOBALS['TYPO3_CONF_VARS'] ['SYS']['caching']['cacheConfigurations'][$extKey]['frontend'])) {
            $GLOBALS['TYPO3_CONF_VARS'] ['SYS']['caching']['cacheConfigurations'][$extKey]['frontend'] = 'TYPO3\\CMS\\Core\\Cache\\Frontend\\VariableFrontend';
        }

        if( !isset($GLOBALS['TYPO3_CONF_VARS'] ['SYS']['caching']['cacheConfigurations'][$extKey]['backend'])) {
            $GLOBALS['TYPO3_CONF_VARS'] ['SYS']['caching']['cacheConfigurations'][$extKey]['backend'] = 'TYPO3\\CMS\\Core\\Cache\\Backend\\Typo3DatabaseBackend';
        }


        //=================================================================
        // register update wizard
        //=================================================================
        $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['ext/install']['update'][\RKW\RkwBasics\Updates\UpdateCore8Wizard::class] = \RKW\RkwBasics\Updates\UpdateCore8Wizard::class;

        //=================================================================
        // Add Rootline Fields
        //=================================================================
        $currentVersion = TYPO3\CMS\Core\Utility\VersionNumberUtility::convertVersionNumberToInteger(TYPO3_version);
        if ($currentVersion < 8000000) {
            $GLOBALS['TYPO3_CONF_VARS']['FE']['pageOverlayFields'] .= ',keywords,abstract,description,tx_rkwbasics_teaser_text,tx_rkwbasics_information';

            $rootlineFields = &$GLOBALS['TYPO3_CONF_VARS']['FE']['addRootLineFields'];
            $newRootlineFields = 'keywords,abstract,description,tx_rkwbasics_css_class,tx_rkwbasics_fe_layout_next_level,tx_rkwbasics_proxy_caching,tx_rkwbasics_cover,tx_rkwbasics_file,tx_rkwbasics_teaser_text,tx_rkwbasics_teaser_image,tx_rkwbasics_information,tx_rkwbasics_department,tx_rkwbasics_document_type';
            $rootlineFields .= (empty($rootlineFields))? $newRootlineFields : ',' . $newRootlineFields;

        } else {

            $GLOBALS['TYPO3_CONF_VARS']['FE']['pageOverlayFields'] .= ',keywords,abstract,description';

            $rootlineFields = &$GLOBALS['TYPO3_CONF_VARS']['FE']['addRootLineFields'];
            $newRootlineFields = 'keywords,abstract,description,tx_rkwbasics_css_class,tx_rkwbasics_fe_layout_next_level,tx_rkwbasics_proxy_caching,tx_rkwbasics_no_index,tx_rkwbasics_no_follow,tx_rkwbasics_cover,tx_rkwbasics_file,tx_rkwbasics_teaser_image,tx_rkwbasics_department,tx_rkwbasics_document_type';
            $rootlineFields .= (empty($rootlineFields))? $newRootlineFields : ',' . $newRootlineFields;
        }

        //=================================================================
        // XClasses
        //=================================================================
        $GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects'][TYPO3\CMS\Extbase\Mvc\Web\Request::class] = [
            'className' => RKW\RkwBasics\XClasses\Extbase\Mvc\Web\Request::class
        ];
        $GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects'][TYPO3\CMS\Extbase\Service\ImageService::class] = [
            'className' => RKW\RkwBasics\XClasses\Extbase\Service\ImageService::class
        ];
        $GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects'][TYPO3\CMS\Core\Resource\ResourceCompressor::class] = [
            'className' => RKW\RkwBasics\XClasses\Core\Resource\ResourceCompressor::class
        ];
        $GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects'][TYPO3\CMS\Extbase\Service\EnvironmentService::class] = [
            'className' => RKW\RkwBasics\XClasses\Extbase\Service\EnvironmentService::class
        ];
        /*if (\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::isLoaded('varnish')) {
            $GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects'][\Snowflake\Varnish\Utility\VarnishHttpUtility::class] = [
                'className' => RKW\RkwBasics\XClasses\Varnish\Utility\VarnishHttpUtility::class
            ];
        }*/

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
                    'logFile' => 'typo3temp/var/logs/tx_rkwbasics.log'
                )
            ),
        );
    },
    'rkw_basics'
);


