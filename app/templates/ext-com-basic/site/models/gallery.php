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

// import the Joomla model library
jimport('joomla.application.component.model');

/**
 * Gallery Model
 */
class <%= _.str.capitalize(_.slugify(componentName)) %>ModelGallery extends JModelLegacy
{
	protected $files;
	protected $target;
	
	/* initialisation */
	protected function populateState()
	{
		$app = JFactory::getApplication();
		$menu =& JSite::getMenu();
		
		// Load the parameters
		$params =& JComponentHelper::getParams('com_<%= _.slugify(componentName) %>');
		
		$this->setState('params', $params);

		$this->target = <%= _.str.capitalize(_.slugify(componentName)) %>Util::getTarget( );

		// Set the menu
		$itemid = JRequest::getVar('Itemid');
		if (!empty($itemid))
			$menu->setActive($itemid);

		parent::populateState();
	}

	public function getFiles()
	{
		if (!isset($this->files))
		{
			$params = clone $this->getState('params');

			$this->files = <%= _.str.capitalize(_.slugify(componentName)) %>Util::get_files( $this->target );
		}
		return $this->files;
	}	

	public function getTarget()
	{
		return $this->target;
	}	

	public function getMsgs()
	{
		$app = JFactory::getApplication();

		return (array)$app->getUserState('com_<%= _.slugify(componentName) %>.gallery.msgs', array());
	}	
}
?>