<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_<%= _.slugify(componentName) %>
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

/**
 * <%= _.str.capitalize(_.slugify(componentName)) %> component helper.
 *
 * @param   string  $submenu  The name of the active view.
 *
 * @return  void
 *
 * @since   1.6
 */
abstract class <%= _.str.capitalize(_.slugify(componentName)) %>Helper
{
	/**
	 * Configure the Linkbar.
	 */
	public static function addSubmenu($submenu) 
	{
		JSubMenuHelper::addEntry(
			JText::_('COM_<%= _.slugify(componentName).toUpperCase() %>_SUBMENU_MESSAGES'),
			'index.php?option=com_<%= _.slugify(componentName) %>',
			$submenu == 'messages'
		);

		JSubMenuHelper::addEntry(
			JText::_('COM_<%= _.slugify(componentName).toUpperCase() %>_SUBMENU_CATEGORIES'),
			'index.php?option=com_categories&view=categories&extension=com_<%= _.slugify(componentName) %>',
			$submenu == 'categories'
		);

		// set some global property
		$document = JFactory::getDocument();
		$document->addStyleDeclaration('.icon-48-<%= _.slugify(componentName) %> ' .
		                               '{background-image: url(../media/com_<%= _.slugify(componentName) %>/images/tux-48x48.png);}');
		if ($submenu == 'categories') 
		{
			$document->setTitle(JText::_('COM_<%= _.slugify(componentName).toUpperCase() %>_ADMINISTRATION_CATEGORIES'));
		}
	}

	/**
	 * Get the actions
	 */
	public static function getActions($messageId = 0)
	{	
		$result	= new JObject;

		if (empty($messageId)) {
			$assetName = 'com_<%= _.slugify(componentName) %>';
		}
		else {
			$assetName = 'com_<%= _.slugify(componentName) %>.message.'.(int) $messageId;
		}

		$actions = JAccess::getActions('com_<%= _.slugify(componentName) %>', 'component');

		foreach ($actions as $action) {
			$result->set($action->name, JFactory::getUser()->authorise($action->name, $assetName));
		}

		return $result;
	}
}
