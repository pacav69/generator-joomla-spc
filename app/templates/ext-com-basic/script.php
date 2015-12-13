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

/**
 * Script file of <%= _.slugify(componentName).toUpperCase() %> component
 */
class com_<%= _.str.capitalize(_.slugify(componentName)) %>InstallerScript
{
	/**
	 * method to install the component
	 *
	 * @return void
	 */
	function install($parent)
	{
		// $parent is the class calling this method
?>
<table width="100%">
<tr><th><%= _.slugify(componentName).toUpperCase() %> component v1.0.0</th>
<tr><td>
Another fine Joomla! component 
<br /><br />
A lightweight, easy to use, album component for Joomla!<br />
For information, comments or any contribution of code or documentation feel free to contact me</a>. Feedback is always welcome!<br />
<br />
<b><u>Features</u></b><br />
&nbsp;-&nbsp;Support for JPG / JPEG, GIF and PNG image formats<br />
&nbsp;-&nbsp;Thumbnail navigation incl. automated thumbnail generation & scaling<br />
&nbsp;-&nbsp;Fast page generation using server-sided caching<br />
&nbsp;-&nbsp;Easy to use front-end management interface<br />
&nbsp;-&nbsp;Supports resizing of master images<br />
&nbsp;-&nbsp;Automated thumbnail generation & scaling<br />
&nbsp;-&nbsp;Basic captioning system included<br />
&nbsp;-&nbsp;Upload individual images or a complete zip archive<br />
<br />
</td></tr>
</table>
<br />
<?php	
		echo '<p>' . JText::_('COM_<%= _.slugify(componentName).toUpperCase() %>_INSTALL_TEXT') . '</p>';
	}

	/**
	 * method to uninstall the component
	 *
	 * @return void
	 */
	function uninstall($parent)
	{
		// $parent is the class calling this method
		echo '<p>' . JText::_('COM_<%= _.slugify(componentName).toUpperCase() %>_UNINSTALL_TEXT') . '</p>';
	}

	/**
	 * method to update the component
	 *
	 * @return void
	 */
	function update($parent)
	{
		// $parent is the class calling this method
		echo '<p>' . JText::_('COM_<%= _.slugify(componentName).toUpperCase() %>_UPDATE_TEXT') . '</p>';
	}

	/**
	 * method to run before an install/update/uninstall method
	 *
	 * @return void
	 */
	function preflight($type, $parent)
	{
		// $parent is the class calling this method
		// $type is the type of change (install, update or discover_install)
	}

	/**
	 * method to run after an install/update/uninstall method
	 *
	 * @return void
	 */
	function postflight($type, $parent)
	{
		// $parent is the class calling this method
		// $type is the type of change (install, update or discover_install)
	}
}
