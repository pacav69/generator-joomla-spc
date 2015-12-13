<?php
/**
 * com_<%= _.slugify(componentName) %>	component for Joomla
 * 
 * @version		1.0.0 
 * @package		
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL v2 or later
 * 
 * author		
 * website		
 */

// No direct access
defined('_JEXEC') or die('Restricted access');

abstract class <%= _.str.capitalize(_.slugify(componentName)) %>HelperRoute
{
	public static function getGalleryRoute($task, $target, $item = '')
	{
		$link = 'index.php?option=com_<%= _.slugify(componentName) %>&view=gallery';
		
		if (!empty($task)) {
			$link .= '&task='.$task;
		} else {
			$link .= '&task=show';
		}
		
		if (!empty($target)) {
			$link .= '&target='.$target; 
		}
		
		if (!empty($item)) {
			$link .= '&item='.$item;
		}
		
		$itemid = JRequest::getVar('Itemid');
		if (!empty($itemid)) {
			$link .= '&Itemid='.$itemid;
		} else {
			$app = JFactory::getApplication();
			$menus = $app->getMenu('site');
			$active = $menus->getActive();

			if ($active)
				$link .= '&Itemid='.$active->id;
		}

		return $link;
	}

}
?>