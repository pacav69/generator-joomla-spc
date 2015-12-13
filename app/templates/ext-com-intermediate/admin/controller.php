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
 * General Controller of <%= _.str.capitalize(_.slugify(componentName)) %> component
 *
 * @package     Joomla.Administrator
 * @subpackage  com_<%= _.slugify(componentName) %>
 * @since       0.0.7
 */
class <%= _.str.capitalize(_.slugify(componentName)) %>Controller extends JControllerLegacy
{
	/**
	 * The default view for the display method.
	 *
	 * @var string
	 * @since 12.2
	 */
	protected $default_view = '<%= _.slugify(componentName) %>s';
}
