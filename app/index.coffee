###
    generator-joomla-spc

    index.coffee

###

Generator = (args, options) ->
  yeoman.generators.Base.apply this, arguments
  @sourceRoot path.join(__dirname, 'templates')
  @on 'end', ->
    @installDependencies skipInstall: options['skip-install']
    return
  return

'use strict'
util = require('util')
path = require('path')
fs = require('fs')
yeoman = require('yeoman-generator')
rimraf = require('rimraf')
exec = require('child_process').exec
semver = require('semver')
config = require('../config.js')
module.exports = Generator
util.inherits Generator, yeoman.generators.NamedBase
# try to find the config file and read the infos to set the prompts default values

Generator::getConfig = ->
  cb = @async()
  self = this
  self.configExists = false
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
  cb = @async()
  self = this
  # console.log("self = ", self.defaultAuthorName);
  prompts = [
    {
      name: 'description'
      message: 'Describe your component'
      'default': 'A sample description'
    }
    {
      name: 'componentName'
      message: 'What\'s the component\'s name?'
      'default': 'default-value'
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
  @prompt prompts, ((props) ->
    values = undefined
    @description = props.description
    @componentName = props.componentName
    @authorName = props.authorName
    @authorEmail = props.authorEmail
    @authorURL = props.authorURL
    @versionno = props.versionno
    @license = props.license
    @requireManageRights = props.requireManageRights
    @legacyJoomla = props.legacyJoomla
    @currentDate = @_getCurrentDate()
    @currentYear = @_getCurrentYear()
    if !self.configExists
      values =
        authorName: self.authorName
        authorURL: self.authorURL
        authorEmail: self.authorEmail
        versionno: self.versionno
      config.createConfig values, cb
    else
      # self.versionno = this.versionno;
      # self.log.writeln('Updated Version: '+self.versionno);
      # config.updateVersion(self.versionno)
      cb()
  ).bind(this)
  return

Generator::app = ->
  @mkdir 'app'
  @mkdir 'app/templates'
  @mkdir 'app/admin'
  @mkdir 'app/site'
  @mkdir 'src'
  @template '_package.json', 'package.json'
  @copy '_Gruntfile.js', 'Gruntfile.js'
  @copy '../USAGE', 'USAGE'
  @template '_bower.json', 'bower.json'
  @copy '_gitignore', '.gitignore'

Generator::_getCurrentDate = ->
  dd = undefined
  mm = undefined
  today = undefined
  yyyy = undefined
  today = new Date
  dd = today.getDate()
  mm = @_getCurrentMonthName()
  yyyy = today.getFullYear()
  if dd < 10
    dd = '0' + dd
  if mm < 10
    mm = '0' + mm
  today = dd + '-' + mm + '-' + yyyy

Generator::_getCurrentMonthName = ->
  d = undefined
  month = undefined
  n = undefined
  d = new Date
  month = new Array
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

Generator::_getCurrentYear = ->
  today = undefined
  year = undefined
  yyyy = undefined
  today = new Date
  yyyy = today.getFullYear()
  year = yyyy

Generator::projectfiles = ->
  @copy 'editorconfig', '.editorconfig'
  @copy 'jshintrc', '.jshintrc'

Generator::createConfigFiles = ->
  @template '_component-name.xml', 'src/' + @_.slugify(@componentName) + '.xml'
  @template '_config.xml', 'src/' + 'config.xml'
  @template '_access.xml', 'src/' + 'access.xml'

###
    Create legacy files for fallback to Joomla 2.5x
###

Generator::createLegacyFallbackFiles = ->
  if @legacyJoomla == true
    return @template('_legacy.php', 'src/' + 'legacy.php')
  return

Generator::createPHPFiles = ->
  @template '_component-name.php', 'src/' + @_.slugify(@componentName) + '.php'
  @template '_router.php', 'src/' + 'router.php'

Generator::createDatabaseFiles = ->
  @template 'sql/_install.mysql.utf8.sql', 'src/' + 'sql/install.mysql.utf8.sql'
  @template 'sql/_uninstall.mysql.utf8.sql', 'src/' + 'sql/uninstall.mysql.utf8.sql'
  @template '_install-uninstall.php', 'src/' + 'install-uninstall.php'

Generator::createLanguageFiles = ->
  @template 'languages/en-GB/_en-GB.com_component-name.ini', 'src/' + 'languages/en-GB/en-GB.com_' + @_.slugify(@componentName) + '.ini'
  @template 'languages/en-GB/_en-GB.com_component-name.ini', 'src/' + 'languages/en-GB/en-GB.com_' + @_.slugify(@componentName) + '.sys.ini'

Generator::createEmptyMVCFolders = ->
  emptyMVCFolders = undefined
  folderName = undefined
  i = undefined
  len = undefined
  emptyMVCFolders = [
    'src/' + 'controllers'
    'src/' + 'helpers'
    'src/' + 'models'
    'src/' + 'sql'
    'src/' + 'tables'
    'src/' + 'views'
  ]
  i = 0
  len = emptyMVCFolders.length
  while i < len
    folderName = emptyMVCFolders[i]
    @template '_index.html', folderName + '/index.html'
    i++
  @template '_index.html', 'src/' + 'index.html'
  @template '_index.html', 'src/' + 'languages/index.html'
  @template '_index.html', 'src/' + 'languages/en-GB/index.html'

Generator::endGenerator = ->
  @log.writeln ''
  @log.writeln 'Looks like we\'re done!'
  @log.writeln ''
  return

# ---
# generated by js2coffee 2.1.0