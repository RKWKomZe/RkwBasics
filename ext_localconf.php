<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'RKW.' . $_EXTKEY,
    'Rkwmediasources',
    array(
        'MediaSources' => 'list, listPage',

    ),
    // non-cacheable actions
    array(

    )
);


\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'RKW.' . $_EXTKEY,
    'Rkwgoogle',
    array(
        'Google' => 'sitemap',

    ),
    // non-cacheable actions
    array(

    )
);

// set logger
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

// register hooks for CDN!
$TYPO3_CONF_VARS['SC_OPTIONS']['tslib/class.tslib_fe.php']['pageIndexing'][] = 'RKW\\RkwBasics\\Hooks\\CdnSearchReplaceHook';
$TYPO3_CONF_VARS['SC_OPTIONS']['tslib/class.tslib_fe.php']['contentPostProc-output'][] = 'RKW\\RkwBasics\\Hooks\\CdnSearchReplaceHook->hook_contentPostProc';

// register hook for varnish
$TYPO3_CONF_VARS['SC_OPTIONS']['tslib/class.tslib_fe.php']['contentPostProc-output'][] = 'RKW\\RkwBasics\\Hooks\\ProxyCachingHook->sendHeader';

// Add rootline fields
$TYPO3_CONF_VARS['FE']['addRootLineFields'] .= ',keywords,abstract,description,tx_rkwbasics_css_class,tx_rkwbasics_fe_layout_next_level,tx_rkwbasics_proxy_caching,tx_rkwbasics_cover,tx_rkwbasics_file,tx_rkwbasics_teaser_text,tx_rkwbasics_teaser_image,tx_rkwbasics_article_image,tx_rkwbasics_information,tx_rkwbasics_department,tx_rkwbasics_document_type';
$TYPO3_CONF_VARS['FE']['pageOverlayFields'] .= ',keywords,abstract,description,tx_rkwbasics_teaser_text,tx_rkwbasics_information';




?>