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

// import Joomla view library
jimport('joomla.application.component.view');

/**
 * Gallery HTML View class for the My Album Component
 */
class <%= _.str.capitalize(_.slugify(componentName)) %>ViewGallery extends JViewLegacy
{
	// Overwriting JView display method
	function display($tpl = null)
	{
		$app = JFactory::getApplication();
		
		// Assign data to the view
		$this->params =& JComponentHelper::getParams('com_<%= _.slugify(componentName) %>');
		$this->files = $this->get('Files');
		$this->target = $this->get('Target');
		$this->msgs = $this->get('Msgs');

		$this->filecnt = 0;
		foreach ($this->files as $f)
		{
			if ($f->type == 'FILE')
				$this->filecnt++;
		}

		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			JError::raiseError(500, implode('<br />', $errors));
			return false;
		}

		// Set the toolbar
		$this->addToolBar();

		// Display the view
		parent::display($tpl);

		// Set the document
		$this->setDocument();
	}

	// Setting the toolbar
	protected function addToolBar()
	{
		$canDo = <%= _.str.capitalize(_.slugify(componentName)) %>Helper::getActions();
		JToolBarHelper::title(JText::_('COM_<%= _.slugify(componentName).toUpperCase() %>_MANAGER_<%= _.slugify(componentName).toUpperCase() %>S'), '<%= _.slugify(componentName) %>');
		if ($canDo->get('core.admin'))
		{
			JToolBarHelper::preferences('com_<%= _.slugify(componentName) %>');
		}
	}

	// Method to set up the document properties
	protected function setDocument()
	{
		$document = JFactory::getDocument();
		$document->setTitle(JText::_('COM_<%= _.slugify(componentName).toUpperCase() %>_ADMINISTRATION'));
	}
}
?>