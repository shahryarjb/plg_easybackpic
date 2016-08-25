<?php
/**
 * @version		0.1
 * @package		backpic Easyblog Plugin (Easyblog plugin)
 * @author		Trangell - https://trangell.com
 * @copyright	Copyright (c) 2016 - 2016 JoomlaWorks Ltd. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 * &@license    https://trangell.com
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

require_once(JPATH_ADMINISTRATOR . '/components/com_easyblog/includes/easyblog.php');

class plgEasyBlogPlg_EasyBackPic extends JPlugin {

    public function onEasyBlogPrepareContent() {
	
	    if (JRequest::getVar('option')==='com_easyblog' && JRequest::getVar('view')==='entry') {
			$articleId = JRequest::getInt('id');
			//$db =& JFactory::getDBO();
		}else {
			return false;
		}
			
			$db    = JFactory::getDbo();
			$query = $db->getQuery(true);
			
		
			$query->select('*');
			$query->from('#__backpic');
			$query->where('article_id = ' . $articleId);
			$query->where('published = 1');
			$query->where('type = 3');
				 
			$db->setQuery($query);
			$row = $db->loadAssoc();

			if ($row['published'] == 1 AND $row['type'] == 3) {
				
				$row['pic'] 			= htmlspecialchars($row['pic'], ENT_QUOTES, 'UTF-8');
				$row['width'] 			= htmlspecialchars($row['width'], ENT_QUOTES, 'UTF-8');
				$row['height'] 			= htmlspecialchars($row['height'], ENT_QUOTES, 'UTF-8');
				$row['custom'] 			= htmlspecialchars($row['custom'], ENT_QUOTES, 'UTF-8');
				$row['menudbid']		= htmlspecialchars($row['menudbid'], ENT_QUOTES, 'UTF-8');
				$row['template_name']	= htmlspecialchars($row['template_name'], ENT_QUOTES, 'UTF-8');
			
				
			if (!empty($row['template_name']) AND !empty($row['template_name'] == 0)) {

					$selectsetTemplate = JFactory::getApplication();
			 		$selectsetTemplate->setTemplate("{$row['template_name']}", null);
				}
				
			$doc = JFactory::getDocument();
			$UrlSite = JURI::root();
				if (!empty($row['pic'])) {
					$doc->addStyleDeclaration("
						body {background: url('{$UrlSite}{$row['pic']}') no-repeat;background-size: {$row['width']} {$row['height']};}
				");
				}
				
				if (!empty($row['custom'])) {
					$doc->addStyleDeclaration("
						{$row['custom']}
				");
				}
			}
	}

}
