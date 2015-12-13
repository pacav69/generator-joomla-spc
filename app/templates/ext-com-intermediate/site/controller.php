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
 * <%= _.str.capitalize(_.slugify(componentName)) %> Component Controller
 *
 * @since  0.0.1
 */
class <%= _.str.capitalize(_.slugify(componentName)) %>Controller extends JControllerLegacy
{
}
