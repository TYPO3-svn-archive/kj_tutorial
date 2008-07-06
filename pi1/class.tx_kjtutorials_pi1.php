<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2008 Julian Kleinhans <typo3@kj187.de>
*  All rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
*
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/

require_once(PATH_tslib.'class.tslib_pibase.php');


/**
 * Plugin 'Tutorial Extension' for the 'kj_tutorials' extension.
 *
 * @author	Julian Kleinhans <typo3@kj187.de>
 * @package	TYPO3
 * @subpackage	tx_kjtutorials
 */
class tx_kjtutorials_pi1 extends tslib_pibase {
	var $prefixId      = 'tx_kjtutorials_pi1';		// Same as class name
	var $scriptRelPath = 'pi1/class.tx_kjtutorials_pi1.php';	// Path to this script relative to the extension dir.
	var $extKey        = 'kj_tutorials';	// The extension key.
	var $pi_checkCHash = true;
	
	/**
	 * This var include the action number
	 *
	 * @var integer
	 */
	var $action;

	/**
	 * HTML Template Code
	 *
	 * @var html
	 */
	var $templateCode;
	
	/**
	 * Upload folder from extension
	 *
	 * @var string
	 */
	var $uploadFolderPath = 'uploads/tx_kjtutorials/';
	
	/**
	 * Upload folder from pages
	 *
	 * @var string
	 */
	var $uploadMediaPath = 'uploads/media/';
	
	/**
	 * GET POST var
	 *
	 * @var array
	 */
	var $GPvar;
	
	
	
	
	
	
	/**
	 * Enter description here...
	 *
	 * @param	string		$content: The PlugIn content
	 * @param	array		$conf: The PlugIn configuration
	 */
	function init($content,$conf){
	
		// Initialize some class variables
		$this->conf = $conf;
		
		// set get/post var array
		$this->GPvar = t3lib_div::_GP($this->extKey);
		
		// Initialize language and default plugin vars
		$this->pi_setPiVarDefaults();
		$this->pi_loadLL();		
			
		// Initialize flexforms
		if($this->cObj->data['pi_flexform']){
			$this->pi_initPIflexform();
			$element = 'tutorialShowWhat';
			$sheet = 'sDEF';
			$this->action = $this->pi_getFFvalue($this->cObj->data['pi_flexform'], $element, $sheet);
		}elseif($this->conf['action']){
			$this->action = $this->conf['action'];
		}else{			
			if( ($this->cObj->data['uid'] == $this->conf['category.']['startUid']) OR $this->cObj->data['doktype'] == 188 OR $this->cObj->data['doktype'] == 187){
				
				// set default action - category/list view
				$this->action = 1;
			}
		}
		// General Template Settings
		$this->templateCode = $this->cObj->fileResource($this->conf['templateFile']);				

	}
	
	/**
	 * The main method of the PlugIn
	 *
	 * @param	string		$content: The PlugIn content
	 * @param	array		$conf: The PlugIn configuration
	 * @return	The content that is displayed on the website
	 */
	public function main($content,$conf)	{
		
		// Initialize 
		$this->init($content,$conf);
		
		// Check templateCode
		if ($this->templateCode == '') return '<h3>'.$this->pi_getLL('error_templateNotFound').'</h3>'.$this->conf['templateFile']; 
		
		// Action
		switch($this->action){
			case 1: 				
				$content = $this->getCategories();
				$content .= $this->getListview();				
				break;
			case 2:
				$content = $this->getSingleview();
				break;	
			case 3:
				$content = $this->getTopXX();
				break;	
			case 4:
				$content = $this->getLastXX();
				break;	
			case 5:
				$content = $this->getSearch();
				break;	
			case 6:
				$content = $this->getRSSFeed();
				break;	
			case 7:
				$content = $this->getAddTutorial();
				break;	

			default:
				$content = '';
		}
	
		return $this->pi_wrapInBaseClass($content);
	}
	
	/**
	 * List categories
	 *
	 */
	public function getCategories(){
		$template = $this->cObj->getSubpart($this->templateCode,'###TEMPLATE_SHOWCATEGORIES###');	
		
		$res = $GLOBALS['TYPO3_DB']->exec_SELECTquery('*','pages','doktype = 187 AND pid = '.$GLOBALS['TSFE']->id.$this->cObj->enableFields('pages'));
		if($res AND $GLOBALS['TYPO3_DB']->sql_num_rows($res)>=1){
			// categories avaiable				
			$templateItem = $this->cObj->getSubpart($template,'###TEMPLATE_SHOWCATEGORIES_ITEM###');		
			
			$content = '';
			while($data = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res)){
				$pageInfo = $this->getPageInfo($data['uid']);
				$countTutorials = $pageInfo['count_tutorials'];
				$countSubCategories = $pageInfo['count_subcategories'];
				
				$markerArray['###IMAGE###'] = $this->pi_linkToPage($this->getImage($data['media'], $this->conf['category.'], $this->uploadMediaPath),$data['uid'],'_self');
				$markerArray['###TITLE###'] = $this->pi_linkToPage($data['title'],$data['uid'],'_self');	
				$markerArray['###SUBTITLE###'] = $data['subtitle'];					
				$markerArray['###COUNT_TUTORIAL###'] = $countTutorials;
				$markerArray['###COUNT_TUTORIAL_TEXT###'] = $countTutorials == 1 ? $this->pi_getLL('label_category_tutorialSingular') : $this->pi_getLL('label_category_tutorials');

				$markerArray['###COUNT_SUBCATEGORIES###'] = $countSubCategories;
				$markerArray['###COUNT_SUBCATEGORIES_TEXT###'] = $countSubCategories == 1 ? $this->pi_getLL('label_category_subcategoriesSingular') : $this->pi_getLL('label_category_subcategories');

				$content .= $this->cObj->substituteMarkerArrayCached($templateItem, $markerArray);     
			}		
			$template = $this->cObj->substituteSubpart($template,'###TEMPLATE_SHOWCATEGORIES_ITEM###',$content);
			
		}else{
			// clear item area
			$template = $this->cObj->substituteSubpart($template,'###TEMPLATE_SHOWCATEGORIES_ITEM###','');
			
			if($this->cObj->data['doktype'] == 188 AND $this->cObj->data['doktype'] != 187){
				// no categories avaiable
				$template = $this->cObj->getSubpart($this->templateCode,'###TEMPLATE_SHOWCATEGORIES_NOTAVAIABLE###');
				$markerArray['###MESSAGE###'] = $this->pi_getLL('error_category_notavaiable');
			}	 
		}
		
		// back link
		if($this->cObj->data['doktype'] == 187){
			$markerArray['###GOBACKLINK###'] = $this->pi_linkToPage('back', $this->cObj->data['pid'], '_self');			
		}else{
			$markerArray['###GOBACKLINK###'] = '';
		}
		
		$markerArray['###EXTKEY###'] = $this->extKey;
		$markerArray['###SITETITLE###'] = $this->cObj->data['title'];
		$markerArray['###SITE_SUBTITLE###'] = $this->cObj->data['subtitle'];
		return $this->cObj->substituteMarkerArrayCached($template, $markerArray);
	}	
	
	/**
	 * The listview action
	 *
	 */
	public function getListview(){
		$template = $this->cObj->getSubpart($this->templateCode,'###TEMPLATE_LISTVIEW###');	
		
		$res = $GLOBALS['TYPO3_DB']->exec_SELECTquery('uid, title','pages','doktype = 188 AND pid = '.$GLOBALS['TSFE']->id.$this->cObj->enableFields('pages'));
		if($res AND $GLOBALS['TYPO3_DB']->sql_num_rows($res)>=1){
			// tutorials avaiable				
			$templateItem = $this->cObj->getSubpart($template,'###TEMPLATE_LISTVIEW_ITEM###');		
			
			$content = '';
			while($data = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res)){
				
				// get tutorial record data
				$tutorialData = $this->getTutorialData($data['uid']);				

				$markerArray['###TITLE###'] = $this->pi_linkToPage($data['title'],$data['uid'],'_self');	
				$markerArray['###ABSTRACT###'] = $this->cObj->crop($tutorialData['abstract'],$this->conf['listview.']['abstractCropLen'].'|'.$this->conf['listview.']['abstractCropAppendText'].'|'.$this->conf['listview.']['abstractCropUseNextSpace']);						
				
				$content .= $this->cObj->substituteMarkerArrayCached($templateItem, $markerArray);     
			}		
			$template = $this->cObj->substituteSubpart($template,'###TEMPLATE_LISTVIEW_ITEM###',$content);
									
		}else{
			// clear item area
			$template = $this->cObj->substituteSubpart($template,'###TEMPLATE_LISTVIEW_ITEM###','');
			
			if($this->cObj->data['doktype'] == 187){
				// no tutorials avaiable
				$template = $this->cObj->getSubpart($this->templateCode,'###TEMPLATE_LISTVIEW_NOTAVAIABLE###');
				$markerArray['###MESSAGE###'] = $this->pi_getLL('error_tutorials_notavaiable');
			}			
		}
			
		$markerArray['###EXTKEY###'] = $this->extKey;
		return $this->cObj->substituteMarkerArrayCached($template, $markerArray);
	}	
	
	/**
	 * The singleview action
	 *
	 */
	public function getSingleview(){
		return 'SINGLEVIEW';
	}

	/**
	 * The top xx action
	 * Returns xx (you can set a number in typoscript) of the best tutorials
	 *
	 */
	public function getTopXX(){
		return 'TOP XX';
	}

	/**
	 * The last xx action
	 * Returns xx (you can set a number in typoscript) of the latest tutorials
	 *
	 */
	public function getLastXX(){
		return 'LAST XX';
	}

	/**
	 * The search action
	 *
	 */
	public function getSearch(){
		return 'SEARCH';
	}

	/**
	 * The rss feed action
	 *
	 */
	public function getRSSFeed(){
		return 'RSSFeed';
	}

	/**
	 * The rss feed action
	 *
	 */
	public function getAddTutorial(){
		$template = $this->cObj->getSubpart($this->templateCode,'###TEMPLATE_ADDTUTORIAL###');	
		$markerArray['###TEST###'] = 'TEST';
		$markerArray['###FORM_ACTION###'] = $this->pi_getPageLink($GLOBALS['TSFE']->id,'',array('cHash'=>$this->getCHash(time())));
		
		
		$GLOBALS['TSFE']->additionalHeaderData[$this->extKey.'_htmleditor'] = '
			<script type="text/javascript" src="'.t3lib_extMgm::siteRelPath($this->extKey).'res/js/ext-2.1/adapter/prototype/prototype.js"></script>
			<script type="text/javascript" src="'.t3lib_extMgm::siteRelPath($this->extKey).'res/js/ext-2.1/adapter/prototype/scriptaculous.js?load=effects"></script>
			<script type="text/javascript" src="'.t3lib_extMgm::siteRelPath($this->extKey).'res/js/ext-2.1/adapter/prototype/ext-prototype-adapter.js"></script>
			<script type="text/javascript" src="'.t3lib_extMgm::siteRelPath($this->extKey).'res/js/ext-2.1/ext-all.js"></script>

			<link rel="stylesheet" type="text/css" href="'.t3lib_extMgm::siteRelPath($this->extKey).'res/js/ext-2.1/resources/css/ext-all.css" />
			<link rel="stylesheet" type="text/css" href="'.t3lib_extMgm::siteRelPath($this->extKey).'res/js/ext-2.1/resources/css/xtheme-gray.css" />
								
			<script type="text/javascript" language="text/javascript">
				Ext.onReady(function(){
				
					Ext.QuickTips.init();  // enable tooltips
				
					new Ext.form.HtmlEditor({
					    renderTo: \'htmleditor_abstract\',
					    id: \''.$this->extKey.'[abstract]\',
					    width: 800,
					    height: 100,
					    enableColors: false,
					    enableFont: false,
					    enableFontSize: false,
					    enableFormat: false,
					    enableSourceEdit: false,
					    enableLinks: false,
					    enableLists: false,
					    enableAlignments: false,
					    value: \''.str_replace('\'','\\\'',$this->GPvar['abstract']).'\'
					});	
					
					new Ext.form.HtmlEditor({
					    renderTo: \'htmleditor_tutorials\',
					    id: \''.$this->extKey.'[tutorial]\',
					    width: 800,
					    height: 300,
					    enableColors: false,
					    enableFont: false,
					    enableFontSize: false,
					    enableFormat: false,
					    enableSourceEdit: false,
					    value: \''.str_replace('\'','\\\'',$this->GPvar['tutorial']).'\'
					});	

				})
			</script>
						
		';
		
		// set value
		$markerArray['###VALUE_TITLE###'] = $this->GPvar['title'];
		
		// set label
		$markerArray['###LABEL_TITLE###'] = $this->pi_getLL('label_tutorialadd_input_title');
		$markerArray['###LABEL_ABSTRACT###'] = $this->pi_getLL('label_tutorialadd_input_abstract');
		$markerArray['###LABEL_TUTORIAL###'] = $this->pi_getLL('label_tutorialadd_input_tutorial');
		
		
		
		
		
		
		
		$markerArray['###EXTKEY###'] = $this->extKey;
		return $this->cObj->substituteMarkerArrayCached($template, $markerArray);
	}


	
	
	
	
	
	
	
	
	
	/***************************************************************************************************************************
	 * HELPER FUNCTIONS
	 * 
	 * 
	 */
	
	/**
	 * Returns a image tag
	 *
	 * @param 	string	 $image: Image resource
	 * @param 	array 	 $conf: category configuration
	 * @return 	html	 IMG HTML Tag
	 */
	function getImage($image, $conf, $path=''){
		$path = $path ? $path : $this->uploadFolderPath;
		$conf['image.']['file'] = $image ?  $path.$image : $conf['defaultImage'];			
		return $this->cObj->cObjGetSingle($conf['image'],$conf['image.']);		
	}
	
	/**
	 * Returns count of avaiable tutorials
	 *
	 * @param 	int	 $page_uid: UID of the page
	 * @return 	int	 Count of avaiable tutorials
	 */
	function getPageInfo($page_uid){
		$res = $GLOBALS['TYPO3_DB']->exec_SELECTquery('uid, doktype','pages','(doktype = 187 OR doktype = 188)  AND pid = '.$page_uid.$this->cObj->enableFields('pages'));
		if($res AND $GLOBALS['TYPO3_DB']->sql_num_rows($res)>=1){			
			while($data = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res)){
				if($data['doktype'] == 188){
					$count_tutorials[] = $data['uid'];
				}else{
					$count_subcategories[] = $data['uid'];
				}			
			}
			
			return array('count_tutorials' => sizeof($count_tutorials), 'count_subcategories' => sizeof($count_subcategories));
		}else{
			return array('count_tutorials' => 0, 'count_subcategories' => 0);
		}
	}
	
	/**
	 * Return tutorial data
	 *
	 * @param 	integer 	$uid: UID from page
	 * @param 	string		$column: Return complete array or only one column
	 * @return  string/array
	 */
	function getTutorialData($uid, $column=''){
		$column = $column ? $column:'*';
		$res = $GLOBALS['TYPO3_DB']->exec_SELECTquery($column,'tx_kjtutorials_single','pid = '.$uid);		
		$data = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res);		
		return $column !='*' ? $data[$column]:$data;
	}
	
	/**
	 * Get cHash value
	 *
	 * @param 	string 	$params: URL parameter
	 * @return 	string	md5Hash
	 */
	function getCHash($params){
		$pA = t3lib_div::cHashParams($params);
		return t3lib_div::shortMD5(serialize($pA));
	}
	
}



if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/kj_tutorials/pi1/class.tx_kjtutorials_pi1.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/kj_tutorials/pi1/class.tx_kjtutorials_pi1.php']);
}

?>