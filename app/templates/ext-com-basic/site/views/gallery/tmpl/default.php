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

jimport( 'joomla.filter.output' );
?>
<div class="<%= _.slugify(componentName) %>" >
<?php

// display album header
<%= _.str.capitalize(_.slugify(componentName)) %>HTML::header( $this->target, $this->filecnt);

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

/*
<h1><?php echo $this->item->greeting.(($this->item->category and $this->item->params->get('show_category')) ? (' ('.$this->item->category.')') : ''); ?></h1>
<p><?php $this->item->category; ?></p>
*/
?>
</div>