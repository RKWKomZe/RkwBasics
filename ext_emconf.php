<?php

/***************************************************************
 * Extension Manager/Repository config file for ext: "rkw_basics"
 *
 * Auto generated by Extension Builder 2014-02-19
 *
 * Manual updates:
 * Only the data in the array - anything else is removed by next write.
 * "version" and "dependencies" must not be touched!
 ***************************************************************/

$EM_CONF[$_EXTKEY] = [
	'title' => 'RKW Basics',
	'description' => 'Extension with some basic extensions for BE and FE',
	'category' => 'be',
	'author' => 'Steffen Kroggel',
	'author_email' => 'developer@steffenkroggel.de',
	'author_company' => 'RKW Kompetenzzentrum',
	'shy' => '',
	'priority' => '',
	'module' => '',
	'state' => 'stable',
	'internal' => '',
	'uploadfolder' => '0',
	'createDirs' => '',
	'modify_tables' => '',
	'clearCacheOnLoad' => 0,
	'lockType' => '',
	'version' => '9.5.0',
    'constraints' => [
		'depends' => [
			'typo3' => '9.5.0-9.5.99',
            'filemetadata' => '9.5.0-9.5.99',
            'core_extended' => '9.5.4-9.5.99',
            'ajax_api' => '9.5.0-9.5.99'
        ],
		'conflicts' => [
		],
		'suggests' => [
		],
	],
];
