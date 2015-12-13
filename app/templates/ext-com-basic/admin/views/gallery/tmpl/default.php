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
defined('_JEXEC') or die('Restricted Access');
?>
<div class="<%= _.slugify(componentName) %>" >
<form action="<?php echo JRoute::_('index.php?option=com_<%= _.slugify(componentName) %>'); ?>" method="post" name="adminForm">
	<table class="adminlist">
		<thead>
<?php
		// display album header
		<%= _.str.capitalize(_.slugify(componentName)) %>HTML::header( $this->target, $this->filecnt);
?>
		</thead>
		<tbody>
<?php
// Display messages
if (count($this->msgs) > 0) {
?>
<dl id="system-message">
<dt class="message">Message</dt>
<dd class="message message">
<ul>
<?php foreach ($this->msgs as $msg) { echo "<li>".$msg."</li>\n"; } ?>
</ul>
</dd>
</dl>
<?php
}

// display album content
<%= _.str.capitalize(_.slugify(componentName)) %>HTML::showAlbum( $this->files, $this->target );

// display album footer
<%= _.str.capitalize(_.slugify(componentName)) %>HTML::footer( $this->target, $this->filecnt );

?>
		</tbody>
	</table>
	<div>
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="boxchecked" value="0" />
		<?php echo JHtml::_('form.token'); ?>
	</div>
</form>
</div>