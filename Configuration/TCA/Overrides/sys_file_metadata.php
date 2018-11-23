<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

$tempColumnsMedia = array(

    'columns' => array(
        'tx_rkwbasics_publisher' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:rkw_basics/Resources/Private/Language/locallang_db.xlf:tx_rkwbasics_domain_model_mediafilemeta.tx_rkwbasics_publisher',
            'config' => array(
                'type' => 'input',
                'size' => 20,
                'eval' => 'trim'
            ),
        ),
        'tx_rkwbasics_source' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:rkw_basics/Resources/Private/Language/locallang_db.xlf:tx_rkwbasics_domain_model_mediafilemeta.tx_rkwbasics_source',
            'config' => array(
                'type' => 'select',
                'renderType' => 'selectSingle',
                'size' => 5,
                'foreign_table' => 'tx_rkwbasics_domain_model_mediasources',
                'foreign_table_where' => 'ORDER BY name ASC',
                'minitems' => 0,
                'maxitems' => 1,
                'default' => 0,
                'items' => array(
                    array('---', '0'),
                ),
            ),
        ),
    ),
);

// insert columns
$GLOBALS['TCA']['sys_file_metadata'] = array_replace_recursive($GLOBALS['TCA']['sys_file_metadata'], $tempColumnsMedia);

// replace default fields with ours
foreach ($GLOBALS['TCA']['sys_file_metadata']['types'] as $type => &$config) {

    // remove spaces
    $config = str_replace(' ', '', $config);

    // replace old ones
    foreach (array ('creator', 'creator_tool', 'publisher', 'source', 'copyright') as $field)
        $config = str_replace($field . ',', '', $config);

    // insert new ones
    $config = str_replace('LLL:EXT:filemetadata/Resources/Private/Language/locallang_tca.xlf:tabs.metadata,', 'LLL:EXT:filemetadata/Resources/Private/Language/locallang_tca.xlf:tabs.metadata,' . implode(',', array_keys($tempColumnsMedia['columns'])) . ',', $config);

}


