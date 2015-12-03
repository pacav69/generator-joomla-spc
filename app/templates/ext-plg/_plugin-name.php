<?php
/**
* <%= _.slugify(componentGroup)%><%= _.slugify(componentName)%>.php
*
* Entry point, loader file for <%= componentName %> plugin.
* @package     <%= _.slugify(componentName) %>
* @subpackage  <%= _.slugify(componentGroup)%><%= _.slugify(componentName)%>
* @copyright   Copyright (C) <%= currentYear %> <%= authorName %>. All rights reserved.
* @license     <%= license %>
*/

// prevent unwanted access
defined('_JEXEC') or die;
jimport('joomla.plugin.plugin');
class plg<%= _.slugify(componentGroup)%><%= _.slugify(componentName)%> extends JPlugin
{
function plg<%= _.slugify(componentGroup)%><%= _.slugify(componentName)%>( &$subject, $params )
{
parent::__construct( $subject, $params );
}

// using params in a function of plugin
// params1 and params2 are the names used in plugin_name.xml
//
protected function <%= _.slugify(componentName)%>(&$text, &$params)
{
	$params1 = $this->params->get('params1', 4);
	$params2 = $this->params->get('params2', 4);
	// matches 4 numbers followed by an optional hyphen or space,then followed by 4 numbers.
	// phone number is in the form XXXX-XXXX or XXXX XXXX
	$pattern = '/(\W[0-9]{'.$params1.'})-? ?(\W[0-
	9]{'.$params2.'})/';
	$replacement = '<a href="tel:$1$2">$1$2</a>';
	$text = preg_replace($pattern, $replacement, $text);
	return true;
}