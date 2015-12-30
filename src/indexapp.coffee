# global inquirer ###

# global chalk ###

# global yosay ###

# global mkdirp ###

###
    generator-joomla-spc
    v0.1.3
    added selection of component levels basic, intermediate, advanced

    v0.1.2
    added selection of plugin group

###

'use strict'
# coffeelint: disable=max_line_length
(->
  Generator = undefined
  config = undefined
  exec = undefined
  fs = undefined
  path = undefined
  rimraf = undefined
  semver = undefined
  util = undefined
  yeoman = undefined

  # Generator = (args, options) ->

  Generator = () ->
    yeoman.generators.Base.apply this, arguments
    @generator = Object.create(null)
    @sourceRoot path.join(__dirname, 'templates')
    @generator.installDependencies = false

    return

  # 'use strict'
  util = require('util')
  path = require('path')
  fs = require('fs')
  # mkdirp = require('mkdirp');
  yeoman = require('yeoman-generator')
  #globalconfig = require('global-config.js');
  yosay = require('yosay')
  chalk = require('chalk')
  inquirer = require('inquirer')
  ucfirst = require('ucfirst')
  rimraf = require('rimraf')
  exec = require('child_process').exec
  semver = require('semver')
  config = require('../configuserglobal.js')
  module.exports = Generator
  util.inherits Generator, yeoman.generators.NamedBase

  Generator::startGenerator = ->

    @log yosay(chalk.white('Welcome to the SPC Joomla Extension generator!'))
  
    return

  Generator::askForType = ->
    done = @async()
    @prompt {
      type: 'list'
      name: 'type'
      message: 'What type of extension do you want to create?'
      choices: [
        {
          name: 'Component'
          value: 'ext-com'
        }
        {
          name: 'Plug-in'
          value: 'ext-plg'
        }
        {
          name: 'Template Front End'
          value: 'ext-tpl'
        }
        {
          name: 'Template Admin'
          value: 'ext-tpladmin'
        }
        {
          name: 'Module'
          value: 'ext-mod'
        }
      ]
    }, ((typeAnswer) ->
      @generator.type = typeAnswer.type
      # console.log("type = ", this.generator.type)
      done()
      return
    ).bind(this)
    return

  #globalconfig.getall;
  #console.log("got info:", data )

  Generator::getConfig = ->
    cb = undefined
    self = undefined
    cb = @async()
    self = this
    self.configExists = false
    #globalconfig.getall(function (err, data) {
    config.getConfig (err, data) ->
      if !err
        self.configExists = true
      self.defaultAuthorName = data.authorName
      self.defaultAuthorURL = data.authorURL
      self.defaultAuthorEmail = data.authorEmail
      self.latestVersion = data.latestVersion
      cb()
      return
    return

  Generator::askFor = ->
    cb = undefined
    prompts = undefined
    self = undefined
    cb = @async()
    self = this
    switch @generator.type
      when 'ext-com'
        # console.log("in switch", this.generator.type)
        prompts = [
          {
            type: 'list'
            name: 'componentComGroup'
            message: 'What\'s the Component level?'
            choices: [
              {
                name: 'Basic'
                value: 'basic'
              }
              {
                name: 'Intermediate'
                value: 'intermediate'
              }
              {
                name: 'Advanced'
                value: 'advanced'
              }
            ]
          }
          {
            name: 'description'
            message: 'Describe your component'
            'default': 'A sample description'
          }
          {
            name: 'componentName'
            message: 'What\'s the component\'s name?'
            'default': 'defaultcomponentvalue'
          }
          {
            name: 'authorName'
            message: 'What\'s your name?'
            'default': self.defaultAuthorName
          }
          {
            name: 'authorEmail'
            message: 'What\'s your e-mail?'
            'default': self.defaultAuthorEmail
          }
          {
            name: 'authorURL'
            message: 'What\'s your website?'
            'default': self.defaultAuthorURL
          }
          {
            name: 'versionno'
            message: 'What\'s the version number?'
            'default': '1.0.0'
          }
          {
            name: 'license'
            message: 'What\'s the copyright license?'
            'default': 'MIT'
          }
          {
            type: 'confirm'
            name: 'requireManageRights'
            message: 'Does your component require admin manage rights to access it?'
          }
          {
            type: 'confirm'
            name: 'legacyJoomla'
            message: 'Support Joomla 2.5x with compatibility layer?'
          }
        ]
      when 'ext-plg'
        # console.log("in switch", this.generator.type)
        prompts = [
          {
            type: 'list'
            name: 'componentGroup'
            message: 'What\'s the plugin\'s Group?'
            choices: [
              {
                name: 'Content'
                value: 'content'
              }
              {
                name: 'Extension'
                value: 'extension'
              }
              {
                name: 'Authentication'
                value: 'authentication'
              }
              {
                name: 'Captcha'
                value: 'captcha'
              }
              {
                name: 'Editors'
                value: 'editors'
              }
              {
                name: 'Editors-XTD'
                value: 'editors-xtd'
              }
              {
                name: 'Quick-Icons'
                value: 'quick-icons'
              }
              {
                name: 'Search'
                value: 'search'
              }
              {
                name: 'Smart Search (Finder)'
                value: 'smart-search'
              }
              {
                name: 'System'
                value: 'system'
              }
              {
                name: 'Two Factor Auth'
                value: 'twofactorauth'
              }
              {
                name: 'User'
                value: 'user'
              }
            ]
          }
          {
            name: 'description'
            message: 'Describe your plugin'
            'default': 'A sample description'
          }
          {
            name: 'componentName'
            message: 'What\'s the plugin\'s name?'
            'default': 'defaultplugin-value'
          }
          {
            name: 'authorName'
            message: 'What\'s your name?'
            'default': self.defaultAuthorName
          }
          {
            name: 'authorEmail'
            message: 'What\'s your e-mail?'
            'default': self.defaultAuthorEmail
          }
          {
            name: 'authorURL'
            message: 'What\'s your website?'
            'default': self.defaultAuthorURL
          }
          {
            name: 'versionno'
            message: 'What\'s the version number?'
            'default': '1.0.0'
          }
          {
            name: 'license'
            message: 'What\'s the copyright license?'
            'default': 'MIT'
          }
        ]
        # end of prompts
      when 'ext-tpl'
        console.log 'in switch', @generator.type
        prompts = [
          {
            name: 'description'
            message: 'Describe your template'
            'default': 'A sample description'
          }
          {
            name: 'componentName'
            message: 'What\'s the template\'s name?'
            'default': 'default-template-value'
          }
          {
            name: 'authorName'
            message: 'What\'s your name?'
            'default': self.defaultAuthorName
          }
          {
            name: 'authorEmail'
            message: 'What\'s your e-mail?'
            'default': self.defaultAuthorEmail
          }
          {
            name: 'authorURL'
            message: 'What\'s your website?'
            'default': self.defaultAuthorURL
          }
          {
            name: 'versionno'
            message: 'What\'s the version number?'
            'default': '1.0.0'
          }
          {
            name: 'license'
            message: 'What\'s the copyright license?'
            'default': 'MIT'
          }
        ]
      when 'ext-tpladmin'
        console.log 'in switch', @generator.type
        prompts = [
          {
            name: 'description'
            message: 'Describe your Admin template'
            'default': 'A sample description'
          }
          {
            name: 'componentName'
            message: 'What\'s the Admin template\'s name?'
            'default': 'default-Admin-template-value'
          }
          {
            name: 'authorName'
            message: 'What\'s your name?'
            'default': self.defaultAuthorName
          }
          {
            name: 'authorEmail'
            message: 'What\'s your e-mail?'
            'default': self.defaultAuthorEmail
          }
          {
            name: 'authorURL'
            message: 'What\'s your website?'
            'default': self.defaultAuthorURL
          }
          {
            name: 'versionno'
            message: 'What\'s the version number?'
            'default': '1.0.0'
          }
          {
            name: 'license'
            message: 'What\'s the copyright license?'
            'default': 'MIT'
          }
        ]
      when 'ext-mod'
        console.log 'in switch', @generator.type
        prompts = [
          {
            name: 'description'
            message: 'Describe your Module'
            'default': 'A sample description'
          }
          {
            name: 'componentName'
            message: 'What\'s the Module\'s name?'
            'default': 'default-Module-value'
          }
          {
            name: 'authorName'
            message: 'What\'s your name?'
            'default': self.defaultAuthorName
          }
          {
            name: 'authorEmail'
            message: 'What\'s your e-mail?'
            'default': self.defaultAuthorEmail
          }
          {
            name: 'authorURL'
            message: 'What\'s your website?'
            'default': self.defaultAuthorURL
          }
          {
            name: 'versionno'
            message: 'What\'s the version number?'
            'default': '1.0.0'
          }
          {
            name: 'license'
            message: 'What\'s the copyright license?'
            'default': 'MIT'
          }
        ]
      else
        #unknown project type
        break
    @prompt prompts, ((props) ->
      values = undefined
      #var str = props.componentGroup;
      @description = props.description
      @componentName = props.componentName
      @componentGroup = props.componentGroup
      @componentComGroup = props.componentComGroup
      @authorName = props.authorName
      @authorEmail = props.authorEmail
      @authorURL = props.authorURL
      @versionno = props.versionno
      @license = props.license
      @requireManageRights = props.requireManageRights
      @legacyJoomla = props.legacyJoomla
      @currentDate = @_getCurrentDate()
      @currentYear = @_getCurrentYear()
      # Transformations
      # this.data.unprefixedName = nameParts.slice(1).join('_');
      # @nameUppercase = @componentName.toUpperCase()
      #@nameCamelcase = ucfirst(@componentName)
      #@nameLowercase = @componentName.toLowerCase()
      #console.log 'nameUppercase = ', @nameUppercase
      #console.log 'nameCamelcase = ', @nameCamelcase
      #console.log 'nameLowercase = ', @nameLowercase
      if !self.configExists
        values =
          authorName: self.authorName
          authorURL: self.authorURL
          authorEmail: self.authorEmail
          versionno: self.versionno
        config.createConfig values, cb
      else
        cb()
    ).bind(this)
    return

  ###
  #
  #  Write files
  #
  ###

  Generator::writing = ->
    # var this.dest.root = this.destionationroot();
    # var appdir = this.dest.root + '/app';
    @_common()
    @_projectfiles()
    # @_createConfigFiles()
    ###
    # set the template root to templates/[typename]
    ###
    @sourceRoot path.join(__dirname, './templates/' + @generator.type)
    switch @generator.type
      when 'ext-com'
        ###
        # this.generator.installDependencies = true;
        # @generator.installDependencies = true
        ###
        switch @componentComGroup
          when 'basic'
            console.log 'componentComGroup basic'
            @sourceRoot path.join(__dirname, './templates/' + @generator.type + '-' + @componentComGroup)
            # console.log('componentComGroup this.sourceRoot', this.sourceRoot);
            @_wcom()
          when 'intermediate'
            @sourceRoot path.join(__dirname, './templates/' + @generator.type + '-' + @componentComGroup)
            @_wcomInt()
          when 'advanced'
            @sourceRoot path.join(__dirname, './templates/' + @generator.type + '-' + @componentComGroup)
            @_wcomAdv()
          else
            ###
            # unknown project type
            ###
            break
      # break of case: ext-com
      when 'ext-plg'
        @_writingPlg()
        @generator.installDependencies = true
      when 'ext-tpl'
        @_writingTpl()
        @generator.installDependencies = true
      when 'ext-tpladmin'
        @_writingTpladmin()
        @generator.installDependencies = true
      when 'ext-mod'
        @_writingMod()
        @generator.installDependencies = true
      else
        ### unknown project type ###
        break
    return
    ###
    # files for extension type Com - basic
    ###

  Generator::_wcom = ->
    done = @async()
    # var files = this.expandFiles('**', {dot: true, cwd: root});
    console.log '_wcom function'
    # this._createLegacyFallbackFiles();
    @_createEmptyMVCFolders()

    #this.template('_package.json', 'package.json'); // handled in _common
    ###
    # files are located in templates/ext-com-basic
    # Admin files
    ###
    @template 'admin/helpers/_component-name.php', 'app/admin/helpers/' + @_.slugify(@componentName) + '.php'
    @template 'admin/language/en-GB/_en-GB.com_component-name.ini', 'app/admin/' + 'language/en-GB/en-GB.com_' + @_.slugify(@componentName) + '.ini'
    @template 'admin/language/en-GB/_en-GB.com_component-name.sys.ini', 'app/admin/' + 'language/en-GB/en-GB.com_' + @_.slugify(@componentName) + '.sys.ini'
    @template 'admin/libraries/_component-name.php', 'app/admin/libraries/' + @_.slugify(@componentName) + '.php'
    @template 'admin/libraries/_component-name.php', 'app/admin/libraries/' + @_.slugify(@componentName) + '.php'
    @template 'admin/libraries/_ziparchive.php', 'app/admin/libraries/' + 'ziparchive' + '.php'
    @template 'admin/models/_gallery.php', 'app/admin/models/' + 'gallery' + '.php'
    @template 'admin/views/gallery/tmpl/default.php', 'app/admin/views/gallery/tmpl/' + 'default.php'
    @template 'admin/views/gallery/view.html.php', 'app/admin/views/gallery/' + '/view.html.php'
    @template 'admin/_component-name.php', 'app/admin/' + @_.slugify(@componentName) + '.php'
    @template 'admin/_access.xml', 'app/admin/' + 'access.xml'
    @template 'admin/_config.xml', 'app/admin/' + 'config.xml'
    @template 'admin/controller.php', 'app/admin/' + 'controller.php'
    @template 'admin/releasenotes.txt', 'app/admin/' + 'releasenotes.txt'
    ###
    # Site files
    ###
    @template 'site/helpers/route.php', 'app/site/helpers/' + 'route' + '.php'
    @template 'site/language/en-GB/en-GB.com_component-name.ini', 'app/site/' + 'language/en-GB/en-GB.com_' + @_.slugify(@componentName) + '.ini'
    @directory 'site/lib', 'app/site/lib'
    @template 'site/models/gallery.php', 'app/site/models/' + 'gallery' + '.php'
    @template 'site/views/gallery/tmpl/default.php', 'app/site/views/gallery/tmpl/' + '/default.php'
    @template 'site/views/gallery/tmpl/default.xml', 'app/site/views/gallery/tmpl/' + '/default.xml'
    @template 'site/views/gallery/view.html.php', 'app/site/views/gallery/' + 'view.html.php'
    @template 'site/_component-name.php', 'app/site/' + @_.slugify(@componentName) + '.php'
    @template 'site/controller.php', 'app/site/' + 'controller.php'
    @template 'site/router.php', 'app/site/' + 'router.php'
    @template '_component-name.xml', 'app/' + @_.slugify(@componentName) + '.xml'
    @template 'script.php', 'app/' + 'script.php'
    @template 'media/images/_component-name_menu.png', 'app/media/images/' + @_.slugify(@componentName) + '_menu.png'
    @template 'media/images/_component-name_toolbar.png', 'app/media/images/' + @_.slugify(@componentName) + '_toolbar.png'
    #this._install();
    @template '_Gruntfile.js', 'Gruntfile.js'
    done()
    return

  ###
  # files for extension type Com-intermediate
  ###

  Generator::_wcomInt = ->
    done = @async()
    # var files = this.expandFiles('**', {dot: true, cwd: root});
    # console.log '_wcomint function'
    # this._createLegacyFallbackFiles();
    @_createEmptyMVCFolders()
    #this.template('_package.json', 'package.json'); // handled in _common
    ###
    # files are located in templates/ext-com-intermediate
    # Admin files
    ###
    @template 'admin/controllers/_component-name.php', 'app/admin/controllers/' + @_.slugify(@componentName) + '.php'
    @template 'admin/controllers/_component-names.php', 'app/admin/controllers/' + @_.slugify(@componentName) + 's' + '.php'
    @template 'admin/helpers/_component-name.php', 'app/admin/helpers/' + @_.slugify(@componentName) + '.php'
    @template 'admin/language/en-GB/_en-GB.com_component-name.ini', 'app/admin/' + 'language/en-GB/en-GB.com_' + @_.slugify(@componentName) + '.ini'
    @template 'admin/language/en-GB/_en-GB.com_component-name.sys.ini', 'app/admin/' + 'language/en-GB/en-GB.com_' + @_.slugify(@componentName) + '.sys.ini'
    @template 'admin/models/fields/_component-name.php', 'app/admin/models/fields/' + @_.slugify(@componentName) + '.php'
    @template 'admin/models/forms/_component-name.js', 'app/admin/models/forms/' + @_.slugify(@componentName) + '.js'
    @template 'admin/models/forms/_component-name.xml', 'app/admin/models/forms/' + @_.slugify(@componentName) + '.xml'
    @template 'admin/models/forms/_filter_component-name.xml', 'app/admin/models/forms/filter' + @_.slugify(@componentName) + '.xml'
    @template 'admin/models/rules/greeting.php', 'app/admin/models/rules/' +  'greeting.php'
    @template 'admin/models/_component-name.php', 'app/admin/models/' + @_.slugify(@componentName) + '.php'
    @template 'admin/models/_component-names.php', 'app/admin/models/' + @_.slugify(@componentName) + 's' + '.php'
    @template('admin/sql/_install.mysql.utf8.sql', 'app/admin/' + 'sql/install.mysql.utf8.sql')
    @template('admin/sql/_uninstall.mysql.utf8.sql', 'app/admin/' + 'sql/uninstall.mysql.utf8.sql')

    @template 'admin/tables/_component-name.php', 'app/admin/tables/' + @_.slugify(@componentName) + '.php'


    @template 'admin/views/_component-name/tmpl/edit.php', 'app/admin/views/' + @_.slugify(@componentName) + '/tmpl/' + 'edit.php'
    @template 'admin/views/_component-name/submitbutton.js', 'app/admin/views/' + @_.slugify(@componentName) + '/submitbutton.js'
    @template 'admin/views/_component-name/view.html.php', 'app/admin/views/' + @_.slugify(@componentName) + '/view.html.php'
 
    @template 'admin/views/_component-names/tmpl/default.php', 'app/admin/views/' + @_.slugify(@componentName) + 's' + '/tmpl/' + 'default.php'
    @template 'admin/views/_component-names/view.html.php', 'app/admin/views/' + @_.slugify(@componentName) + 's' + '/view.html.php'
    @template 'admin/_component-name.php', 'app/admin/' + @_.slugify(@componentName) + '.php'
    @template 'admin/_access.xml', 'app/admin/' + 'access.xml'
    @template 'admin/_config.xml', 'app/admin/' + 'config.xml'
    @template 'admin/controller.php', 'app/admin/' + 'controller.php'
    # @template 'admin/releasenotes.txt', 'app/admin/' + 'releasenotes.txt'
 
    ###
    # Site files
    ###
    @template 'site/language/en-GB/en-GB.com_component-name.ini', 'app/site/' + 'language/en-GB/en-GB.com_' + @_.slugify(@componentName) + '.ini'
    @template 'site/models/_component-name.php', 'app/site/models/' + @_.slugify(@componentName) + '.php'
    @template 'site/views/_component-name/tmpl/default.php', 'app/site/views/' + @_.slugify(@componentName) + '/tmpl/' + 'default.php'
    @template 'site/views/_component-name/tmpl/default.xml', 'app/site/views/' + @_.slugify(@componentName) + '/tmpl/' + 'default.xml'
    @template 'site/views/_component-name/view.html.php', 'app/site/views/' + @_.slugify(@componentName) + '/view.html.php'
    # @template 'site/views/controller.php', 'app/site/views/' + 'controller' + '.php'


    @template 'site/_component-name.php', 'app/site/' + @_.slugify(@componentName) + '.php'
    @template 'site/controller.php', 'app/site/' + 'controller.php'
    # @template 'site/router.php', 'app/site/' + 'router.php'
    @template '_component-name.xml', 'app/' + @_.slugify(@componentName) + '.xml'
    @template 'script.php', 'app/' + 'script.php'
    #@template 'media/images/_component-name_menu.png', 'app/media/images/' + @_.slugify(@componentName) + '_menu.png'
    #@template 'media/images/_component-name_toolbar.png', 'app/media/images/' + @_.slugify(@componentName) + '_toolbar.png'
    #this._install();
    @template '_Gruntfile.js', 'Gruntfile.js'
    @directory 'media', 'app/media'
    @directory 'admin/sql/updates/', 'app/admin/sql/updates/'
    done()
    return
    ###
    # files for extension type Com - advanced
    ###

  Generator::_wcomAdv = ->
    done = @async()
    # var files = this.expandFiles('**', {dot: true, cwd: root});
    # console.log("_wcom function");
    # this._createLegacyFallbackFiles();
    @_createEmptyMVCFolders()
    #this.template('_package.json', 'package.json'); // handled in _common
    ###
    # files are located in templates/ext-com-advanced
    # Admin files
    ###
    @template 'admin/helpers/_component-name.php', 'app/admin/helpers/' + @_.slugify(@componentName) + '.php'
    @template 'admin/language/en-GB/_en-GB.com_component-name.ini', 'app/admin/' + 'language/en-GB/en-GB.com_' + @_.slugify(@componentName) + '.ini'
    @template 'admin/language/en-GB/_en-GB.com_component-name.sys.ini', 'app/admin/' + 'language/en-GB/en-GB.com_' + @_.slugify(@componentName) + '.sys.ini'
    @template 'admin/libraries/_component-name.php', 'app/admin/libraries/' + @_.slugify(@componentName) + '.php'
    @template 'admin/libraries/_component-name.php', 'app/admin/libraries/' + @_.slugify(@componentName) + '.php'
    @template 'admin/libraries/_ziparchive.php', 'app/admin/libraries/' + 'ziparchive' + '.php'
    @template 'admin/models/_gallery.php', 'app/admin/models/' + 'gallery' + '.php'
    @template 'admin/views/gallery/tmpl/default.php', 'app/admin/views/gallery/tmpl/' + 'default.php'
    @template 'admin/views/gallery/view.html.php', 'app/admin/views/gallery/' + '/view.html.php'
    @template 'admin/_component-name.php', 'app/admin/' + @_.slugify(@componentName) + '.php'
    @template 'admin/_access.xml', 'app/admin/' + 'access.xml'
    @template 'admin/_config.xml', 'app/admin/' + 'config.xml'
    @template 'admin/controller.php', 'app/admin/' + 'controller.php'
    @template 'admin/releasenotes.txt', 'app/admin/' + 'releasenotes.txt'
    ###
    # Site files
    ###
    @template 'site/helpers/route.php', 'app/site/helpers/' + 'route' + '.php'
    @template 'site/language/en-GB/en-GB.com_component-name.ini', 'app/site/' + 'language/en-GB/en-GB.com_' + @_.slugify(@componentName) + '.ini'
    @directory 'site/lib', 'app/site/lib'
    @template 'site/models/gallery.php', 'app/site/models/' + 'gallery' + '.php'
    @template 'site/views/gallery/tmpl/default.php', 'app/site/views/gallery/tmpl/' + '/default.php'
    @template 'site/views/gallery/tmpl/default.xml', 'app/site/views/gallery/tmpl/' + '/default.xml'
    @template 'site/views/gallery/view.html.php', 'app/site/views/gallery/' + 'view.html.php'
    @template 'site/_component-name.php', 'app/site/' + @_.slugify(@componentName) + '.php'
    @template 'site/controller.php', 'app/site/' + 'controller.php'
    @template 'site/router.php', 'app/site/' + 'router.php'
    @template '_component-name.xml', 'app/' + @_.slugify(@componentName) + '.xml'
    @template 'script.php', 'app/' + 'script.php'
    @template 'media/images/_component-name_menu.png', 'app/media/images/' + @_.slugify(@componentName) + '_menu.png'
    @template 'media/images/_component-name_toolbar.png', 'app/media/images/' + @_.slugify(@componentName) + '_toolbar.png'
    #this._install();
    @template '_Gruntfile.js', 'Gruntfile.js'
    done()
    return

  ###
  # files for extension type Plg
  # files are located in templates/ext-plg
  ###

  Generator::_writingPlg = ->
    done = @async()
    pluginfolder = 'plg_' + @_.slugify(@componentGroup) + '_' + @_.slugify(@componentName) + '/'
    console.log 'pluginfolder = ', pluginfolder
    @template '_Gruntfile.js', 'Gruntfile.js'
    # this.template('_component-name.xml', 'app/' + this._.slugify(this.componentName) + '.xml');
    @template '_plugin-name.xml', 'app/' + pluginfolder + @_.slugify(@componentName) + '.xml'
    @template 'language/en-GB/_en-GB.com_component-name.ini', 'app/' + pluginfolder + 'language/en-GB/en-GB.plg_' + @_.slugify(@componentName) + '.ini'
    @template 'language/en-GB/_en-GB.com_component-name.sys.ini', 'app/' + pluginfolder + 'language/en-GB/en-GB.plg_' + @_.slugify(@componentName) + '.sys.ini'
    @template '_plugin-name.php', 'app/' + pluginfolder + @_.slugify(@componentName) + '.php'
    # console.log("_writingPlg function");
    @template '_index.html', 'app/' + pluginfolder + '/index.html'
    @template '_index.html', 'app/' + pluginfolder + 'language/' + '/index.html'
    @template '_index.html', 'app/' + pluginfolder + 'language/en-GB/' + '/index.html'
    done()
    return

  ###
  # files for extension type Tpl
  ###

  Generator::_writingTpl = ->
    done = @async()
    console.log '_writingTpl function'
    done()
    return

  ###
  # files for extension type Tpladmin
  ###

  Generator::_writingTpladmin = ->
    done = @async()
    console.log '_writingTpladmin function'
    done()
    return

  ###
  # files for extension type Mod
  ###

  Generator::_writingMod = ->
    done = @async()
    console.log '_writingMod function'
    done()
    return

  Generator::_common = ->
    @template '_package.json', 'package.json'
    # this.copy('_Gruntfile.js', 'Gruntfile.js');
    @copy '../USAGE', 'USAGE'
    @template '_bower.json', 'bower.json'
    @copy '_gitignore', '.gitignore'

  Generator::_getCurrentDate = ->
    dd = undefined
    mm = undefined
    today = undefined
    yyyy = undefined
    dd = undefined
    mm = undefined
    today = undefined
    yyyy = undefined
    today = new Date()
    dd = today.getDate()
    mm = @_getCurrentMonthName()
    yyyy = today.getFullYear()
    if dd < 10
      dd = '0' + dd
    if mm < 10
      mm = '0' + mm
    today = dd + '-' + mm + '-' + yyyy
    return today

  Generator::_getCurrentMonthName = ->
    d = undefined
    month = undefined
    n = undefined
    d = undefined
    month = undefined
    n = undefined
    d = new Date()
    month = []
    month[0] = 'January'
    month[1] = 'February'
    month[2] = 'March'
    month[3] = 'April'
    month[4] = 'May'
    month[5] = 'June'
    month[6] = 'July'
    month[7] = 'August'
    month[8] = 'September'
    month[9] = 'October'
    month[10] = 'November'
    month[11] = 'December'
    n = month[d.getMonth()]
    return n

  Generator::_getCurrentYear = ->
    today = undefined
    year = undefined
    yyyy = undefined
    today = undefined
    year = undefined
    yyyy = undefined
    today = new Date()
    yyyy = today.getFullYear()
    year = yyyy
    return year

  Generator::_projectfiles = ->
    @copy 'editorconfig', '.editorconfig'
    @copy 'jshintrc', '.jshintrc'

  #Generator::_createConfigFiles = ->
    #this.template('_component-name.xml', 'app/' + this._.slugify(this.componentName) + '.xml');
    # this.template('_config.xml', 'app/' + 'config.xml');
    # this.template('_access.xml', 'app/' + 'access.xml');
    # return

  ###
  #  Create legacy files for fallback to Joomla 2.5x
  ###

  # Generator.prototype._createLegacyFallbackFiles = function () {
  #     if (this.legacyJoomla === true) {
  #         return this.template('_legacy.php', 'app/' + 'legacy.php');
  #     }
  # };
  # Generator.prototype._createPHPFiles = function () {
  #     this.template('_component-name.php', 'app/' + this._.slugify(this.componentName) + '.php');
  #     return this.template('_router.php', 'app/' + 'router.php');
  # };
  # Generator.prototype._createDatabaseFiles = function () {
  #     this.template('sql/_install.mysql.utf8.sql', 'app/' + 'sql/install.mysql.utf8.sql');
  #     this.template('sql/_uninstall.mysql.utf8.sql', 'app/' + 'sql/uninstall.mysql.utf8.sql');
  #     return this.template('_install-uninstall.php', 'app/' + 'install-uninstall.php');
  # };
  # Generator.prototype._createLanguageFiles = function () {
  #     this.template('language/en-GB/_en-GB.com_component-name.ini', 'app/' + 'language/en-GB/en-GB.com_' + this._.slugify(this.componentName) + '.ini');
  #     return this.template('language/en-GB/_en-GB.com_component-name.ini', 'app/' + 'language/en-GB/en-GB.com_' + this._.slugify(this.componentName) + '.sys.ini');
  # };

  Generator::_createEmptyMVCFolders = ->
    emptyMVCFolders = undefined
    folderName = undefined
    i = undefined
    len = undefined
    emptyMVCFolders = undefined
    folderName = undefined
    i = undefined
    len = undefined
    emptyMVCFolders = [
      'app/admin/'
      'app/site/'
      'app/admin/' + 'controllers'
      'app/site/' + 'controllers'
      'app/admin/' + 'language'
      'app/site/' + 'language'
      'app/admin/' + 'language/en-GB/'
      'app/site/' + 'language/en-GB/'
      'app/admin/' + 'helpers'
      'app/site/' + 'helpers'
      'app/' + 'media'
      'app/' + 'media/images/'
      'app/admin/' + 'models'
      'app/site/' + 'models'
      'app/admin/' + 'models/fields/'
      'app/site/' + 'models/fields/'
      'app/admin/' + 'models/forms/'
      'app/site/' + 'models/forms/'
      'app/admin/' + 'models/rules/'
      'app/site/' + 'models/rules/'
      'app/admin/' + 'sql'
      'app/site/' + 'sql'
      'app/admin/' + 'sql/updates/'
      'app/site/' + 'sql/updates/'
      'app/admin/' + 'tables'
      'app/site/' + 'tables'
      'app/admin/' + 'views'
      'app/site/' + 'views'
    ]
    i = 0
    len = emptyMVCFolders.length
    while i < len
      folderName = emptyMVCFolders[i]
      @template '_index.html', folderName + '/index.html'
      i++
    @template '_index.html', 'app/' + 'index.html'

  ###
  # Installation
  ###

  Generator::install = ->
    if @generator.installDependencies
      @installDependencies
        npm: true
        bower: false
    return

  Generator::end = ->
    @log ''
    @log chalk.white('Your extension ' + chalk.yellow.bold(@componentName) + chalk.white(' has been created!'))
    @log ''
    @log chalk.white('Go here to download and install bitnami joomla for your system ' + chalk.cyan('https://bitnami.com/stack/joomla'))
    @log chalk.white('=================================')
    @log ''
    @log chalk.white('To get a list of sub-generators type the following:')
    @log chalk.white('yo joomla-spc --help')
    #     this.log.writeln('');
    #     this.log.writeln('Looks like we\'re done!');
    #     this.log.writeln('');
    # @log '\ud\n'
    return

  return
).call this

# ---
# generated by js2coffee 2.1.0