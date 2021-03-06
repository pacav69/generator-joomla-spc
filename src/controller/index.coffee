###

/*
	generator-joomla-spc

	index.coffee

	@author Sean

	@note Created on 2014-10-03 by PhpStorm
	@note uses Codoc
	@see https://github.com/mklabs/yeoman/wiki/generators coffeescript with yeoman
	@see https://github.com/coffeedoc/codo
###
# coffeelint: disable=max_line_length
(->
  'use strict'
  ControllerGenerator = undefined
  path = undefined
  yeoman = undefined

  extend = (child, parent) ->

    Ctor = ->
      @constructor = child
      return

    for key of parent
      if hasProp.call(parent, key)
        child[key] = parent[key]
    Ctor.prototype = parent.prototype
    child.prototype = new Ctor()
    child.__super__ = parent.prototype
    child

  hasProp = {}.hasOwnProperty
  yeoman = require('yeoman-generator')
  yosay = require('yosay')
  chalk = require('chalk')
  path = require('path')

  ###
  	@class ControllerGenerator sub-generator for joomla component controllers
  ###

  module.exports = ControllerGenerator = ((superClass) ->
    'var ControllerGenerator'

    ControllerGenerator = (args, options, config) ->
      pkg = undefined
      ref = undefined
      ref1 = undefined
      ref2 = undefined
      ref3 = undefined
      ControllerGenerator.__super__.constructor.call this, args, options, config
      pkg = JSON.parse(@readFileAsString(path.join(process.cwd(), './package.json')))
      @componentName = pkg.componentName
      @description = pkg.description
      @requireManageRights = pkg.requireManageRights
      @authorName = if (ref = pkg.author) != null then ref.name else undefined
      @authorEmail = if (ref1 = pkg.author) != null then ref1.email else undefined
      @authorURL = if (ref2 = pkg.author) != null then ref2.url else undefined
      @license = if (ref3 = pkg.licenses[0]) != null then ref3.type else undefined
      @currentYear = (new Date()).getFullYear()
      @controllerClassName = @_.classify(@name)
      # @log(yosay(chalk.white('You called the controller subgenerator with the argument ' + this.name + '.\nNow let\'s create that controller ' + this.controllerClassName + '.php for you...')))
      @log ('You called the controller subgenerator with the argument ' + @name + '.\nNow let\'s create that controller ' + @controllerClassName + '.php for you...')
      return

    extend ControllerGenerator, superClass

    ControllerGenerator::generateController = ->
      @template '_controller.php', 'app/admin/' + 'controllers/' + @controllerClassName + '.php'
      @template '_controller.php', 'app/site/' + 'controllers/' + @controllerClassName + '.php'

    ControllerGenerator
  )(yeoman.generators.NamedBase)
  return
).call this
## sourceMappingURL=index.js.map

# ---
# generated by js2coffee 2.1.0