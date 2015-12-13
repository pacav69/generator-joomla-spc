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

// Legacy workaround
if(!defined('DS')){     define('DS',DIRECTORY_SEPARATOR); } 

// todo: remove debug code
// page loading time
$starttime = explode(' ', microtime());
$starttime =  $starttime[1] + $starttime[0];

require_once JPATH_COMPONENT.'/helpers/route.php';

// import joomla controller library
jimport('joomla.application.component.controller');

if (! class_exists('<%= _.str.capitalize(_.slugify(componentName)) %>Util'))
{
    require_once( JPATH_ADMINISTRATOR.DS.'components'.DS.'com_<%= _.slugify(componentName) %>'.DS.'libraries'.DS.'<%= _.slugify(componentName) %>.php');
}

if (! class_exists('<%= _.str.capitalize(_.slugify(componentName)) %>Zipfile'))
{
    require_once( JPATH_ADMINISTRATOR.DS.'components'.DS.'com_<%= _.slugify(componentName) %>'.DS.'libraries'.DS.'ziparchive.php');
}

// Get an instance of the controller prefixed by <%= _.str.capitalize(_.slugify(componentName)) %>
$controller = JControllerLegacy::getInstance('<%= _.str.capitalize(_.slugify(componentName)) %>');

// Perform the Request task
$controller->execute(JRequest::getCmd('task'));

// Redirect if set by the controller
$controller->redirect();

// page loading time
$mtime = explode(' ', microtime());
$totaltime = $mtime[0] + $mtime[1] - $starttime;
printf('<!-- My Album generated in %.3f seconds. -->',  $totaltime);


?>