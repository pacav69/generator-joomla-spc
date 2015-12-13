<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_<%= _.str.capitalize(_.slugify(componentName)) %>
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

/**
 * <%= _.str.capitalize(_.slugify(componentName)) %>s View
 *
 * @since  0.0.1
 */
class <%= _.str.capitalize(_.slugify(componentName)) %>View<%= _.str.capitalize(_.slugify(componentName)) %>s extends JViewLegacy
{
	/**
	 * Display the <%= _.str.capitalize(_.slugify(componentName)) %> view
	 *
	 * @param   string  $tpl  The name of the template file to parse; automatically searches through the template paths.
	 *
	 * @return  void
	 */
	function display($tpl = null)
	{
		
		// Get application
		$app = JFactory::getApplication();
		$context = "<%= _.str.capitalize(_.slugify(componentName)) %>.list.admin.<%= _.str.capitalize(_.slugify(componentName)) %>";
		// Get data from the model
		$this->items		= $this->get('Items');
		$this->pagination	= $this->get('Pagination');
		$this->state		= $this->get('State');
		$this->filter_order	= $app->getUserStateFromRequest($context.'filter_order', 'filter_order', 'greeting', 'cmd');
		$this->filter_order_Dir = $app->getUserStateFromRequest($context.'filter_order_Dir', 'filter_order_Dir', 'asc', 'cmd');
		$this->filterForm    	= $this->get('FilterForm');
		$this->activeFilters 	= $this->get('ActiveFilters');

		// What Access Permissions does this user have? What can (s)he do?
		$this->canDo = <%= _.str.capitalize(_.slugify(componentName)) %>Helper::getActions();

		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			JError::raiseError(500, implode('<br />', $errors));

			return false;
		}

		// Set the submenu
		<%= _.str.capitalize(_.slugify(componentName)) %>Helper::addSubmenu('<%= _.str.capitalize(_.slugify(componentName)) %>s');

		// Set the toolbar and number of found items
		$this->addToolBar();

		// Display the template
		parent::display($tpl);

		// Set the document
		$this->setDocument();
	}

	/**
	 * Add the page title and toolbar.
	 *
	 * @return  void
	 *
	 * @since   1.6
	 */
	protected function addToolBar()
	{
		$title = JText::_('COM_<%= _.slugify(componentName).toUpperCase() %>_MANAGER_<%= _.slugify(componentName).toUpperCase() %>S');

		if ($this->pagination->total)
		{
			$title .= "<span style='font-size: 0.5em; vertical-align: middle;'>(" . $this->pagination->total . ")</span>";
		}

		JToolBarHelper::title($title, '<%= _.str.capitalize(_.slugify(componentName)) %>');

		if ($this->canDo->get('core.create')) 
		{
			JToolBarHelper::addNew('<%= _.str.capitalize(_.slugify(componentName)) %>.add', 'JTOOLBAR_NEW');
		}
		if ($this->canDo->get('core.edit')) 
		{
			JToolBarHelper::editList('<%= _.str.capitalize(_.slugify(componentName)) %>.edit', 'JTOOLBAR_EDIT');
		}
		if ($this->canDo->get('core.delete')) 
		{
			JToolBarHelper::deleteList('', '<%= _.str.capitalize(_.slugify(componentName)) %>s.delete', 'JTOOLBAR_DELETE');
		}
		if ($this->canDo->get('core.admin')) 
		{
			JToolBarHelper::divider();
			JToolBarHelper::preferences('com_<%= _.str.capitalize(_.slugify(componentName)) %>');
		}
	}
	/**
	 * Method to set up the document properties
	 *
	 * @return void
	 */
	protected function setDocument() 
	{
		$document = JFactory::getDocument();
		$document->setTitle(JText::_('COM_<%= _.slugify(componentName).toUpperCase() %>_ADMINISTRATION'));
	}
}