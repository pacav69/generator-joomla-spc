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

// import Joomla controller library
jimport('joomla.application.component.controller');

/**
 * Controller of the My Album component
 */
class <%= _.str.capitalize(_.slugify(componentName)) %>Controller extends JControllerLegacy
{
	protected $msgs;
	
	function __construct($config = array())
	{
		$this->msgs = array();

		<%= _.str.capitalize(_.slugify(componentName)) %>Util::initialise( $this->msgs, true );

		// Save the msgs in the session.
		$app = JFactory::getApplication();
		$app->setUserState('com_<%= _.slugify(componentName) %>.gallery.msgs', $this->msgs);

		parent::__construct($config);
	}

	public function display($cachable = false)
	{
		// Set gallery as a default view
		JRequest::setVar('view', JRequest::getCmd('view', 'gallery'));

		<%= _.str.capitalize(_.slugify(componentName)) %>Helper::addSubmenu('messages');

		parent::display($cachable);
	}

	public function create()
	{
		$app = JFactory::getApplication();

		// Save the msgs in the session.
		$app->setUserState('com_<%= _.slugify(componentName) %>.gallery.msgs', <%= _.str.capitalize(_.slugify(componentName)) %>Tasks::create_folder() );

		self::display();
	}

	public function delete()
	{
		$app = JFactory::getApplication();

		// Save the msgs in the session.
		$app->setUserState('com_<%= _.slugify(componentName) %>.gallery.msgs', <%= _.str.capitalize(_.slugify(componentName)) %>Tasks::delete_file_or_folder( ));

		self::display();
	}

	public function savecap()
	{
		$app = JFactory::getApplication();

		// Save the msgs in the session.
		$app->setUserState('com_<%= _.slugify(componentName) %>.gallery.msgs', <%= _.str.capitalize(_.slugify(componentName)) %>Tasks::save_caption( ));

		self::display();
	}
 
	public function purgecache()
	{
		$app = JFactory::getApplication();

		// Save the msgs in the session.
		$app->setUserState('com_<%= _.slugify(componentName) %>.gallery.msgs', <%= _.str.capitalize(_.slugify(componentName)) %>Tasks::purge_cache( ));

		self::display();
	}
 
	public function upload()
	{
		$app = JFactory::getApplication();

		// Save the msgs in the session.
		$app->setUserState('com_<%= _.slugify(componentName) %>.gallery.msgs', <%= _.str.capitalize(_.slugify(componentName)) %>Tasks::file_upload( ));

		self::display();
	}
}
?>