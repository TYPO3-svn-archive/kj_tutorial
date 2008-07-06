<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

t3lib_extMgm::allowTableOnStandardPages('tx_kjtutorials_single');

// Build own pagetype - categorie 
$TCA['pages']['columns']['doktype']['config']['items'][187]=array('LLL:EXT:kj_tutorials/locallang_tca.xml:doktype.I.187',187,t3lib_extMgm::extRelPath('kj_tutorials').'res/icons/page_category_icon.gif');
$PAGES_TYPES['187']=array('type'=>'web','icon'=>t3lib_extMgm::extRelPath('kj_tutorials').'res/icons/page_category_icon.gif');

// Build own pagetype - tutorial
$TCA['pages']['columns']['doktype']['config']['items'][188]=array('LLL:EXT:kj_tutorials/locallang_tca.xml:doktype.I.188',188,t3lib_extMgm::extRelPath('kj_tutorials').'res/icons/page_tutorial_icon.gif');
$PAGES_TYPES['188']=array('type'=>'web','icon'=>t3lib_extMgm::extRelPath('kj_tutorials').'res/icons/page_tutorial_icon.gif');


// Define TCA
$TCA["tx_kjtutorials_single"] = array (
	"ctrl" => array (
		'title'     => 'LLL:EXT:kj_tutorials/locallang_db.xml:tx_kjtutorials_single',		
		'label'     => 'abstract',	
		'tstamp'    => 'tstamp',
		'crdate'    => 'crdate',
		'cruser_id' => 'cruser_id',
		'default_sortby' => "ORDER BY crdate",	
		'delete' => 'deleted',	
		'enablecolumns' => array (		
			'disabled' => 'hidden',	
			'fe_group' => 'fe_group',
		),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY).'tca.php',
		'iconfile'          => t3lib_extMgm::extRelPath($_EXTKEY).'icon_tx_kjtutorials_single.gif',
	),
	"feInterface" => array (
		"fe_admin_fieldList" => "hidden, fe_group, title, abstract, tutorial, tags, source, result_link, result_image, nofeuser_name, nofeuser_email, nofeuser_website, feuser_uid, allow_comments",
	)
);

$TCA["tx_kjtutorials_comment"] = array (
	"ctrl" => array (
		'title'     => 'LLL:EXT:kj_tutorials/locallang_db.xml:tx_kjtutorials_comment',		
		'label'     => 'uid',	
		'tstamp'    => 'tstamp',
		'crdate'    => 'crdate',
		'cruser_id' => 'cruser_id',
		'default_sortby' => "ORDER BY crdate",	
		'delete' => 'deleted',	
		'enablecolumns' => array (		
			'disabled' => 'hidden',	
			'fe_group' => 'fe_group',
		),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY).'tca.php',
		'iconfile'          => t3lib_extMgm::extRelPath($_EXTKEY).'icon_tx_kjtutorials_comment.gif',
	),
	"feInterface" => array (
		"fe_admin_fieldList" => "hidden, fe_group, comment, tutorial_uid, nofeuser_name, nofeuser_email, nofeuser_website, feuser_uid",
	)
);

$tempColumns = Array (
	"tx_kjtutorials_subscription" => Array (		
		"exclude" => 1,		
		"label" => "LLL:EXT:kj_tutorials/locallang_db.xml:be_users.tx_kjtutorials_subscription",		
		"config" => Array (
			"type" => "select",	
			"foreign_table" => "tx_kjtutorials_single",	
			"foreign_table_where" => "ORDER BY tx_kjtutorials_single.uid",	
			"size" => 10,	
			"minitems" => 0,
			"maxitems" => 100,
		)
	),
);


t3lib_div::loadTCA("be_users");
t3lib_extMgm::addTCAcolumns("be_users",$tempColumns,1);
t3lib_extMgm::addToAllTCAtypes("be_users","tx_kjtutorials_subscription;;;;1-1-1");


t3lib_div::loadTCA('tt_content');
$TCA['tt_content']['types']['list']['subtypes_excludelist'][$_EXTKEY.'_pi1']='layout,select_key,pages';


t3lib_extMgm::addPlugin(array('LLL:EXT:kj_tutorials/locallang_db.xml:tt_content.list_type_pi1', $_EXTKEY.'_pi1'),'list_type');


t3lib_extMgm::addStaticFile($_EXTKEY,'static/Tutorials/', 'Tutorials');


// Activate Flexforms
$TCA['tt_content']['types']['list']['subtypes_addlist'][$_EXTKEY.'_pi1'] = 'pi_flexform';
t3lib_extMgm::addPiFlexFormValue($_EXTKEY.'_pi1', 'FILE:EXT:'.$_EXTKEY.'/flexform_ds_pi1.xml');

// Define TCA for categories
$TCA['pages']['types']['187']['showitem'] = '
	--div--;LLL:EXT:'.$_EXTKEY.'/locallang_tca.xml:pages.tabs.category,doktype;;2;button;1-1-1, hidden, title, subtitle, media,
	--div--;LLL:EXT:cms/locallang_tca.xml:pages.tabs.options,TSconfig;;6;nowrap;5-5-5
';

// Define TCA for tutorial pages
$TCA['pages']['types']['188']['showitem'] = '
	--div--;LLL:EXT:'.$_EXTKEY.'/locallang_tca.xml:pages.tabs.tutorial,doktype;;2;button;1-1-1, hidden, title,
	--div--;LLL:EXT:cms/locallang_tca.xml:pages.tabs.options,TSconfig;;6;nowrap;5-5-5
';

?>