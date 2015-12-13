<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_com_<%= _.slugify(componentName) %>
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

JFormHelper::loadFieldClass('list');

/**
 * <%= _.slugify(componentName).toUpperCase() %>
 * <%= _.str.capitalize(_.slugify(componentName)) %>
 * com_<%= _.slugify(componentName) %>
 *
 * <%= _.str.capitalize(_.slugify(componentName)) %> Form Field class for the <%= _.str.capitalize(_.slugify(componentName)) %> component
 *
 * @since  0.0.1
 */
class JFormField<%= _.str.capitalize(_.slugify(componentName)) %> extends JFormFieldList
{
	/**
	 * The field type.
	 *
	 * @var         string
	 */
	protected $type = '<%= _.str.capitalize(_.slugify(componentName)) %>';

	/**
	 * Method to get a list of options for a list input.
	 *
	 * @return  array  An array of JHtml options.
	 */
	protected function getOptions()
	{
		$db    = JFactory::getDBO();
		$query = $db->getQuery(true);
		$query->select('#__com_<%= _.slugify(componentName) %>.id as id,greeting,#__categories.title as category,catid');
		$query->from('#__com_<%= _.slugify(componentName) %>');
		$query->leftJoin('#__categories on catid=#__categories.id');
		// Retrieve only published items
		$query->where('#__com_<%= _.slugify(componentName) %>.published = 1');
		$db->setQuery((string) $query);
		$messages = $db->loadObjectList();
		$options  = array();

		if ($messages)
		{
			foreach ($messages as $message)
			{
				$options[] = JHtml::_('select.option', $message->id, $message->greeting .
				                      ($message->catid ? ' (' . $message->category . ')' : ''));
			}
		}

		$options = array_merge(parent::getOptions(), $options);

		return $options;
	}
}
