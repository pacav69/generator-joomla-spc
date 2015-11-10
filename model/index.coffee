###
	generator-joomla-component

	index.coffee

	@author Sean Goresht

	@note uses Codoc
	@see https://github.com/mklabs/yeoman/wiki/generators coffeescript with yeoman
	@see https://github.com/coffeedoc/codo
###

"use strict"
yeoman = require("yeoman-generator")
path = require("path")
###
	@class ModelGenerator sub-generator for joomla spc controllers
###
module.exports = class ModelGenerator extends yeoman.generators.NamedBase
	constructor: (args, options, config) ->
		super args, options, config
		pkg = JSON.parse(@readFileAsString(path.join(process.cwd(), "./package.json")))
		@componentName = pkg.componentName
		@description = pkg.description
		@requireManageRights = pkg.requireManageRights
		@authorName = pkg.author?.name
		@authorEmail = pkg.author?.email
		@authorURL = pkg.author?.url
		@license = pkg.licenses[0]?.type
		@currentDate = new Date().getFullYear()
		@modelName = @._.slugify(@name)
		@modelClassName = @._.classify(@name)
		console.log """
			You called the model subgenerator with the argument #{@name}.
			Now let's create that model as models/#{@modelName}.php for you...
		"""
	generateModel: ->
		@template "_model.php", "src/" + "models/#{@modelName}.php"
