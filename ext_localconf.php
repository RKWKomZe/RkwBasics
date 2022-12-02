<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function($extKey)
    {

        //=================================================================
        // Add Rootline Fields
        //=================================================================
        $GLOBALS['TYPO3_CONF_VARS']['FE']['pageOverlayFields'] .= ',keywords,abstract,description';

        $rootlineFields = &$GLOBALS['TYPO3_CONF_VARS']['FE']['addRootLineFields'];
        $newRootlineFields = 'keywords,abstract,description,tx_rkwbasics_cover,tx_rkwbasics_file,tx_rkwbasics_teaser_image,tx_rkwbasics_department,tx_rkwbasics_document_type';
        $rootlineFields .= (empty($rootlineFields))? $newRootlineFields : ',' . $newRootlineFields;


        //=================================================================
        // XClasses
        //=================================================================
        if (\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::isLoaded('sr_freecap')) {
            $GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects'][SJBR\SrFreecap\Validation\Validator\CaptchaValidator::class] = [
                'className' => RKW\RkwBasics\XClasses\Validation\Validator\CaptchaValidator::class
            ];
        }

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


