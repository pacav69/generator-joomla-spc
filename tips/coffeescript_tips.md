# Coffeescript tips

## When using generated folder names in coffeescript
Use the following as used in view/index.coffee

		@template "_view.html.php", "views/#{@viewFolderName}/view.html.php"
		@template "_default.php", "views/#{@viewFolderName}/default.php"
		
		which will compile to javascript
		
		this.template('_view.html.php', 'app/admin/' + ("views/" + this.viewFolderName + "/view.html.php"));
        this.template('_default.php', 'app/admin/' + ("views/" + this.viewFolderName + "/default.php"));
        
 
 ## When a coffeescript lint reports an error
 
 ### A line is too long
 add this to the coffeescript file and it will overide the settings
 
	# coffeelint: disable=max_line_length