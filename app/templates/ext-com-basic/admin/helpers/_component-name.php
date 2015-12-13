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

/**
 * My Album component helper.
 */
abstract class <%= _.str.capitalize(_.slugify(componentName)) %>Helper
{
	/**
	 * Configure the Linkbar.
	 */
	public static function addSubmenu($submenu)
	{
		// set some global property
		$document = JFactory::getDocument();
		$document->addStyleDeclaration('.icon-48-<%= _.slugify(componentName) %> {background-image: url(../media/com_<%= _.slugify(componentName) %>/images/<%= _.slugify(componentName) %>_toolbar.png);}');
	}

	/**
	 * Get the actions
	 */
	public static function getActions($messageId = 0)
	{
		$user	= JFactory::getUser();
		$result	= new JObject;

		if (empty($messageId)) {
			$assetName = 'com_<%= _.slugify(componentName) %>';
		}
		else {
			$assetName = 'com_<%= _.slugify(componentName) %>.message.'.(int) $messageId;
		}

		$actions = array(
			'core.admin', 'core.manage', 'core.create', 'core.edit', 'core.delete'
		);

		foreach ($actions as $action) {
			$result->set($action,	$user->authorise($action, $assetName));
		}

		return $result;
	}
}
