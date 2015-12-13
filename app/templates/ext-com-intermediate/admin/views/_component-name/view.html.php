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

/**
 * <%= _.str.capitalize(_.slugify(componentName)) %> View
 *
 * @since  0.0.1
 */
class <%= _.str.capitalize(_.slugify(componentName)) %>View<%= _.str.capitalize(_.slugify(componentName)) %> extends JViewLegacy
{
	protected $form;
	protected $item;
	protected $script;
	protected $canDo;

	/**
	 * Display the <%= _.str.capitalize(_.slugify(componentName)) %> view
	 *
	 * @param   string  $tpl  The name of the template file to parse; automatically searches through the template paths.
	 *
	 * @return  void
	 */
	public function display($tpl = null)
	{
		// Get the Data
		$this->form = $this->get('Form');
		$this->item = $this->get('Item');
		$this->script = $this->get('Script');

		// What Access Permissions does this user have? What can (s)he do?
		$this->canDo = <%= _.str.capitalize(_.slugify(componentName)) %>Helper::getActions($this->item->id);

		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			JError::raiseError(500, implode('<br />', $errors));

			return false;
		}

		// Set the toolbar
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
		$input = JFactory::getApplication()->input;

		// Hide Joomla Administrator Main menu
		$input->set('hidemainmenu', true);

		$isNew = ($this->item->id == 0);

		JToolBarHelper::title($isNew ? JText::_('COM_<%= _.slugify(componentName).toUpperCase() %>_MANAGER_<%= _.slugify(componentName).toUpperCase() %>_NEW')
		                             : JText::_('COM_<%= _.slugify(componentName).toUpperCase() %>_MANAGER_<%= _.slugify(componentName).toUpperCase() %>_EDIT'), '<%= _.slugify(componentName).toUpperCase() %>');
		// Build the actions for new and existing records.
		if ($isNew)
		{
			// For new records, check the create permission.
			if ($this->canDo->get('core.create')) 
			{
				JToolBarHelper::apply('<%= _.slugify(componentName).toUpperCase() %>.apply', 'JTOOLBAR_APPLY');
				JToolBarHelper::save('<%= _.slugify(componentName).toUpperCase() %>.save', 'JTOOLBAR_SAVE');
				JToolBarHelper::custom('<%= _.slugify(componentName).toUpperCase() %>.save2new', 'save-new.png', 'save-new_f2.png',
				                       'JTOOLBAR_SAVE_AND_NEW', false);
			}
			JToolBarHelper::cancel('<%= _.slugify(componentName).toUpperCase() %>.cancel', 'JTOOLBAR_CANCEL');
		}
		else
		{
			if ($this->canDo->get('core.edit'))
			{
				// We can save the new record
				JToolBarHelper::apply('<%= _.slugify(componentName).toUpperCase() %>.apply', 'JTOOLBAR_APPLY');
				JToolBarHelper::save('<%= _.slugify(componentName).toUpperCase() %>.save', 'JTOOLBAR_SAVE');
 
				// We can save this record, but check the create permission to see
				// if we can return to make a new one.
				if ($this->canDo->get('core.create')) 
				{
					JToolBarHelper::custom('<%= _.slugify(componentName).toUpperCase() %>.save2new', 'save-new.png', 'save-new_f2.png',
					                       'JTOOLBAR_SAVE_AND_NEW', false);
				}
			}
			if ($this->canDo->get('core.create')) 
			{
				JToolBarHelper::custom('<%= _.slugify(componentName).toUpperCase() %>.save2copy', 'save-copy.png', 'save-copy_f2.png',
				                       'JTOOLBAR_SAVE_AS_COPY', false);
			}
			JToolBarHelper::cancel('<%= _.slugify(componentName).toUpperCase() %>.cancel', 'JTOOLBAR_CLOSE');
		}
	}
	/**
	 * Method to set up the document properties
	 *
	 * @return void
	 */
	protected function setDocument() 
	{
		$isNew = ($this->item->id == 0);
		$document = JFactory::getDocument();
		$document->setTitle($isNew ? JText::_('COM_<%= _.slugify(componentName).toUpperCase() %>_<%= _.slugify(componentName).toUpperCase() %>_CREATING')
		                           : JText::_('COM_<%= _.slugify(componentName).toUpperCase() %>_<%= _.slugify(componentName).toUpperCase() %>_EDITING'));
		$document->addScript(JURI::root() . $this->script);
		$document->addScript(JURI::root() . "/administrator/components/com_<%= _.slugify(componentName).toUpperCase() %>"
		                                  . "/views/<%= _.slugify(componentName).toUpperCase() %>/submitbutton.js");
		JText::script('COM_<%= _.slugify(componentName).toUpperCase() %>_<%= _.slugify(componentName).toUpperCase() %>_ERROR_UNACCEPTABLE');
	}
}
