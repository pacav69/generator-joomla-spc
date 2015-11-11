###
    generator-joomla-spc

    index.coffee

    @author Sean

    @note Created on 2014-10-04 by PhpStorm
    @note uses Codoc
    @see https://github.com/coffeedoc/codo
###
"use strict"
yeoman = require("yeoman-generator")
path = require("path")

###
    @class ControllerGenerator sub-generator for joomla spc controllers
    @see https://github.com/mklabs/yeoman/wiki/generators coffeescript with yeoman
###
module.exports = class JoomlaSpcGenerator extends yeoman.generators.Base
    ###
        @param [Array] args command-line arguments passed in (if any)
        @param [Array] options any additional options
        @param [Array] config the yeoman configuration
    ###
    constructor: (args, options, config) ->
        super args, options, config
        @on "end", ->
            @installDependencies skipInstall: options["skip-install"]
        @pkg = JSON.parse(@readFileAsString(path.join(__dirname, "../package.json")))
    askFor: ->
        cb = @async()

        # have Yeoman greet the user.
        console.log @yeoman
        prompts = [
            {
                name: "description"
                message: "Describe your component"
                default: "A sample description"
            }
            {
                name: "componentName"
                message: "What's the component's name?"
                default: "default-value"
            }
            {
                name: "authorName"
                message: "What's your name?"
                default: "Author name"
                store   : true
            }
            {
                name: "authorEmail"
                message: "What's your e-mail?"
                default: "email@somedomain.com"
                store   : true
            }
            {
                name: "authorURL"
                message: "What's your website?"
                default: "somedomain.com"
                store   : true
            }
            {
                name: "versionno"
                message: "What's the version number?"
                default: "1.0.0"
                store   : true
            }
            {
                name: "license"
                message: "What's the copyright license?"
                default: "MIT"
            }
            {
                type: "confirm"
                name: "requireManageRights"
                message: "Does your component require admin manage rights to access it?"
            }
            {
                type: "confirm"
                name: "legacyJoomla"
                message: "Support Joomla 2.5x with compatibility layer?"
            }
        ]
        @prompt prompts, ((props) ->
            # for own prompt of prompts
            # @prompt.name = prompt.name?
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
            cb()
        ).bind(@)
    app: ->
        @mkdir "app"
        @mkdir "app/templates"
        @mkdir "app/admin"
        @mkdir "app/site"
        @mkdir "src"
        @template "_package.json", "package.json"
        @copy "_Gruntfile.js", "Gruntfile.js"
        @copy "../USEAGE", "USEAGE"
        @template "_bower.json", "bower.json"
        @copy "_gitignore", ".gitignore"

    _getCurrentDate: ->
        today = new Date  
        dd = today.getDate()  
        #The value returned by getMonth is an integer between 0 and 11, referring 0 to January, 1 to February, and so on.  
        mm = today.getMonth() + 1  
        yyyy = today.getFullYear()  
        if dd < 10  
          dd = '0' + dd  
        if mm < 10  
          mm = '0' + mm  
        today = mm + '-' + dd + '-' + yyyy  
     _getCurrentYear: ->
        today = new Date   
        yyyy = today.getFullYear()   
        year = yyyy 

        # new Date().getUTCDate()
    projectfiles: ->
        @copy "editorconfig", ".editorconfig"
        @copy "jshintrc", ".jshintrc"
    createConfigFiles: ->
        @template "_component-name.xml", "src/" + @_.slugify(@componentName) + ".xml"
        @template "_config.xml", "src/" + "config.xml"
        @template "_access.xml", "src/" + "access.xml"
    ###
    Create legacy files for fallback to Joomla 2.5x
    ###
    createLegacyFallbackFiles: ->
        @template "_legacy.php", "src/" + "legacy.php" if @legacyJoomla is on

    createPHPFiles: ->
        @template "_component-name.php", "src/" + @_.slugify(@componentName) + ".php"
        @template "_router.php","src/" +  "router.php"

    createDatabaseFiles: ->
        @template "sql/_install.mysql.utf8.sql", "src/" + "sql/install.mysql.utf8.sql"
        @template "sql/_uninstall.mysql.utf8.sql", "src/" + "sql/uninstall.mysql.utf8.sql"
        @template "_install-uninstall.php", "src/" + "install-uninstall.php"

    createLanguageFiles: ->
        @template "languages/en-GB/_en-GB.com_component-name.ini", "src/" + "languages/en-GB/en-GB.com_" + @_.slugify(@componentName) + ".ini"
        @template "languages/en-GB/_en-GB.com_component-name.ini", "src/" + "languages/en-GB/en-GB.com_" + @_.slugify(@componentName) + ".sys.ini"

    createEmptyMVCFolders: ->
        emptyMVCFolders = [
            "src/" + "controllers"
            "src/" + "helpers"
            "src/" + "models"
            "src/" + "sql"
            "src/" + "tables"
            "src/" + "views"
        ]
        for folderName in emptyMVCFolders
            @template "_index.html", "#{folderName}/index.html"

        @template "_index.html", "src/" + "index.html"
        @template "_index.html", "src/" + "languages/index.html"
        @template "_index.html", "src/" + "languages/en-GB/index.html"

