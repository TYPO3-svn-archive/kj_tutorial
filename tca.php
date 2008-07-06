<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

$TCA["tx_kjtutorials_single"] = array (
	"ctrl" => $TCA["tx_kjtutorials_single"]["ctrl"],
	"interface" => array (
		"showRecordFieldList" => "hidden,fe_group,title,abstract,tutorial,tags,source,result_link,result_image,nofeuser_name,nofeuser_email,nofeuser_website,feuser_uid,allow_comments"
	),
	"feInterface" => $TCA["tx_kjtutorials_single"]["feInterface"],
	"columns" => array (
		'hidden' => array (		
			'exclude' => 1,
			'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
			'config'  => array (
				'type'    => 'check',
				'default' => '0'
			)
		),
		'fe_group' => array (		
			'exclude' => 1,
			'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.fe_group',
			'config'  => array (
				'type'  => 'select',
				'items' => array (
					array('', 0),
					array('LLL:EXT:lang/locallang_general.xml:LGL.hide_at_login', -1),
					array('LLL:EXT:lang/locallang_general.xml:LGL.any_login', -2),
					array('LLL:EXT:lang/locallang_general.xml:LGL.usergroups', '--div--')
				),
				'foreign_table' => 'fe_groups'
			)
		),
		/*"title" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:kj_tutorials/locallang_db.xml:tx_kjtutorials_single.title",		
			"config" => Array (
				"type" => "input",	
				"size" => "30",	
				"eval" => "required",
			)
		),*/
		"abstract" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:kj_tutorials/locallang_db.xml:tx_kjtutorials_single.abstract",		
			"config" => Array (
				"type" => "text",
				"cols" => "40",	
				"rows" => "15",
			)
		),
		"tutorial" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:kj_tutorials/locallang_db.xml:tx_kjtutorials_single.tutorial",		
			"config" => Array (
				"type" => "text",
				"cols" => "40",	
				"rows" => "20",
			)
		),
		"tags" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:kj_tutorials/locallang_db.xml:tx_kjtutorials_single.tags",		
			"config" => Array (
				"type" => "input",	
				"size" => "30",
			)
		),
		"source" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:kj_tutorials/locallang_db.xml:tx_kjtutorials_single.source",		
			"config" => Array (
				"type"     => "input",
				"size"     => "15",
				"max"      => "255",
				"checkbox" => "",
				"eval"     => "trim",
				"wizards"  => array(
					"_PADDING" => 2,
					"link"     => array(
						"type"         => "popup",
						"title"        => "Link",
						"icon"         => "link_popup.gif",
						"script"       => "browse_links.php?mode=wizard",
						"JSopenParams" => "height=300,width=500,status=0,menubar=0,scrollbars=1"
					)
				)
			)
		),
		"result_link" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:kj_tutorials/locallang_db.xml:tx_kjtutorials_single.result_link",		
			"config" => Array (
				"type"     => "input",
				"size"     => "15",
				"max"      => "255",
				"checkbox" => "",
				"eval"     => "trim",
				"wizards"  => array(
					"_PADDING" => 2,
					"link"     => array(
						"type"         => "popup",
						"title"        => "Link",
						"icon"         => "link_popup.gif",
						"script"       => "browse_links.php?mode=wizard",
						"JSopenParams" => "height=300,width=500,status=0,menubar=0,scrollbars=1"
					)
				)
			)
		),
		"result_image" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:kj_tutorials/locallang_db.xml:tx_kjtutorials_single.result_image",		
			"config" => Array (
				"type" => "group",
				"internal_type" => "file",
				"allowed" => $GLOBALS["TYPO3_CONF_VARS"]["GFX"]["imagefile_ext"],	
				"max_size" => 800,	
				"uploadfolder" => "uploads/tx_kjtutorials",
				"show_thumbs" => 1,	
				"size" => 1,	
				"minitems" => 0,
				"maxitems" => 1,
			)
		),
		"nofeuser_name" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:kj_tutorials/locallang_db.xml:tx_kjtutorials_single.nofeuser_name",		
			"config" => Array (
				"type" => "input",	
				"size" => "30",
			)
		),
		"nofeuser_email" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:kj_tutorials/locallang_db.xml:tx_kjtutorials_single.nofeuser_email",		
			"config" => Array (
				"type" => "input",	
				"size" => "30",
			)
		),
		"nofeuser_website" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:kj_tutorials/locallang_db.xml:tx_kjtutorials_single.nofeuser_website",		
			"config" => Array (
				"type"     => "input",
				"size"     => "15",
				"max"      => "255",
				"checkbox" => "",
				"eval"     => "trim",
				"wizards"  => array(
					"_PADDING" => 2,
					"link"     => array(
						"type"         => "popup",
						"title"        => "Link",
						"icon"         => "link_popup.gif",
						"script"       => "browse_links.php?mode=wizard",
						"JSopenParams" => "height=300,width=500,status=0,menubar=0,scrollbars=1"
					)
				)
			)
		),
		"feuser_uid" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:kj_tutorials/locallang_db.xml:tx_kjtutorials_single.feuser_uid",		
			"config" => Array (
				"type" => "group",	
				"internal_type" => "db",	
				"allowed" => "fe_users",	
				"size" => 1,	
				"minitems" => 0,
				"maxitems" => 1,
			)
		),
		"allow_comments" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:kj_tutorials/locallang_db.xml:tx_kjtutorials_single.allow_comments",		
			"config" => Array (
				"type" => "check",
				"default" => 1,
			)
		),
	),
	"types" => array (
		//"0" => array("showitem" => "hidden;;1;;1-1-1, title;;;;2-2-2, abstract;;;;3-3-3, tutorial, tags, source, result_link, result_image, nofeuser_name, nofeuser_email, nofeuser_website, feuser_uid, allow_comments")
		"0" => array("showitem" => "hidden;;1;;1-1-1, abstract;;;;3-3-3, tutorial, tags, source, result_link, result_image, nofeuser_name, nofeuser_email, nofeuser_website, feuser_uid, allow_comments")
	),
	"palettes" => array (
		"1" => array("showitem" => "fe_group")
	)
);



$TCA["tx_kjtutorials_comment"] = array (
	"ctrl" => $TCA["tx_kjtutorials_comment"]["ctrl"],
	"interface" => array (
		"showRecordFieldList" => "hidden,fe_group,comment,tutorial_uid,nofeuser_name,nofeuser_email,nofeuser_website,feuser_uid"
	),
	"feInterface" => $TCA["tx_kjtutorials_comment"]["feInterface"],
	"columns" => array (
		'hidden' => array (		
			'exclude' => 1,
			'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
			'config'  => array (
				'type'    => 'check',
				'default' => '0'
			)
		),
		'fe_group' => array (		
			'exclude' => 1,
			'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.fe_group',
			'config'  => array (
				'type'  => 'select',
				'items' => array (
					array('', 0),
					array('LLL:EXT:lang/locallang_general.xml:LGL.hide_at_login', -1),
					array('LLL:EXT:lang/locallang_general.xml:LGL.any_login', -2),
					array('LLL:EXT:lang/locallang_general.xml:LGL.usergroups', '--div--')
				),
				'foreign_table' => 'fe_groups'
			)
		),
		"comment" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:kj_tutorials/locallang_db.xml:tx_kjtutorials_comment.comment",		
			"config" => Array (
				"type" => "text",
				"cols" => "40",	
				"rows" => "15",
			)
		),
		"tutorial_uid" => Array (		
			"config" => Array (
				"type" => "passthrough",
			)
		),
		"nofeuser_name" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:kj_tutorials/locallang_db.xml:tx_kjtutorials_comment.nofeuser_name",		
			"config" => Array (
				"type" => "input",	
				"size" => "30",
			)
		),
		"nofeuser_email" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:kj_tutorials/locallang_db.xml:tx_kjtutorials_comment.nofeuser_email",		
			"config" => Array (
				"type" => "input",	
				"size" => "30",
			)
		),
		"nofeuser_website" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:kj_tutorials/locallang_db.xml:tx_kjtutorials_comment.nofeuser_website",		
			"config" => Array (
				"type"     => "input",
				"size"     => "15",
				"max"      => "255",
				"checkbox" => "",
				"eval"     => "trim",
				"wizards"  => array(
					"_PADDING" => 2,
					"link"     => array(
						"type"         => "popup",
						"title"        => "Link",
						"icon"         => "link_popup.gif",
						"script"       => "browse_links.php?mode=wizard",
						"JSopenParams" => "height=300,width=500,status=0,menubar=0,scrollbars=1"
					)
				)
			)
		),
		"feuser_uid" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:kj_tutorials/locallang_db.xml:tx_kjtutorials_comment.feuser_uid",		
			"config" => Array (
				"type" => "group",	
				"internal_type" => "db",	
				"allowed" => "fe_users",	
				"size" => 1,	
				"minitems" => 0,
				"maxitems" => 1,
			)
		),
	),
	"types" => array (
		"0" => array("showitem" => "hidden;;1;;1-1-1, comment, tutorial_uid, nofeuser_name, nofeuser_email, nofeuser_website, feuser_uid")
	),
	"palettes" => array (
		"1" => array("showitem" => "fe_group")
	)
);
?>