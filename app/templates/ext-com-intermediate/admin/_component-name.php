<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_<%= _.slugify(componentName) %>
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// Set some global property
$document = JFactory::getDocument();
$document->addStyleDeclaration('.icon-<%= _.slugify(componentName) %> {background-image: url(../media/com_<%= _.slugify(componentName) %>/images/tux-16x16.png);}');

// Access check: is this user allowed to access the backend of this component?
if (!JFactory::getUser()->authorise('core.manage', 'com_<%= _.slugify(componentName) %>'))
{
	return JError::raiseWarning(404, JText::_('JERROR_ALERTNOAUTHOR'));
}

// require helper file
JLoader::register('<%= _.str.capitalize(_.slugify(componentName)) %>Helper', JPATH_COMPONENT . '/helpers/<%= _.slugify(componentName) %>.php');

// Get an instance of the controller prefixed by <%= _.str.capitalize(_.slugify(componentName)) %>
$controller = JControllerLegacy::getInstance('<%= _.str.capitalize(_.slugify(componentName)) %>');

// Perform the Request task
$input = JFactory::getApplication()->input;
$controller->execute($input->getCmd('task'));

// Redirect if set by the controller
$controller->redirect();
