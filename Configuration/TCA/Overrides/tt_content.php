<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

//=================================================================
// Register Plugin
//=================================================================

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'RKW.RkwBasics',
    'Rkwdepartments',
    'RKW Departments'
);

