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

jimport('joomla.application.categories');

function <%= _.str.capitalize(_.slugify(componentName)) %>BuildRoute(&$query)
{
	$segments = array();

	$app = JFactory::getApplication();
	$menu = $app->getMenu();

	$params =& JComponentHelper::getParams('com_<%= _.slugify(componentName) %>');

	// get a menu item based on Itemid or currently active
	if (empty($query['Itemid']))
		$query['Itemid'] = $menu->getActive()->id;

	if(isset($query['view']))
	{
		$segments[] = $query['view'];
		unset( $query['view'] );

		if(isset($query['task']))
		{
			$segments[] = $query['task'];
			unset( $query['task'] );
		}
	}

	return $segments;
}

function <%= _.str.capitalize(_.slugify(componentName)) %>ParseRoute($segments)
{
	$vars = array();
	$menu =& JSite::getMenu();
	$item =& $menu->getActive();

	// Count route segments
	$count = count($segments);

	if($count == 1) {
		$vars['view'] = $segments[0];
	} elseif($count > 1) {
		$vars['view'] = $segments[0];
		$vars['task'] = $segments[1];
	}
	return $vars;
}
?>