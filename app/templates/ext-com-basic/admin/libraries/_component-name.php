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

class <%= _.str.capitalize(_.slugify(componentName)) %>Tasks
{
	function create_folder( )
	{
		$params =& JComponentHelper::getParams('com_<%= _.slugify(componentName) %>');
		$return_val = '';
		
		$iname = JRequest::getString('item');
		$name = <%= _.str.capitalize(_.slugify(componentName)) %>Util::sanitised_name( $iname );
		$target = <%= _.str.capitalize(_.slugify(componentName)) %>Util::getTarget();
		$folder = $params->get('base_dir').$target.DS.$name;

		if (!$params->get('can-edit'))
		{
			JError::raiseError('401', JText::_('COM_<%= _.slugify(componentName).toUpperCase() %>_NOTAUTH'));
			$return_val = JText::_('COM_<%= _.slugify(componentName).toUpperCase() %>_NOTAUTH');
		}
		elseif ( !isset($name) || ($name == '') || ($iname != <%= _.str.capitalize(_.slugify(componentName)) %>Util::sanitised_name( $iname, false )) )
		{
			$return_val = JText::_('COM_<%= _.slugify(componentName).toUpperCase() %>_CREATE_INVALID_FILENAME')." '".$iname."'";
		}
		elseif ( file_exists($folder) )
		{
			$return_val = JText::_('COM_<%= _.slugify(componentName).toUpperCase() %>_CREATE_ALREADY_EXISTS')." '".$name."'";
		}
		else
		{
			@mkdir($folder, base_convert($params->get('folder_permissions'), 8, 10) );

			if ( !file_exists($folder))
				$return_val = JText::_('COM_<%= _.slugify(componentName).toUpperCase() %>_CREATE_FAILED')." '".$name."'".(( !is_writable(<%= _.str.capitalize(_.slugify(componentName)) %>Util::parent_directory($folder)) )?(', '.JText::_('COM_<%= _.slugify(componentName).toUpperCase() %>_CREATE_PARENT_NOT_WRITEABLE')):'');
			else
			{
				// overwrite target param
				JRequest::setVar('target', $target.DS.$name);
				
				$return_val = JText::_('COM_<%= _.slugify(componentName).toUpperCase() %>_CREATE_SUCCESS')." '".$name."'";
			}
		}
				
		// overwrite task param
		JRequest::setVar('task', 'show');

		return $return_val;
	}

	function delete_file_or_folder(  )
	{
		$params =& JComponentHelper::getParams('com_<%= _.slugify(componentName) %>');
		$return_val = '';

		$target = <%= _.str.capitalize(_.slugify(componentName)) %>Util::getTarget();
		$name = JRequest::getString('item');
		$folder = $params->get('base_dir').$target.DS;
		$removed = false;

		if ( !<%= _.str.capitalize(_.slugify(componentName)) %>Util::allow_delete( $target.DS.$name ) )
		{
			JError::raiseError('401', JText::_('COM_<%= _.slugify(componentName).toUpperCase() %>_NOTAUTH'));
			$return_val = JText::_('COM_<%= _.slugify(componentName).toUpperCase() %>_NOTAUTH');
		}
		elseif ( !isset($name) || ($name == '') || !file_exists($folder.$name) )
		{
			$return_val = JText::_('COM_<%= _.slugify(componentName).toUpperCase() %>_DELETE_ERROR')." '".$name."'";
		}
		else
		{
			if ( is_file( $folder.$name) )
			{
				@unlink( $folder.$name );
				@unlink( $folder.<%= _.str.capitalize(_.slugify(componentName)) %>Util::thumbname( $name, 'small' ) );
				@unlink( $folder.<%= _.str.capitalize(_.slugify(componentName)) %>Util::thumbname( $name, 'medium' ) );
				$removed = true;
			}
			else
			{
				<%= _.str.capitalize(_.slugify(componentName)) %>Util::full_rmdir( $folder.$name );
				$removed = true;
			} 

			if ($removed)
			{
				// remove caption & invalidate cache
				<%= _.str.capitalize(_.slugify(componentName)) %>Util::remove_caption( $target, $name);
				<%= _.str.capitalize(_.slugify(componentName)) %>Util::invalidate_thumb_cache( $target );
			}

			if ( ! file_exists($folder.$name))
				$return_val = JText::_('COM_<%= _.slugify(componentName).toUpperCase() %>_DELETE_SUCCESS')." '".$name."'";
			else
				$return_val = JText::_('COM_<%= _.slugify(componentName).toUpperCase() %>_DELETE_ERROR')." '".$name."'";
		}

		// overwrite task param
		JRequest::setVar('task', 'show');

		return $return_val;
	}

	function save_caption( )
	{
		$params =& JComponentHelper::getParams('com_<%= _.slugify(componentName) %>');
		$return_val = '';

		$target = <%= _.str.capitalize(_.slugify(componentName)) %>Util::getTarget();
		$name = JRequest::getString('item');
		$caption = preg_replace("#['\n]#", "", trim( JRequest::getString('caption')));

		if (!$params->get('can-edit'))
		{
			JError::raiseError('401', JText::_('COM_<%= _.slugify(componentName).toUpperCase() %>_NOTAUTH'));
			$return_val = JText::_('COM_<%= _.slugify(componentName).toUpperCase() %>_NOTAUTH');
		}
		else
		{
			<%= _.str.capitalize(_.slugify(componentName)) %>Util::remove_caption($target, $name );
			
			if ($caption != '')
			{
				<%= _.str.capitalize(_.slugify(componentName)) %>Util::add_caption($target, $name, $caption );
				$return_val = JText::_('COM_<%= _.slugify(componentName).toUpperCase() %>_CAP_SAVED');
			} else
				$return_val = JText::_('COM_<%= _.slugify(componentName).toUpperCase() %>_CAP_REMOVED');
		}

		// overwrite target param
		if (file_exists($params->get('base_dir').$target.DS.$name))
			JRequest::setVar('target', $target.DS.$name);
		
		// overwrite task param
		JRequest::setVar('task', 'show');

		return $return_val;
	}

	function purge_cache( )
	{
		$params =& JComponentHelper::getParams('com_<%= _.slugify(componentName) %>');
		$return_val = '';

		$target = <%= _.str.capitalize(_.slugify(componentName)) %>Util::getTarget();

		if (!$params->get('can-edit'))
		{
			JError::raiseError('401', JText::_('COM_<%= _.slugify(componentName).toUpperCase() %>_NOTAUTH'));
			$return_val = JText::_('COM_<%= _.slugify(componentName).toUpperCase() %>_NOTAUTH');
		}
		else
		{
			<%= _.str.capitalize(_.slugify(componentName)) %>Util::purge_thumb_cache( $target );
			$return_val = JText::_('COM_<%= _.slugify(componentName).toUpperCase() %>_FOLDER_CACHE_PURGED');
		}
				
		// overwrite task param
		JRequest::setVar('task', 'show');

		return $return_val;
	}

	function file_upload( )
	{
		$return_val = self::_file_upload( <%= _.str.capitalize(_.slugify(componentName)) %>Util::getTarget() );

		// overwrite task param
		JRequest::setVar('task', 'show');
		
		return $return_val;
	}
	
	protected function _file_upload( $target )
	{
		$upload_prefix = 'uploaded_';
		
		$params =& JComponentHelper::getParams('com_<%= _.slugify(componentName) %>');

		if ( $params->get('debug') )
		{
			echo $_FILES['PicFile']['tmp_name']." (".$_FILES['PicFile']['type'].")";
		}

		if (!$params->get('can-edit'))
		{
			JError::raiseError('401', JText::_('COM_<%= _.slugify(componentName).toUpperCase() %>_NOTAUTH'));
			return JText::_('COM_<%= _.slugify(componentName).toUpperCase() %>_NOTAUTH');
		}
		
		// handle errors
		if ( ($_FILES['PicFile']['error'] !== UPLOAD_ERR_OK)        // PHP upload error
		    || ($_FILES['PicFile']['name'] == '')                   // Unsuccessfull upload attempt
			|| (!is_uploaded_file($_FILES['PicFile']['tmp_name']))  // File not uploaded via POST
		   )
		{
			$error = JText::_('COM_<%= _.slugify(componentName).toUpperCase() %>_UPLOAD_ERROR');

			// PHP upload errors
			if (($_FILES['PicFile']['error'] == UPLOAD_ERR_INI_SIZE) || ($_FILES['PicFile']['error'] == UPLOAD_ERR_FORM_SIZE))
				$error .= ', '.JText::_('COM_<%= _.slugify(componentName).toUpperCase() %>_UPLOAD_ERROR_SIZE');
			else if ($_FILES['PicFile']['error'] == UPLOAD_ERR_PARTIAL)
				$error .= ', '.JText::_('COM_<%= _.slugify(componentName).toUpperCase() %>_UPLOAD_ERROR_PARTIAL');
			else if ($_FILES['PicFile']['error'] == UPLOAD_ERR_NO_FILE)
				$error .= ', '.JText::_('COM_<%= _.slugify(componentName).toUpperCase() %>_UPLOAD_ERROR_NO_FILE');
			else if ($_FILES['PicFile']['error'] == UPLOAD_ERR_NO_TMP_DIR)
				$error .= ', '.JText::_('COM_<%= _.slugify(componentName).toUpperCase() %>_UPLOAD_ERROR_NO_TMP_DIR');
			else if ($_FILES['PicFile']['error'] == UPLOAD_ERR_CANT_WRITE)
				$error .= ', '.JText::_('COM_<%= _.slugify(componentName).toUpperCase() %>_UPLOAD_ERROR_WRITE');
			else if ($_FILES['PicFile']['error'] == UPLOAD_ERR_EXTENSION)
				$error .= ', '.JText::_('COM_<%= _.slugify(componentName).toUpperCase() %>_UPLOAD_ERROR_EXT');

			// attempt to delete uploaded file if it exists
			if ( file_exists( $_FILES['PicFile']['tmp_name'] ) )
				@unlink( $_FILES['PicFile']['tmp_name'] );

			return $error;
		}

		// determine file name for uploaded file
		$dir = $params->get('base_dir').$target.DS;
		$upload_file = $upload_prefix.<%= _.str.capitalize(_.slugify(componentName)) %>Util::sanitised_name(pathinfo($_FILES['PicFile']['name'], PATHINFO_FILENAME)).'.'.pathinfo($_FILES['PicFile']['name'], PATHINFO_EXTENSION);
		
		if ( $params->get('debug') )
		{
			echo " - ".$upload_file."\n";
		}

		// attempt to move uploaded file
		if (!move_uploaded_file($_FILES['PicFile']['tmp_name'], $dir.$upload_file))
		{
			// attempt to delete uploaded file if it exists
			if ( file_exists( $_FILES['PicFile']['tmp_name'] ) )
				@unlink( $_FILES['PicFile']['tmp_name'] );

			// attempt to delete uploaded file if it exists
			if ( file_exists( $dir.$upload_file ) )
				@unlink( $dir.$upload_file );

			if ( $params->get('debug') )
			{
				echo " - Unable to move uploaded file\n";
			}

			return JText::_('COM_<%= _.slugify(componentName).toUpperCase() %>_UPLOAD_ERROR');
		}
		
		// unpack zip file
		if ( (strtolower(pathinfo($upload_file, PATHINFO_EXTENSION)) == 'zip') )
		{
			if ( !in_array($_FILES['PicFile']['type'], array( 'application/zip','application/x-zip-compressed', 'application/x-compressed'))
			    || !(function_exists('zip_open') || class_exists('<%= _.slugify(componentName) %>Zipfile')) )
			{
				@unlink($dir.$upload_file);
				return JText::_('COM_<%= _.slugify(componentName).toUpperCase() %>_UPLOAD_ERROR').', '.JText::_('COM_<%= _.slugify(componentName).toUpperCase() %>_UPLOAD_ZIPERROR');
			}

			$UploadFiles = <%= _.str.capitalize(_.slugify(componentName)) %>Util::unpack($dir.$upload_file, $target, $upload_prefix);
		} else {
			$UploadFiles = array();
			$UploadFiles[] = $upload_file;
		}

		$file_cnt = count($UploadFiles);
		$failed_cnt = 0;
		$unsupported_cnt = 0;

		if ($file_cnt == 0)
			return '0 '.JText::_('COM_<%= _.slugify(componentName).toUpperCase() %>_UPLOAD_SUCCESS');

		if ( $params->get('debug') )
		{
			echo " - ".$file_cnt." files to process\n";
		}

		<%= _.str.capitalize(_.slugify(componentName)) %>Util::initialise_thumbs_folder( $target );

		// process files
		foreach ($UploadFiles as $f)
		{
			$basename    = preg_replace("#".$upload_prefix."#", "", pathinfo($f, PATHINFO_FILENAME)).'.'.strtolower( pathinfo($f, PATHINFO_EXTENSION) );
			$small_name  = <%= _.str.capitalize(_.slugify(componentName)) %>Util::thumbname($basename, 'small');
			$medium_name = <%= _.str.capitalize(_.slugify(componentName)) %>Util::thumbname($basename, 'medium');
			
			if ( file_exists($dir.$basename) )
			{
				$failed_cnt++;  // skip if file exists

				if ( $params->get('debug') )
				{
					echo " - file already exists\n";
				}

			}
			elseif ( !<%= _.str.capitalize(_.slugify(componentName)) %>Util::supported_ext( $dir.$basename ) )
			{
				$failed_cnt++;  // skip if unsupported extension

				if ( $params->get('debug') )
				{
					echo " - unsupported extension\n";
				}

			}
			elseif ( !<%= _.str.capitalize(_.slugify(componentName)) %>Util::supported_mime( $dir.$f ) )
			{
				$failed_cnt++;  // skip if unsupported mime type

				if ( $params->get('debug') )
				{
					echo " - unsupported mime type\n";
				}

			}
			else
			{
				// create thumbnail image
				if ( file_exists( $dir.$small_name ) )
					@unlink( $dir.$small_name );
			
				<%= _.str.capitalize(_.slugify(componentName)) %>Util::create_image( $dir.$f
										 , $dir.$small_name
										 , $params->get('imgsize_default_width') / $params->get('img_thumbfactor')
										 , $params->get('imgsize_default_height') / $params->get('img_thumbfactor'));
										 
				if ( $params->get('debug') )
				{
					echo " - create small thumb: ".(file_exists( $dir.$small_name )?'success':'fail')."\n";
				}
									
				// create medium size image for viewing
				if ( file_exists( $dir.$medium_name ) )
					@unlink( $dir.$medium_name );

				<%= _.str.capitalize(_.slugify(componentName)) %>Util::create_image( $dir.$f
										 , $dir.$medium_name
										 , $params->get('imgsize_default_width')
										 , $params->get('imgsize_default_height'));

				if ( $params->get('debug') )
				{
					echo " - create medium thumb: ".(file_exists( $dir.$medium_name )?'success':'fail')."\n";
				}
	
				// save the main file
				<%= _.str.capitalize(_.slugify(componentName)) %>Util::create_image($dir.$f, $dir.$basename); // copy or resize image

				if ( $params->get('debug') )
				{
					echo " - create image: ".(file_exists( $dir.$basename )?'success':'fail')."\n";
				}
	
				if ( !file_exists( $dir.$basename ) || !file_exists( $dir.$small_name ) || !file_exists( $dir.$medium_name ) )
				{
					// something went wrong, remove all files for this image
					@unlink( $dir.$basename );
					@unlink( $dir.$small_name );
					@unlink( $dir.$medium_name );
					$failed_cnt++;
					
					if ( $params->get('debug') )
					{
						echo " - something went wrong, removed all files for this image\n";
					}
		
				}
			}
			
			// Delete uploaded file if it exists
			@unlink($dir.$f);
		
		}

		// invalidate folder cache on success
		if ( ($file_cnt - $failed_cnt) > 0 )
			<%= _.str.capitalize(_.slugify(componentName)) %>Util::invalidate_thumb_cache( $target );

		$msg = ($file_cnt - $failed_cnt).' '.JText::_('COM_<%= _.slugify(componentName).toUpperCase() %>_UPLOAD_SUCCESS');

		if ($failed_cnt > 0)
			$msg .= ', '.$failed_cnt.' '.JText::_('COM_<%= _.slugify(componentName).toUpperCase() %>_UPLOAD_FAILED');

		return $msg;
	}
}

class <%= _.str.capitalize(_.slugify(componentName)) %>Util
{
	const thumbnail_folder = 'tn';
	const captions_file = 'captions.txt';
	const cache_file = 'thumb.cache';

	function initialise( &$msgs, $is_admin = false)
	{
		$params =& JComponentHelper::getParams('com_<%= _.slugify(componentName) %>');
		$user = JFactory::getUser();
        $uri = JFactory::getURI();

		$params->def('is_admin', $is_admin);

		$params->def('can-edit', (    $user->authorise('core.edit', 'com_<%= _.slugify(componentName) %>')
								   || $user->authorise('core.edit.state', 'com_<%= _.slugify(componentName) %>') 
								   || $user->authorise('core.edit.own', 'com_<%= _.slugify(componentName) %>') ) );
		$params->def('can-delete', $user->authorise('core.delete', 'com_<%= _.slugify(componentName) %>') );

		$usermode = self::getCookieParam( 'usermode', 'VIEW' );
		$params->def('editmode', ($params->get('is_admin') || $params->get('can-edit') && ($usermode == 'EDIT')) );

		// default configuration settings in case the component preferences have never been saved.
		$params->def('debug', $params->get('debug', 0));
		$params->def('folder_cache', $params->get('folder_cache', 1));
		$params->def('folder_permissions', $params->get('folder_permissions', '0755'));
		$params->def('upload_javascript', $params->get('upload_javascript', 1));
		$params->def('display_javascript', $params->get('display_javascript', 'colorbox'));
		$params->def('img_resizemethod', $params->get('img_resizemethod', 0));
		$params->def('img_thumbfactor', $params->get('img_thumbfactor', 4));
		$params->def('imgsize_default_width', $params->get('imgsize_default_width', 640));
		$params->def('imgsize_default_height', $params->get('imgsize_default_height', 480));
		$params->def('imgsize_max_width', $params->get('imgsize_max_width', 1280));
		$params->def('imgsize_max_height', $params->get('imgsize_max_height', 960));
		$params->def('spacing_horizontal', ($params->get('spacing_horizontal', 10)>0)?$params->get('spacing_horizontal', 10):0);
		$params->def('spacing_vertical', ($params->get('spacing_vertical', 40)>0)?$params->get('spacing_vertical', 40):0);
		$params->def('img_hide_caption', $params->get('img_hide_caption', 0));
		$params->def('spacing_vertical_img_only', ($params->get('spacing_vertical_img_only', 10)>0)?$params->get('spacing_vertical_img_only', 10):0);
		$params->def('sort', $params->get('sort', 'asc'));

		// change max processing time for this session (check php.ini for file upload params!), if allowed
		$max_exec_time = $params->get('max_exec_time', 600);
		$params->def('max_exec_time', $max_exec_time);
		if (!ini_get('safe_mode') && strpos(ini_get('disable_functions'), 'set_time_limit') === FALSE) {
			set_time_limit( $max_exec_time );
		}

		$params->def('img_dir', $params->get('img_dir', DS.'images'.DS.'<%= _.slugify(componentName) %>'));
		$params->def('base_url',  rtrim($uri->root(), '\/') .DS. ltrim($params->get('img_dir'), '\/') );
		$params->def('base_dir', JPATH_ROOT .DS. ltrim($params->get('img_dir'), '\/') );

		// check if base folder exists
		if (!file_exists($params->get('base_dir')))
		{
			if ($params->get('is_admin'))
			{
				$exp = explode('|', str_replace(DS, '|', $params->get('base_dir')));  // no explode on DS
				$path = '';
				foreach($exp as $n) {
					$path .= $n . DS;
					if(!file_exists($path))
						@mkdir($path, base_convert($params->get('folder_permissions'), 8, 10));
				}
			} else {
				$msgs[] = JText::_('COM_<%= _.slugify(componentName).toUpperCase() %>_ERROR_ROOT_FOLDER_NOT_EXIST');
			}
		}

		// read target with | replaced, root = empty for code dependencies
		$target = self::getTarget();

		// check if folder exists
		if ( file_exists($params->get('base_dir')) && (!file_exists($params->get('base_dir').$target)) )
			$msgs[] = JText::_('COM_<%= _.slugify(componentName).toUpperCase() %>_ERROR_FOLDER_NOT_EXIST');

		// check if folder is writeable
		if ($params->get('editmode') && !is_writeable($params->get('base_dir').$target))  
			$msgs[] = JText::_('COM_<%= _.slugify(componentName).toUpperCase() %>_ERROR_FOLDER_NOT_WRITEABLE');
	}

	function getTarget( )
	{
		// read target with | replaced, root = empty for code dependencies
		$target = str_replace('|', DS, JRequest::getString( 'target', '' ));

		// if empty target, set to current or last year if it exists and has images
		if ( ($target == '') && self::has_files(DS.date('Y'), true) )
			$target = DS.date('Y');
		elseif ( ($target == '') && self::has_files(DS.(date('Y')-1), true) )
				$target = DS.(date('Y')-1);
		
		$target = ( $target == DS )?'':$target;

		return $target;
	}

	function getCookieParam( $name, $default = '')
	{
		$val = '';
		$val_REQUEST = JRequest::getVar( $name, '' );
		$val_COOKIE = JRequest::getVar( '<%= _.slugify(componentName).toUpperCase() %>_COOKIE_'.$name, '', 'cookie' );
		
		if (($val_REQUEST == '') && ($val_COOKIE == ''))
			$val = $default;
		elseif ($val_REQUEST != '')
			$val = $val_REQUEST;
		else
			$val = $val_COOKIE;
		
		if (($val != '') && ($val_COOKIE != $val))
			setcookie( '<%= _.slugify(componentName).toUpperCase() %>_COOKIE_'.$name, $val, time()+60*60*24*7, '/', $_SERVER['HTTP_HOST'], 0 ); // 1 week cookie
		
		return $val;
	}

	function sanitised_name( $str, $fixup = true )
	{
		// remove wildcards/specialchars
		$str = preg_replace( "@:|;|#|<|>|\?|&|%|\^|\||\\\|\/|\*|\"|'|`|	|\(|\)@", "", $str );

		// remove multiple dots from string to prevent relative paths
		$str = trim( preg_replace("#\.\.+#", "", $str) );
		
		if ($fixup)
		{
			// reduce multiple spaces to single & trim string
			$str = trim( preg_replace("#\s\s+#", " ", $str) );

			// replace spaces with underscores
			$str = preg_replace( "#\s#", "_", $str );
		}
		
		return $str;
	}

	function php_ini_to_bytes( $sizevar )
	{
		$num = substr($sizevar, 0, -1);
		$char = strtolower(substr($sizevar, -1));
		return ( ($char == 'k' ? 1024 : ($char == 'm' ? 1048576 : ($char == 'g' ? 1073741824 : 1))) * $num );
	}

	function supported_extensions( )
	{
		return array( 'jpg', 'jpe', 'jpeg', 'gif', 'png');
	}

	function supported_mime_types( )
	{
		return array( 'image/pjpeg', 'image/jpeg', 'image/jpg', 'image/gif', 'image/png', 'image/x-png');
	}

	function supported_ext( $file )
	{
		return in_array( strtolower(pathinfo($file, PATHINFO_EXTENSION)), self::supported_extensions() );
	}

	function supported_mime( $file )
	{
		// 1-nov-2012 added check for valid function & rewrote finfo code (fileinfo can be disabled in php ini)
		$mime = '';
		
		if (function_exists('finfo_open')) {
			$finfo = finfo_open( FILEINFO_MIME_TYPE );

			if ($finfo) {
				$mime = finfo_file( $finfo, $file );
				finfo_close( $finfo );
			}
		}

		// added fix/workaround - sometimes the function returns an empty mime type
		return (($mime == '') or in_array( $mime, self::supported_mime_types() ) );
	}

	function initialise_thumbs_folder( $folder )
	{
		$params =& JComponentHelper::getParams('com_<%= _.slugify(componentName) %>');

		// make sure thumbnail folder exists
		if( !file_exists($params->get('base_dir').$folder.DS.(self::thumbnail_folder)) )
			@mkdir($params->get('base_dir').$folder.DS.(self::thumbnail_folder), base_convert($params->get('folder_permissions'), 8, 10));
	}
	
	function allow_delete( $target )
	{
		$params =& JComponentHelper::getParams('com_<%= _.slugify(componentName) %>');

		// user has edit rights
		if ( !$params->get('can-edit') )
			return false;
		
		// the target exits and is writable
		if ( !file_exists($params->get('base_dir').$target) || !is_writable($params->get('base_dir').$target) )
			return false;

		// we're not trying to delete the root
		if (($target == DS) || ($target == ''))
			return false;
		
		// we've not received a relative paths
        if (strpos(substr($target,0, -1*(strlen(pathinfo($target, PATHINFO_EXTENSION))+1)), '..') !== false)
			return false;
		
		// for multiple files we require explicit delete rights or backend
		$multiple_files = (count(self::get_files( $target, true, true, 2 )) > 1);
		if ($multiple_files && !($params->get('can-delete') || $params->get('is_admin')))
			return false;
		
		return true;
	}

	function full_rmdir( $dir )
	{
		if ( !is_writable( $dir ) ) {
			if ( !@chmod( $dir, 0777 ) )
				return FALSE;
		}

		$d = dir( $dir );

		while ( FALSE !== ( $entry = $d->read() ) ) {
			if ( $entry == '.' || $entry == '..' )
			continue;

			$entry = $dir.DS.$entry;
			if ( is_dir( $entry ) ) {
				if ( !self::full_rmdir( $entry ) )
					return FALSE;
				continue;
			}

			if ( !@unlink( $entry ) ) {
				$d->close();
				return FALSE;
			}
		}
		$d->close();

		rmdir( $dir );

		return TRUE;
	}

	function parent_directory( $x )
	{
		$pos = strrpos($x, "/");
		if ($pos !== false)
			return substr($x, 0, $pos);

		$pos = strrpos($x, "\\");
		if ($pos !== false)
			return substr($x, 0, $pos);

		return "";
	}

	function thumbname($item, $size = 'small')
	{
		$fname = pathinfo($item, PATHINFO_FILENAME);
		$ext = pathinfo($item, PATHINFO_EXTENSION);

		switch ($size)
		{
			case 'medium':
				$tnname = $fname.'.med.'.$ext;
				break;

			case 'small':
			default:
				$tnname = $item;
				break;
		}

		return (self::thumbnail_folder).DS.$tnname;
	}

	function unpack($zip_file, $target_folder, $file_prefix)
	{
		$params =& JComponentHelper::getParams('com_<%= _.slugify(componentName) %>');
		$files = array();

		if (function_exists('zip_open')) // use PHP built-in functions (preferred!!)
		{
			if ( $zip = zip_open($zip_file) )
			{
				while ($zip_entry = zip_read($zip))
				{
					$fname = zip_entry_name($zip_entry);
					$fname = $file_prefix.self::sanitised_name( pathinfo($fname, PATHINFO_FILENAME) ).'.'.pathinfo($fname, PATHINFO_EXTENSION);

					if (zip_entry_open($zip, $zip_entry, "r"))
					{
						$buf = zip_entry_read($zip_entry, zip_entry_filesize($zip_entry));
						
						$fp = fopen($params->get('base_dir').$target_folder.DS.$fname, "w+");
						fwrite($fp, $buf );
						fclose($fp);
							
						$files[] = $fname;
							
						zip_entry_close($zip_entry);
					}
				}
				zip_close($zip);
			}
		} else { // Self maintained code, using zipfile class
			$zip = new <%= _.slugify(componentName) %>Zipfile;
			$zip->read_zip($zip_file);

			foreach($zip->files as $f)
			{
				$fname = $file_prefix.self::sanitised_name( pathinfo($f['name'], PATHINFO_FILENAME) ).'.'.pathinfo($f['name'], PATHINFO_EXTENSION);

				$fp = fopen($params->get('base_dir').$target_folder.DS.$fname, "w+");
				fwrite($fp, $f['data']);
				fclose($fp);

				$files[] = $fname;
			}
		}

		// delete zip file
		@unlink($zip_file);
		
		return $files;
	}
	
	function remove_caption( $folder, $name )
	{
		$params =& JComponentHelper::getParams('com_<%= _.slugify(componentName) %>');

		if ( !file_exists($params->get('base_dir').$folder.DS.(self::captions_file)) )
			return;
		
		$fc = file( $params->get('base_dir').$folder.DS.(self::captions_file) );
		$f = fopen( $params->get('base_dir').$folder.DS.(self::captions_file), "w");
		
		foreach($fc as $line)
		{
			if ( strncmp($line, $name.' ', strlen($name)+1) ) // 0 (false) if equal
				fputs($f, $line);
		}
		
		fclose($f);
		
	}

	function add_caption( $folder, $name, $caption )
	{
		$params =& JComponentHelper::getParams('com_<%= _.slugify(componentName) %>');
		
		$f = fopen($params->get('base_dir').$folder.DS.(self::captions_file), "a");

		fputs($f, $name." ".$caption."\n");

		fclose($f);
	}

	function read_caption( $folder, $name )
	{
		$params =& JComponentHelper::getParams('com_<%= _.slugify(componentName) %>');

		if ( $name == '' )
			return '';

		$auto_caption = str_replace('_', ' ', pathinfo($name, is_file($params->get('base_dir').$folder.DS.$name)?PATHINFO_FILENAME:PATHINFO_BASENAME));
		
		if ( !file_exists( $params->get('base_dir').$folder.DS.(self::captions_file)) )
			return $auto_caption;

		$read_caption = '';
		$fc = file( $params->get('base_dir').$folder.DS.(self::captions_file) );
		
		foreach($fc as $line)
		{
			if ( strncmp($line, $name.' ', strlen($name)+1) == 0 ) // 0 = equal
			{
				$read_caption = trim( substr($line, strlen($name)+1) );
				
				// backwards compatibility to the Joomla 1.0 <%= _.slugify(componentName) %> component
				if ( strncmp($read_caption, $name.' ', strlen($name)+1) == 0 ) // 0 = equal
					$read_caption = trim( substr($read_caption, strlen($name)+1) );
					
				break;
			}
		}
		
		return ($read_caption == '')?$auto_caption:$read_caption;
	}

	function invalidate_thumb_cache( $folder )
	{
		$params =& JComponentHelper::getParams('com_<%= _.slugify(componentName) %>');
		
		// no cache on root folder so don't invalidate
		if ( $folder == '' )
			return;

		// remove cache for folder
		if ( file_exists( $params->get('base_dir').$folder.DS.(self::cache_file) ) )
			@unlink( $params->get('base_dir').$folder.DS.(self::cache_file) );

		// invalidate parent folders (recursive)
		self::invalidate_thumb_cache( self::parent_directory($folder) );
	}

	function purge_thumb_cache( $folder )
	{
		$params =& JComponentHelper::getParams('com_<%= _.slugify(componentName) %>');
		
		// remove cache for folder (no cache on root folder so don't bother)
		if ( ( $folder != '' ) && file_exists( $params->get('base_dir').$folder.DS.(self::cache_file) ) ) {
			@unlink( $params->get('base_dir').$folder.DS.(self::cache_file) );
		}	

		$d = dir( $params->get('base_dir').$folder );
		while ( FALSE !== ( $entry = $d->read() ) ) {
			if ( ( $entry != '.' ) && ( $entry != '..' ) && is_dir( $params->get('base_dir').$folder.DS.$entry ) ) {
				// purge child folders (recursive)
				self::purge_thumb_cache( $folder.DS.$entry );
			}
		}
		$d->close();
	}

	function read_thumb_cache( $folder )
	{
		$params =& JComponentHelper::getParams('com_<%= _.slugify(componentName) %>');
		
		$descriptor = new <%= _.slugify(componentName) %>Entry();

		if ( $params->get('folder_cache') && file_exists( $params->get('base_dir').$folder.DS.(self::cache_file) ) )
		{
			$fdata = file( $params->get('base_dir').$folder.DS.(self::cache_file) );

			foreach($fdata as $line) 
			{
				list($name, $val) = explode("=", $line, 2);
				if ($name == 'name')
					$descriptor->name = rtrim( $val );
				elseif ($name == 'type')
					$descriptor->type = rtrim( $val );
				elseif ($name == 'folder')
					$descriptor->folder = rtrim( $val );
				elseif ($name == 'img_cnt')
					$descriptor->img_cnt = rtrim( $val );
				elseif ($name == 'tn')
					$descriptor->tn = rtrim( $val );
			}
		}

		return $descriptor;
	}

	function thumb_cache_is_valid( $cache = null, $folder_name )
	{
		if (!isset($cache))
			return FALSE;
		
		// check if cache was read correctly
		return ( ($cache->name == $folder_name) && isset($cache->type) && isset($cache->folder) && isset($cache->img_cnt) && isset($cache->tn) );
	}

	function write_thumb_cache( $folder, $descriptor )
	{
		$params =& JComponentHelper::getParams('com_<%= _.slugify(componentName) %>');

		// check if cache is enabled
		if ( !$params->get('folder_cache') )
			return;

		$descriptor_str = 'name='.str_replace("\n", "", $descriptor->name)."\n"
						 .'type='.str_replace("\n", "", $descriptor->type)."\n"
						 .'folder='.str_replace("\n", "", $descriptor->folder)."\n"
						 .'img_cnt='.str_replace("\n", "", $descriptor->img_cnt)."\n"
						 .'tn='.str_replace("\n", "", $descriptor->tn)."\n";

		$handle = @fopen( $params->get('base_dir').$folder.DS.(self::cache_file), 'w');

		if ($handle)
		{
			fwrite($handle, $descriptor_str);
			fclose($handle);
		}
	}

	function has_folders( $folder )
	{
		$params =& JComponentHelper::getParams('com_<%= _.slugify(componentName) %>');

		// stop if not a valid dir
		if ( !is_dir( $params->get('base_dir').$folder ) || strstr($folder, DS.(self::thumbnail_folder)) )
			return false;
				
		$d = dir( $params->get('base_dir').$folder );

		if (!$d)
			return false;

		while ( false !== ($x = $d->read()) )
		{
			if ( $x == '.' || $x == '..' || $x == self::thumbnail_folder)
				continue;
				
			if (is_dir($params->get('base_dir').$folder.DS.$x) )
				return true;
		}
		$d->close();
		
		return false;
	}
	
	function has_files( $folder, $recursive )
	{
		return (count(self::get_files( $folder, $recursive, true, 1 )) == 1);
	}
	
	function get_files($folder, $recursive = true, $files_only = false, $max_files = -1)
	{
		$params =& JComponentHelper::getParams('com_<%= _.slugify(componentName) %>');

		$files = array();
		
		if ( is_file( $params->get('base_dir').$folder ) )
		{
			$entry = new <%= _.slugify(componentName) %>Entry();
			$entry->folder = self::parent_directory( $folder );
			$entry->name = pathinfo($folder, PATHINFO_BASENAME);
			$entry->type = 'FILE';
			$entry->img_cnt = 1;
						
			$files[] = $entry;
		}
		
		// stop if not a valid dir
		if ( !is_dir( $params->get('base_dir').$folder ) || strstr($folder, DS.(self::thumbnail_folder)) )
			return $files;
				
		$d = dir( $params->get('base_dir').$folder );

		if (!$d)
			return $files;
				
		$nocheck = ( $max_files == -1 );

		while ( false !== (($x = $d->read()) && ($nocheck || count($files) < $max_files)) )
		{
			if ( $x == '.' || $x == '..' || $x == self::thumbnail_folder)
				continue;
				
			if (is_dir($params->get('base_dir').$folder.DS.$x) )
			{
				if (!$recursive)
					continue;
				
				if ($files_only)	
					$files = array_merge($files, self::get_files($folder.DS.$x, $recursive, $files_only, $max_files));
				else
				{
					$cache = self::read_thumb_cache( $folder.DS.$x );
					
					// check if everything was read correctly
					$valid_cache = self::thumb_cache_is_valid( $cache, $x );
					
					if ( $params->get('debug') && !$valid_cache)
					{
						echo "Invalid cache found in folder ".$folder.DS.$x."! <br />\n";
					}
					
					if (!$valid_cache)					
					{
						$folder_files = self::get_files($folder.DS.$x, false, true);
						$folder_files_recursive = self::get_files($folder.DS.$x, true, true);

						$img_cnt = count($folder_files_recursive);
					} else
						$img_cnt = $cache->img_cnt;
					
					// skip empty folders if not in edit mode
					if (!$params->get('editmode') && ($img_cnt == 0) )
						continue;
					
					$entry = new <%= _.slugify(componentName) %>Entry();
					$entry->folder = $folder;
					$entry->name = $x;
					$entry->type = 'FOLDER';
					$entry->img_cnt = $img_cnt;

					if (!$valid_cache)					
					{
						//prefer folder thumbs from current directory
						if (count($folder_files) > 0)
							$entry->tn = self::get_thumbs_str( $folder_files );
						else
							$entry->tn = self::get_thumbs_str( $folder_files_recursive );
					} else 
						$entry->tn = $cache->tn;
							
					// write cache
					if (!$valid_cache)					
						self::write_thumb_cache($folder.DS.$x, $entry);
				}
			} else {
				// add files with valid extension
				if ( !in_array( strtolower(pathinfo($x, PATHINFO_EXTENSION)), self::supported_extensions()) )
					continue;

				$entry = new <%= _.slugify(componentName) %>Entry();
				$entry->folder = $folder;
				$entry->name = $x;
				$entry->type = 'FILE';
				$entry->img_cnt = 1;
				
				if (!$files_only)
					$entry->tn = self::get_thumbs_str( array ( $entry ) );
			}
			
			if (isset($entry))
				$files[] = $entry;

		}
		$d->close();
		
		if ( $params->get('sort') == 'asc')
			usort($files, "<%= _.slugify(componentName) %>Entry::__sort_asc");
		elseif ( $params->get('sort') == 'desc')
			usort($files, "<%= _.slugify(componentName) %>Entry::__sort_desc");
		elseif ( $params->get('sort') == 'folder_desc')
			usort($files, "<%= _.slugify(componentName) %>Entry::__sort_folder_desc");

		return $files;
	}
	
	function create_image( $source_file, $new_file, $new_width = 0, $new_height = 0)
	{
		$params =& JComponentHelper::getParams('com_<%= _.slugify(componentName) %>');

		$image_info = @getImageSize( $source_file );

		// read the mime type
		switch ( $image_info['mime'] )
		{
			case 'image/pjpeg':
			case 'image/jpeg':
			case 'image/jpg':
				$type = 'jpg';
				break;

			case 'image/gif':
				$type = 'gif';
				break;

			case 'image/x-png':
			case 'image/png':
				$type = 'png';
				break;

			default:
				return;
				break;
		}
		
		// read the dimensions
		list($width, $height) = $image_info;

		// verify if dimensions are valid
		if ( ($width == 0) || ($height == 0) )
			return;
			
		if ($new_width == 0)
			$new_width = $width;

		if ($new_height == 0)
			$new_height = $height;
			
		// switch new width & height if orientation does not follow original
		if ( (($width < $height) && ($new_width > $new_height)) || (($width > $height) && ($new_width < $new_height)) )
		{
			$x = $new_width;
			$new_width = $new_height;
			$new_height = $x;
		}

		// maximise new dimensionsions as set in config
		if (($params->get('imgsize_max_width') > 0) && ($params->get('imgsize_max_height') > 0))
		{
			if ( ($new_width >= $new_height) && ($new_width > $params->get('imgsize_max_width') || $new_height > $params->get('imgsize_max_height')) )
			{
				// maximise for landscape orientation
				$new_width = $params->get('imgsize_max_width');
				$new_height = $params->get('imgsize_max_height');
			}
			elseif ( ($new_width < $new_height) && ($new_width > $params->get('imgsize_max_height')) || ($new_height > $params->get('imgsize_max_width')) )
			{
				// maximise for portrait orientation
				$new_height = $params->get('imgsize_max_width');
				$new_width = $params->get('imgsize_max_height');
			}
		}

		// fix aspect ratio to match original
		if(( $new_width / $new_height ) > ( $width / $height ))
			$new_width = $width * ($new_height / $height);
		else
			$new_height = $height * ($new_width / $width);

		// do not enlarge images...
		if ( ($width <= $new_width) && ($height <= $new_height) )
		{
			$new_width = $width;
			$new_height = $height;
		}

		$img = imagecreatetruecolor($new_width, $new_height);

		if ($type == 'jpg')
			$source = @imageCreateFromJPEG($source_file);
		elseif ($type == 'gif')
			$source = @imageCreateFromGIF($source_file);
		elseif ($type == 'png')
			$source = @imageCreateFromPNG($source_file);

		// something's wrong if no source image
		if (!$source)
			return;

		// Image transparency
		if (($type == 'gif') || ($type == 'png'))
		{
			// Read transparent color
			$trnprt_indx = imagecolortransparent($source);

			if ($trnprt_indx >= 0)
			{
				// Read original transparent color & alocate in new image resource
				$rgb = imagecolorsforindex($source, $trnprt_indx);
				$color = imagecolorallocate($img, $rgb['red'], $rgb['green'], $rgb['blue']);

				// Fill background of thumb & set transparant color
				imagefill($img, 0, 0, $color);
				imagecolortransparent($img, $color);
			}
			elseif ($type == 'png')
			{   // For PNG's: Always make a transparent background color
				
				// Turn off alpha blending and set alpha flag
				imagealphablending($img, false);
				imagesavealpha($img, true);

				// Create new transparent color & fill background
				$color = imagecolorallocatealpha($img, 0, 0, 0, 127);
				imagefill($img, 0, 0, $color);
			}
		}
		
		if ( ($width == $new_width) && ($height == $new_height) )
		{
			// no resize required - simply copy image
			imagecopy($img, $source, 0, 0, 0, 0, $width, $height);
		}
		else
		{
			// fill the image with the resized original
			switch ($params->get('img_resizemethod'))
			{
				case 1:  // method = 1, use imagecopyresized
					imagecopyresized($img, $source, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
					break;
				
				case 2: // method = 2, use imagecopyresampled
					imagecopyresampled($img, $source, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
					break;
				
				case 0:
				default: // method = 0 (auto)
					if ($type == 'gif')
						imagecopyresized($img, $source, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
					else
						imagecopyresampled($img, $source, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
					break;
				
			}
		}

		// save the image
		if ($type == 'jpg')
			imagejpeg($img, $new_file);
		elseif ($type == 'gif')
			imagegif($img, $new_file);
		elseif ($type == 'png')
			imagepng($img, $new_file);
		
		// free memory used by image
		imagedestroy( $img );

		return;
	}
	
	function get_thumbs_str( $files )
	{
		$params =& JComponentHelper::getParams('com_<%= _.slugify(componentName) %>');
		
		$default_ratio = $params->get('imgsize_default_width') / $params->get('imgsize_default_height');

		$tn1 = array();
		$tn2 = array();
		$tn4 = array();
		
		foreach ($files as $file)
		{
			if ((count($tn4) == 4) || (count($tn2) == 2))
				break;

			$f = $file->folder.DS.(self::thumbname( $file->name, 'small' ));

			// read the dimensions
			list($width, $height) = @getImageSize( $params->get('base_dir').$f );
			$ratio = $width / $height;
			
			// only if picture is wider than standard thumbnail, we don't use full height
			if (($ratio >= 1) && ($ratio >= $default_ratio))
			{
				// (160 x 120, ratio : 1,33) --> (1024 x 600, ratio: 1,71) --> height = 160 / 1,71 = 94
				$t_width = $params->get('imgsize_default_width') / $params->get('img_thumbfactor');
				$t_height = $t_width / $ratio;
			}
			else
			{
				// (160 x 120, ratio : 1,33) --> (1024 x 800, ratio: 1,28) --> width = 120 * 1,28 = 153
				// (120 x 160, ratio : 0,75) --> (800 x 1024, ratio: 0,78) --> width = 120 * 0,78 = 93
				// (120 x 160, ratio : 0,75) --> (600 x 1024, ratio: 0,58) --> width = 120 * 0,58 = 70
				$t_height = $params->get('imgsize_default_height') / $params->get('img_thumbfactor');
				$t_width = $t_height * $ratio;
			}
						
			if (count($tn1) == 0)
				$tn1[] = <%= _.str.capitalize(_.slugify(componentName)) %>HTML::imgURL( $f, $t_width, $t_height );
			
			if ($ratio >= 1)
				$tn4[] = <%= _.str.capitalize(_.slugify(componentName)) %>HTML::imgURL( $f, $t_width/2, $t_height/2, ((count($tn4) < 2)?'bottom':'top') );
			else
			{
				$max_t_width = ($params->get('imgsize_default_width') / $params->get('img_thumbfactor')) / 2;
				// fix for portrait img that takes more than 50% of standard thumbnail width
				if ($t_width > $max_t_width)
				{
					// (120 x 160, ratio : 0,75) --> (800 x 1024, ratio: 0,78) --> width = 120 * 0,78 = 93 (doesn't fit, limit to 50%)
					//                                                         --> height = 80 / 0,78 = 102 (new height)
					$t_width = $max_t_width;
					$t_height = $t_width  / $ratio;
				}

				$tn2[] = <%= _.str.capitalize(_.slugify(componentName)) %>HTML::imgURL( $f, $t_width, $t_height );
			}
			
//			echo $f." --> Original size: (".$width.", ".$height.")"." --> Thumb size: (".$t_width.", ".$t_height.")"."<br />\n";
		}

		if (count($tn4) == 4)
			return $tn4[0].$tn4[1].'<br />'.$tn4[2].$tn4[3];
		elseif (count($tn2) == 2)
			return $tn2[0].$tn2[1];
		elseif (count($tn1) == 1)
			return $tn1[0];
		else
			return <%= _.str.capitalize(_.slugify(componentName)) %>HTML::imgURL( '', $params->get('imgsize_default_width')/ $params->get('img_thumbfactor'), $params->get('imgsize_default_height')/ $params->get('img_thumbfactor') );
	}
}

class <%= _.str.capitalize(_.slugify(componentName)) %>HTML
{

	function URL( $task, $target, $item = null )
	{
		$params =& JComponentHelper::getParams('com_<%= _.slugify(componentName) %>');
		
		if (!isset($task) || $task == '')
			$task = 'show';
			
		$target = ($target == '')?'|':str_replace(DS, '|', $target);
		
		if ( !$params->get('is_admin') )
			return JRoute::_( <%= _.str.capitalize(_.slugify(componentName)) %>HelperRoute::getGalleryRoute( $task, $target, $item ));
		else
			return 'index.php?option=com_<%= _.slugify(componentName) %>&amp;task='.urlencode($task).'&amp;target='.urlencode($target).(isset($item)?'&amp;item='.urlencode($item):'');
	}
	
	function imgURL( $url, $width = 0, $height = 0, $valign = 'none' )
	{
		$params =& JComponentHelper::getParams('com_<%= _.slugify(componentName) %>');

		$tag = '<img ';
		$tag .= 'style="border-style: none;';
		
		if ($valign != 'none')
			$tag.= 'vertical-align:text-'.$valign.';';

		// added: fix css overriding inline html width / height attributes
		if (($width > 0) && ($height > 0))
			$tag .= ' width:'.$width.'px; height:'.$height.'px;';
		
		$tag .= '"';

		if (($width > 0) && ($height > 0))
			$tag .= ' width="'.$width.'" height="'.$height.'"';
		
		$tag .= ' src="'.(($url=='')?'no_image':($params->get('base_url').str_replace("\\", '/', $url))).'"';
		$tag .= ' alt="#CAPTION#" />';

		return $tag;
	}

	function header( $target, $filecnt )
	{
		$params =& JComponentHelper::getParams('com_<%= _.slugify(componentName) %>');
		
		if ( is_file($params->get('base_dir').$target) === false )
			$caption = <%= _.str.capitalize(_.slugify(componentName)) %>Util::read_caption(<%= _.str.capitalize(_.slugify(componentName)) %>Util::parent_directory( $target ), pathinfo($target, PATHINFO_BASENAME));
		else
			$caption = str_replace('_', ' ', pathinfo($target, PATHINFO_FILENAME));

		$title = '';

		if (!$params->get('is_admin')) {
			$document = &JFactory::getDocument();
			$menus = &JSite::getMenu();
			$menu = $menus->getActive();
			$title = $menu->title;

			$document->setTitle( $title.((($title!='')&&($caption!=''))?' - ':'').$caption );
			$document->setMetaData('title', $title.((($title!='')&&($caption!=''))?' - ':'').$caption );
		} else {
			$title = JText::_('COM_<%= _.slugify(componentName).toUpperCase() %>');
		}
?>
<table class="<?php echo $params->get('is_admin')?'adminheading':'contentpaneopen'; ?>">
<tr><th class="contentheading" width="100%"><?php echo $title.((($title!='')&&($caption!=''))?': ':'').$caption; ?></th></tr>
</table>

<table width="100%">
<tr>
<td class="links" align="left" valign="middle" width="30%">
<?php // left column : Links ?>
<?php if ($target != '') { ?>
<input type="button" class="btn" value="<?php echo JText::_('COM_<%= _.slugify(componentName).toUpperCase() %>_UP_DIR'); ?>" onclick="window.location.href='<?php echo self::URL( JRequest::getCmd('task'), <%= _.str.capitalize(_.slugify(componentName)) %>Util::parent_directory( $target ) ); ?>'" /><br />
<?php } else { ?>
&nbsp;
<?php } ?>
</td>

<td class="links" align="center" valign="middle" width="40%">
&nbsp;
</td>

<?php // right column : Actions ?>
<td align="right" valign="middle" width="30%">
<?php 		if (!$params->get('is_admin')) { ?>
<form enctype="multipart/form-data" name="settings_form" action="<?php echo self::URL(JRequest::getCmd('task'), $target ); ?>" method="post">
	<input type="hidden" name="usermode" value="" />
<?php if ( ($filecnt > 1) && !$params->get('editmode') && ($params->get('display_javascript') == 'colorbox') ) { // slideshow ?>
	<input type="button" name="slidebtn" class="btn" value="<?php echo JText::_('COM_<%= _.slugify(componentName).toUpperCase() %>_SLIDESHOW'); ?>"  />
	<script type="text/javascript">
	//<![CDATA[
		function slidebtn_onclick() {
			$(".<%= _.slugify(componentName) %>_img").colorbox({slideshow:true}).eq(0).click(); 
		}
		document.settings_form.slidebtn.onclick = slidebtn_onclick;
	//]]>
	</script>
<?php } ?>	
<?php if ( $params->get('can-edit') ) { // Mode button ?>
<input type="submit" name="modebtn" class="btn" value="<?php echo ($params->get('editmode')?JText::_('COM_<%= _.slugify(componentName).toUpperCase() %>_MODE_VIEW'):JText::_('COM_<%= _.slugify(componentName).toUpperCase() %>_MODE_EDIT')); ?>" />&nbsp;&nbsp;&nbsp;
	<script type="text/javascript">
	//<![CDATA[
		var submitted = 0;
		function modebtn_onclick() {
			if (!submitted) {
				document.settings_form.usermode.value = '<?php echo ($params->get('editmode')?'VIEW':'EDIT'); ?>';
				document.settings_form.submit();
				submitted = 1;
			}
			return false;
		}
		document.settings_form.modebtn.onclick = modebtn_onclick;
	//]]>
	</script>
<?php } ?>
<br />
</form>
<?php } else { ?>
&nbsp;
<?php } ?>
</td>
</tr>
</table>
<?php
	}

	function footer( $target, $filecnt )
	{
		$params =& JComponentHelper::getParams('com_<%= _.slugify(componentName) %>');
		
		$basename = pathinfo($target, PATHINFO_BASENAME);
		$fs_item = $params->get('base_dir').$target;
		$target_is_dir = (is_file($params->get('base_dir').$target) === false);
		
		$caption = <%= _.str.capitalize(_.slugify(componentName)) %>Util::read_caption(<%= _.str.capitalize(_.slugify(componentName)) %>Util::parent_directory( $target ), $basename);
		
		// Album Edit Functions
		if ( $params->get('editmode') && file_exists($fs_item) )
		{
?>
<table cellpadding="0" cellspacing="2" border="0" width="100%">	

<?php // TODO: come up with better fix...? ?>
<?php // for admin site output empty form first in case there is a wrapper form, which would ruin our action here... ?>
<?php if ( $params->get('is_admin') ) { ?>
<tr><td height="1" width="100%" align="center">
<form enctype="multipart/form-data" action=""></form>
</td></tr>
<?php } ?>

<?php // display 'change caption' fields if not in root folder ?>
<?php if ( !($target == '') ) { ?>
<tr><td valign="top" align="center" width="100%">
<form enctype="multipart/form-data" action="<?php echo self::URL('savecap', <%= _.str.capitalize(_.slugify(componentName)) %>Util::parent_directory( $target ), $basename ); ?>" method="post">
<br /><?php echo JText::_('COM_<%= _.slugify(componentName).toUpperCase() %>_FOLDER_NAME'); ?><br />
<?php if ( $target_is_dir ) { ?>
<input type="text" class="txt" name="caption" size="40" maxlength="80" value="<?php echo $caption; ?>" />&nbsp;
<?php } else { ?>
<textarea cols="60" rows="2" name="caption"><?php echo $caption; ?></textarea><br />
<?php } ?>
<input type="submit" class="btn" value="<?php echo JText::_('COM_<%= _.slugify(componentName).toUpperCase() %>_CAPTION_SAVE'); ?>" />
</form>
</td></tr>
<?php } ?>

<?php // show create new folder button ?>
<?php if ( $target_is_dir ) { ?>
<tr><td height="1" width="100%" align="center">
<form enctype="multipart/form-data" name="create_form" action="<?php echo self::URL( 'create', $target ); ?>" method="post">
<?php if ( $target != '' ) echo JText::_('COM_<%= _.slugify(componentName).toUpperCase() %>_CAT_OR_YEAR').': '.$target.'<br />'; ?>&nbsp;&nbsp;
<input type="text" class="txt" name="item" size="40" maxlength="80" />&nbsp;
<input type="submit" name="createbtn" class="btn" value="<?php echo ( $target != '' )?JText::_('COM_<%= _.slugify(componentName).toUpperCase() %>_NEW_ALBUM'):JText::_('COM_<%= _.slugify(componentName).toUpperCase() %>_NEW_CAT_OR_YEAR'); ?>" />
<?php if ( !$params->get('is_admin')) { ?>
<script type="text/javascript">
//<![CDATA[
	function createbtn_onclick() {
		if ( document.create_form.item.value != "" ) {
			document.create_form.submit();
		} else {
			alert('<?php echo JText::_('COM_<%= _.slugify(componentName).toUpperCase() %>_CREATE_INVALID_FILENAME'); ?>');
		}
		return false;
	}
	document.create_form.createbtn.onclick = createbtn_onclick;
//]]>
</script>
<?php } ?>
</form>
</td></tr>
<?php } ?>

<?php
	// show file upload components 
	if ( $params->get('editmode') && $target_is_dir && file_exists($fs_item) && is_writable($fs_item) && ($target != '') ) {
		$post_max = ini_get('post_max_size');
		$upload_max = ini_get('upload_max_filesize');
		$site_max = ( <%= _.str.capitalize(_.slugify(componentName)) %>Util::php_ini_to_bytes($post_max) < <%= _.str.capitalize(_.slugify(componentName)) %>Util::php_ini_to_bytes($upload_max) )?$post_max:$upload_max;
		$supported_ext = <%= _.str.capitalize(_.slugify(componentName)) %>Util::supported_extensions();
		$supported_ext[] = 'zip';
		
?>			
<tr><td height="1" width="100%" align="center">
<form enctype="multipart/form-data" name="upload_form" action="<?php echo self::URL( 'upload', $target ); ?>" method="post">
<?php echo JText::_('COM_<%= _.slugify(componentName).toUpperCase() %>_UPLOAD_FILE').': '.$target; ?>&nbsp;(type=<?php echo implode(',', $supported_ext); ?> max=<?php echo $site_max; ?>B)<br />&nbsp;&nbsp;
<input type="hidden" name="MAX_FILE_SIZE" value="<?php echo <%= _.str.capitalize(_.slugify(componentName)) %>Util::php_ini_to_bytes($site_max); ?>" />
<input type="file" name="PicFile" class="file" size="40" />&nbsp;
<input type="submit" name="uploadbtn" class="btn" value="<?php echo JText::_('COM_<%= _.slugify(componentName).toUpperCase() %>_UPLOAD_BUTTON'); ?>" />
<br /><div id="uploadText" style="display:none;"><?php echo JText::_('COM_<%= _.slugify(componentName).toUpperCase() %>_UPLOAD_STARTED'); ?>&nbsp;</div>

<?php if ($params->get('upload_javascript')) { ?>
<script type="text/javascript">
//<![CDATA[
	function uploadbtn_onclick() {
		ext_ok = false;
		filename = document.upload_form.PicFile.value.toLowerCase();
<?php
foreach ($supported_ext as $e)
	echo '        ext_ok = ext_ok || (filename.lastIndexOf(".'.$e.'") != -1);'."\n";
?>
		if (ext_ok) {
		    document.getElementById('uploadText').style.display = "block";
			document.upload_form.uploadbtn.disabled=true;
			document.upload_form.submit();
		} else {
			alert('<?php echo JText::_('COM_<%= _.slugify(componentName).toUpperCase() %>_UPLOAD_UNSUPPORTED_EXTENSION'); ?>');
		}
		return false;
	}
	document.upload_form.uploadbtn.onclick = uploadbtn_onclick;
//]]>
</script>
<?php } ?>
</form>
</td></tr>
<?php } ?>

<?php // show delete button ?>
<?php if ( $params->get('editmode') && <%= _.str.capitalize(_.slugify(componentName)) %>Util::allow_delete($target) ) { ?>
<tr><td height="1" width="100%" align="center">
<form enctype="multipart/form-data" action="<?php echo self::URL( 'delete', <%= _.str.capitalize(_.slugify(componentName)) %>Util::parent_directory( $target ) ); ?>" method="post">
<input type="hidden" name="item" value="<?php echo $basename; ?>" />
<input type="button" class="btn" value="<?php echo JText::_('COM_<%= _.slugify(componentName).toUpperCase() %>_DELETE'); ?>" onclick="javascript:if(confirm('<?php echo JText::_('COM_<%= _.slugify(componentName).toUpperCase() %>_DELETE').' '.str_replace('_', ' ', ($target_is_dir?$basename:pathinfo($target, PATHINFO_FILENAME))); ?>?')){ submit(); }" />
</form>
</td></tr>
<?php } ?>

<?php // show purge cache button ?>
<?php if ( $params->get('is_admin') ) { ?>
<tr><td height="1" width="100%" align="center">
<form enctype="multipart/form-data" action="<?php echo self::URL( 'purgecache', $target ); ?>" method="post">
<input type="submit" name="purgebtn" class="btn" value="<?php echo JText::_('COM_<%= _.slugify(componentName).toUpperCase() %>_PURGE_CACHE'); ?>" />
</form>
</td></tr>
<?php } ?>


</table>
		
<?php
		}
?>
<br /><br />
<?php
		if ($params->get('debug') && $params->get('editmode'))
		{
?>
<table width="500" border="0" cellspacing="0" cellpadding="2">

<tr><th style="background-color: #DDDDDD;" colspan="2">Album Configuration</th></tr>
<tr><td style="text-align:left;">Image Folder               </td><td style="text-align:left;"><?php echo $params->get('img_dir'); ?></td></tr>
<tr><td style="text-align:left;">Base Folder                </td><td style="text-align:left;"><?php echo $params->get('base_dir'); ?></td></tr>
<tr><td style="text-align:left;">Base URL                   </td><td style="text-align:left;"><?php echo $params->get('base_url'); ?></td></tr>
<tr><td style="text-align:left;">Thumbnail Cache for Folders</td><td style="text-align:left;"><?php echo ($params->get('folder_cache')?'Enabled':'Disabled'); ?></td></tr>
<tr><td style="text-align:left;">Create Folder Permissions  </td><td style="text-align:left;"><?php echo $params->get('folder_permissions'); ?></td></tr>
<tr><td style="text-align:left;">Maximum Execution Time     </td><td style="text-align:left;"><?php echo $params->get('max_exec_time'); ?></td></tr>
<tr><td style="text-align:left;">Enable Upload Javascript   </td><td style="text-align:left;"><?php echo $params->get('upload_javascript'); ?></td></tr>
<tr><td style="text-align:left;">Image Resize Method        </td><td style="text-align:left;"><?php echo (($params->get('img_resizemethod') == 1)?'Copy Resized':(($params->get('img_resizemethod') == 2)?'Copy Resampled':'Auto')); ?></td></tr>
<tr><td style="text-align:left;">Thumbnail Size Factor      </td><td style="text-align:left;"><?php echo $params->get('img_thumbfactor'); ?></td></tr>
<tr><td style="text-align:left;">Image Default Size         </td><td style="text-align:left;"><?php echo '('.$params->get('imgsize_default_width').', '.$params->get('imgsize_default_height').')'; ?></td></tr>
<tr><td style="text-align:left;">Image Maximum Size         </td><td style="text-align:left;"><?php echo '('.$params->get('imgsize_max_width').', '.$params->get('imgsize_max_height').')'; ?></td></tr>
<tr><td style="text-align:left;">Thumbnail spacing          </td><td style="text-align:left;"><?php echo '('.$params->get('spacing_horizontal').', '.$params->get('spacing_vertical').')'; ?></td></tr>
<tr><td style="text-align:left;">Component Debugging        </td><td style="text-align:left;"><?php echo ($params->get('debug')?'Enabled':'Disabled'); ?></td></tr>
<tr><td colspan=2>&nbsp;</td></tr>

<tr><th style="background-color: #DDDDDD;" colspan="2">Album Status</th></tr>
<tr><td style="text-align:left;">View                </td><td style="text-align:left;"><?php echo JRequest::getCmd('view', 'gallery'); ?></td></tr>
<tr><td style="text-align:left;">Task                </td><td style="text-align:left;"><?php echo JRequest::getCmd('task', 'show'); ?></td></tr>
<tr><td style="text-align:left;">Can Edit            </td><td style="text-align:left;"><?php echo ($params->get('can-edit')?'Yes':'No'); ?></td></tr>
<tr><td style="text-align:left;">Can Delete          </td><td style="text-align:left;"><?php echo ($params->get('can-delete')?'Yes':'No'); ?></td></tr>
<tr><td style="text-align:left;">Editmode            </td><td style="text-align:left;"><?php echo ($params->get('editmode')?'Enabled':'Disabled'); ?></td></tr>
<tr><td style="text-align:left;">Item                </td><td style="text-align:left;"><?php echo JRequest::getString('item'); ?></td></tr>
<tr><td style="text-align:left;">Is Admin            </td><td style="text-align:left;"><?php echo ($params->get('is_admin')?'Yes':'No'); ?></td></tr>
<tr><td style="text-align:left;">Target              </td><td style="text-align:left;"><?php echo $target; ?></td></tr>
<tr><td style="text-align:left;">Target is Directory </td><td style="text-align:left;"><?php echo ($target_is_dir?'Yes':'No'); ?></td></tr>
<tr><td style="text-align:left;">Parent Folder       </td><td style="text-align:left;"><?php echo <%= _.str.capitalize(_.slugify(componentName)) %>Util::parent_directory( $target ); ?></td></tr>
<tr><td style="text-align:left;">Cache present       </td><td style="text-align:left;"><?php echo (<%= _.str.capitalize(_.slugify(componentName)) %>Util::thumb_cache_is_valid( <%= _.str.capitalize(_.slugify(componentName)) %>Util::read_thumb_cache( $target), pathinfo($target, PATHINFO_BASENAME) )?'Yes':'No'); ?></td></tr>
</table>
<br />
<?php
		}
	}

	function showAlbum( $files, $target )
	{
		$params =& JComponentHelper::getParams('com_<%= _.slugify(componentName) %>');

		$target_is_dir = (is_file($params->get('base_dir').$target) === false);

		if ( !$target_is_dir && (count($files) == 1) && ($files[0]->type != 'FOLDER') )
			self::showImage( $files[0], $target );
		else
			self::showList( $files, $target );
	}
	
	protected function showList( $files, $target )
	{
		$params =& JComponentHelper::getParams('com_<%= _.slugify(componentName) %>');

		$up_dir = <%= _.str.capitalize(_.slugify(componentName)) %>Util::parent_directory($target);

		if ( !$params->get('is_admin') && !$params->get('editmode') && ($params->get('display_javascript') == 'colorbox') )
		{
			// colorbox 1.4.26
			$document = &JFactory::getDocument();
			$document->addStyleSheet(JURI::base(true).'/components/com_<%= _.slugify(componentName) %>/lib/colorbox-1.4.26/colorbox-1.4.26.css');
			$document->addScript('https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js');
			$document->addScript(JURI::base(true).'/components/com_<%= _.slugify(componentName) %>/lib/colorbox-1.4.26/jquery.colorbox-min.js');

			$document->addCustomTag('<script type="text/javascript">
		$(document).ready(function(){
			$(".<%= _.slugify(componentName) %>_img").colorbox({
						rel:"<%= _.slugify(componentName) %>",
						slideshowSpeed:"3000",
						slideshowStart:"'.JText::_('COM_<%= _.slugify(componentName).toUpperCase() %>_START_SLIDESHOW').'",
						slideshowStop:"'.JText::_('COM_<%= _.slugify(componentName).toUpperCase() %>_STOP_SLIDESHOW').'",
						current:"  '.str_replace('$nbsp;', ' ', JText::_('COM_<%= _.slugify(componentName).toUpperCase() %>_IMAGE')).' {current} / {total}",
						previous:"'.str_replace('$nbsp;', ' ', JText::_('COM_<%= _.slugify(componentName).toUpperCase() %>_PREVIOUS_IMAGE')).'",
						next:"'.str_replace('$nbsp;', ' ', JText::_('COM_<%= _.slugify(componentName).toUpperCase() %>_NEXT_IMAGE')).'",
						close:"'.str_replace('$nbsp;', ' ', JText::_('COM_<%= _.slugify(componentName).toUpperCase() %>_IMAGE_CLOSE')).'",
						onClosed:function(){ $(".<%= _.slugify(componentName) %>_img").colorbox({slideshow:false}); }
				});
		});
</script>');
		}
		elseif ( !$params->get('is_admin') && !$params->get('editmode') && ($params->get('display_javascript') == 'fancybox') )
		{
			// fancybox 2.1.5
			$document = &JFactory::getDocument();
			$document->addStyleSheet(JURI::base(true).'/components/com_<%= _.slugify(componentName) %>/lib/fancybox-2.1.5/jquery.fancybox-2.1.5.css');
			$document->addScript('https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js');
			$document->addScript(JURI::base(true).'/components/com_<%= _.slugify(componentName) %>/lib/fancybox-2.1.5/jquery.fancybox.min.js');

			$document->addCustomTag('<script type="text/javascript">
		$(document).ready(function() {
			$(".<%= _.slugify(componentName) %>_img").fancybox({
				openEffect: "none",
				closeEffect: "none",
				prevEffect: "none",
				nextEffect: "none",
				helpers: { title: { type: "inside" } },
				afterLoad: function() { this.title = "'.str_replace('$nbsp;', ' ', JText::_('COM_<%= _.slugify(componentName).toUpperCase() %>_IMAGE')).' " + (this.index + 1) + " / " + this.group.length + (this.title ? " - " + this.title : ""); }
			});
		});
</script>');
		}
		
		if (count($files) == 0) {
?>
<table cellpadding="0" cellspacing="2" border="0" width="100%">
<tr>
<td><br /><?php echo ($up_dir == '')?JText::_('COM_<%= _.slugify(componentName).toUpperCase() %>_CAT_EMPTY'):JText::_('COM_<%= _.slugify(componentName).toUpperCase() %>_ALBUM_EMPTY'); ?><br /></td>
</tr>
</table>
<?php
		} else {
			$hide_captions = ( !<%= _.str.capitalize(_.slugify(componentName)) %>Util::has_folders( $target ) && $params->get('img_hide_caption'));
						
			$t_width = $params->get('imgsize_default_width') / $params->get('img_thumbfactor');
			$t_height = $params->get('imgsize_default_height') / $params->get('img_thumbfactor');

			$tile_width = $t_width + 3 + $params->get('spacing_horizontal');
			$tile_height = $t_height + 3 + ($hide_captions?$params->get('spacing_vertical_img_only'):$params->get('spacing_vertical'));

			if ($params->get('debug') && $params->get('editmode'))
				echo '<style type="text/css"> .<%= _.slugify(componentName) %>_imagediv { background-color: lightgray; } .<%= _.slugify(componentName) %>_imagediv_minheight, .<%= _.slugify(componentName) %>_imagediv_clear { background-color: coral; }</style>'."\n";

			echo '<center><div style="width:95%;">'."\n";
			foreach ($files as $f)
			{
				echo '<div class="<%= _.slugify(componentName) %>_imagediv" style="float:left; text-align:center; width:'.$tile_width.'px;">';
				echo '<div class="<%= _.slugify(componentName) %>_imagediv_minheight" style="float:right; width:1px; height:'.$tile_height.'px;"></div>';

				if ($f->type == 'FOLDER')
					$caption = <%= _.str.capitalize(_.slugify(componentName)) %>Util::read_caption($target, $f->name);
				else {
					$caption = str_replace('_', ' ', pathinfo($f->name, PATHINFO_FILENAME));
					$desc = <%= _.str.capitalize(_.slugify(componentName)) %>Util::read_caption($target, $f->name);
					
					if ( ($caption == $desc) || ($desc == '') )
						$desc = $caption;
					else
						$desc = $caption.' &ndash; '.$desc;
				}

				if ($f->type != 'FOLDER' && !$params->get('is_admin') && !$params->get('editmode') && ($params->get('display_javascript')!='none') )
					echo '<a class="<%= _.slugify(componentName) %>_img" '.(($params->get('display_javascript') == 'fancybox')?'data-fancybox-group="<%= _.slugify(componentName) %>_img" ':'').'href="'.$params->get('base_url').$target.DS.(<%= _.str.capitalize(_.slugify(componentName)) %>Util::thumbname( $f->name, 'medium' )).'" title="'.$desc.'">';
				else
					echo '<a style="display: block; text-align: center;" href="'.self::URL(JRequest::getCmd('task'), $target.DS.$f->name ).'">';


				echo str_replace('#CAPTION#', $caption, $f->tn);

				if (!$hide_captions)
					echo '<br />'.$caption;
					
				echo '</a>';
				
				if ($f->type == 'FOLDER')
					echo $f->img_cnt.'&nbsp;'.JText::_('COM_<%= _.slugify(componentName).toUpperCase() %>_IMAGES');

				echo '<div class="<%= _.slugify(componentName) %>_imagediv_clear" style="clear:both; overflow:hidden; height:1px;"></div>';
				echo '</div>'."\n";
			}
			echo '</div></center>';
			echo '<div style="clear:both;"></div>'."\n";
		}
	}
	
	protected function showImage( $file, $target )
	{
		$params =& JComponentHelper::getParams('com_<%= _.slugify(componentName) %>');

		$up_dir = <%= _.str.capitalize(_.slugify(componentName)) %>Util::parent_directory($target);
		$caption = <%= _.str.capitalize(_.slugify(componentName)) %>Util::read_caption($target, $file->name);
		$style = 'style="border-style: none"';

		$files = <%= _.str.capitalize(_.slugify(componentName)) %>Util::get_files($up_dir, false, true);
		
		$cnt = count($files);
		for($x=0; $x<$cnt; $x++)
		{
			if ($files[$x]->name == $file->name)
			{
				if ($cnt > 1)
					$next = ($x == $cnt - 1) ? $files[0] : $files[$x + 1];
				if ($cnt > 2)
					$prev = ($x == 0) ? $files[$cnt - 1] : $files[$x - 1];
				$nr_of = ($x + 1) . "&nbsp;/&nbsp;" . $cnt;
				break;
			}
		}

		$t_width = $params->get('imgsize_default_width') / $params->get('img_thumbfactor');
		$t_height = $params->get('imgsize_default_height') / $params->get('img_thumbfactor');
		
?>
<table border="0" width="100%" cellpadding="0" cellspacing="2">
<tr>
<td colspan="3" align="center" valign="middle">
<a href="<?php echo $params->get('base_url').$up_dir.DS.$file->name; ?>" target="_blank">
<?php echo self::imgURL( $up_dir.DS.(<%= _.str.capitalize(_.slugify(componentName)) %>Util::thumbname( $file->name, 'medium' )), pathinfo($file->name, PATHINFO_FILENAME) ); ?>
<br /><?php echo str_replace('_', ' ', pathinfo($file->name, PATHINFO_FILENAME)); ?>
</a><br />
<?php echo ($caption != '')?'<p>'.$caption.'</p><br />':''; ?>
</td>
</tr>

<tr><td colspan="3">&nbsp;</td></tr>

<tr>
<td align="center" valign="middle">
<center>
<div style="width:<?php echo $t_width+11; ?>px;">
<?php if ( isset($prev) ) { ?>
<a href="<?php echo self::URL(JRequest::getCmd('task'), $up_dir.DS.$prev->name ); ?>">
<?php echo JText::_('COM_<%= _.slugify(componentName).toUpperCase() %>_PREVIOUS_IMAGE'); ?>:<br />
<?php echo self::imgURL( $up_dir.DS.(<%= _.str.capitalize(_.slugify(componentName)) %>Util::thumbname( $prev->name, 'small' )), pathinfo($prev->name, PATHINFO_FILENAME) ); ?>
</a>
<?php } else { ?>
&nbsp;
<?php } ?>
</div>
</center>
</td>

<td align="center" valign="middle">
<br /><?php echo JText::_('COM_<%= _.slugify(componentName).toUpperCase() %>_IMAGE').'&nbsp;'.$nr_of; ?><br /><br />&nbsp;
</td>

<td align="center" valign="middle">
<center>
<div style="width:<?php echo $t_width+11; ?>px;">
<?php if ( isset($next) ) { ?>
<a href="<?php echo self::URL(JRequest::getCmd('task'), $up_dir.DS.$next->name); ?>">
<?php echo JText::_('COM_<%= _.slugify(componentName).toUpperCase() %>_NEXT_IMAGE'); ?>:<br />
<?php echo self::imgURL( $up_dir.DS.(<%= _.str.capitalize(_.slugify(componentName)) %>Util::thumbname( $next->name, 'small' )), pathinfo($next->name, PATHINFO_FILENAME) ); ?>
</a>
<?php } else { ?>
&nbsp;
<?php } ?>
</div>
</center>
</td>
</tr>
</table>
<?php
	}
}

class <%= _.str.capitalize(_.slugify(componentName)) %>Entry
{
	public $name;
	public $type;
	public $folder;
	public $img_cnt;
	public $tn;

	function __sort_asc($a, $b) { return (($a->type == $b->type)?strcasecmp($a->name, $b->name):$a->type!='FOLDER'); } 
	function __sort_desc($a, $b) { return (($a->type == $b->type)?strcasecmp($b->name, $a->name):$a->type!='FOLDER'); } 
	function __sort_folder_desc($a, $b) { return (($a->type == $b->type)?(($a->type != 'FOLDER')?strcasecmp($a->name, $b->name):strcasecmp($b->name, $a->name)):$a->type!='FOLDER');
}

}

/* *** ideas ***
// -  Implement time stats in debug
//
// -  Enable multiple root-dirs + select root in menu item
//
// -  Add backend function to resize all images > max image size
//
// -  Add upload progress bar
//
// -  Allow multi-select & delete / download
//
// -  Registration of Hits
//
// -  EXIF data
//    $exif = exif_read_data($dir.$basename, 0, true);
//    if ($exif)
//      foreach ($exif as $key => $section) {
//        foreach ($section as $name => $val)
//          echo "$key.$name: $val<br />\n";
//      }
//
// -  Enable users to change the file captions that are displayed (i.e. be able to update the file names)
//
// -  Add reflection effect to thumbnails
//    $src_height = imagesy($src_img);
//    $src_width = imagesx($src_img);
//    $dest_height = $src_height + ($src_height / 2);
//    $dest_width = $src_width;
//    $reflected = imagecreatetruecolor($dest_width, $dest_height);
//    imagealphablending($reflected, false);
//    imagesavealpha($reflected, true);
//    imagecopy($reflected, $src_img, 0, 0, 0, 0, $src_width, $src_height);
//    $reflection_height = $src_height / 2;    // the reflection area... 
//    $alpha_step = 80 / $reflection_height;   // 80 is the transparency start value
//    for ($y = 1; $y <= $reflection_height; $y++)
//    {
//       for ($x = 0; $x < $dest_width; $x++)
//       {
//          // copy pixel from x / $src_height - y to x / $src_height + y
//          $rgba = imagecolorat($src_img, $x, $src_height - $y);
//          $alpha = ($rgba & 0x7F000000) >> 24;
//          $alpha = max($alpha, 47 + ($y * $alpha_step));
//          $rgba = imagecolorsforindex($src_img, $rgba);
//          $rgba = imagecolorallocatealpha($reflected, $rgba['red'], $rgba['green'], $rgba['blue'], $alpha);
//          imagesetpixel($reflected, $x, $src_height + $y - 1, $rgba);
//       }
//    }
//    return $reflected;
*/
?>