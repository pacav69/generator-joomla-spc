<?php
/**
 * com_<%= _.slugify(componentName) %>	My Album component for Joomla
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

// Legacy workaround
if(!defined('DS')){ define('DS',DIRECTORY_SEPARATOR); } 

// Access check.
if (!JFactory::getUser()->authorise('core.manage', 'com_<%= _.slugify(componentName) %>'))
{
	return JError::raiseWarning(404, JText::_('JERROR_ALERTNOAUTHOR'));
}

if (! class_exists('<%= _.str.capitalize(_.slugify(componentName)) %>Util'))
{
    require_once( JPATH_ADMINISTRATOR.DS.'components'.DS.'com_<%= _.slugify(componentName) %>'.DS.'libraries'.DS.'<%= _.slugify(componentName) %>.php');
}

if (! class_exists('<%= _.str.capitalize(_.slugify(componentName)) %>Zipfile'))
{
    require_once( JPATH_ADMINISTRATOR.DS.'components'.DS.'com_<%= _.slugify(componentName) %>'.DS.'libraries'.DS.'ziparchive.php');
}

// require helper file
JLoader::register('<%= _.str.capitalize(_.slugify(componentName)) %>Helper', dirname(__FILE__) . DS . 'helpers' . DS . '<%= _.slugify(componentName) %>.php');

// import joomla controller library
jimport('joomla.application.component.controller');

// Get an instance of the controller prefixed by <%= _.str.capitalize(_.slugify(componentName)) %>
$controller = JControllerLegacy::getInstance('<%= _.str.capitalize(_.slugify(componentName)) %>');

// Perform the Request task
$controller->execute(JRequest::getCmd('task'));

// Redirect if set by the controller
$controller->redirect();
