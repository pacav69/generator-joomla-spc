
/*
    generator-joomla-spc

    index.coffee

    @author Sean

    @note Created on 2014-10-04 by PhpStorm
    @note uses Codoc
    @see https://github.com/coffeedoc/codo
 */

(function() {
  "use strict";
  var JoomlaSpcGenerator, path, yeoman,
    extend = function(child, parent) { for (var key in parent) { if (hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; },
    hasProp = {}.hasOwnProperty;

  yeoman = require("yeoman-generator");

  path = require("path");


  /*
      @class ControllerGenerator sub-generator for joomla spc controllers
      @see https://github.com/mklabs/yeoman/wiki/generators coffeescript with yeoman
   */

  module.exports = JoomlaSpcGenerator = (function(superClass) {
    extend(JoomlaSpcGenerator, superClass);


    /*
        @param [Array] args command-line arguments passed in (if any)
        @param [Array] options any additional options
        @param [Array] config the yeoman configuration
     */

    function JoomlaSpcGenerator(args, options, config) {
      JoomlaSpcGenerator.__super__.constructor.call(this, args, options, config);
      this.on("end", function() {
        return this.installDependencies({
          skipInstall: options["skip-install"]
        });
      });
      this.pkg = JSON.parse(this.readFileAsString(path.join(__dirname, "../package.json")));
    }

    JoomlaSpcGenerator.prototype.askFor = function() {
      var cb, prompts;
      cb = this.async();
      console.log(this.yeoman);
      prompts = [
        {
          name: "description",
          message: "Describe your component",
          "default": "A sample description"
        }, {
          name: "componentName",
          message: "What's the component's name?",
          "default": "default-value"
        }, {
          name: "authorName",
          message: "What's your name?",
          "default": "Author name",
          store: true
        }, {
          name: "authorEmail",
          message: "What's your e-mail?",
          "default": "email@somedomain.com",
          store: true
        }, {
          name: "authorURL",
          message: "What's your website?",
          "default": "somedomain.com",
          store: true
        }, {
          name: "versionno",
          message: "What's the version number?",
          "default": "1.0.0",
          store: true
        }, {
          name: "license",
          message: "What's the copyright license?",
          "default": "MIT"
        }, {
          type: "confirm",
          name: "requireManageRights",
          message: "Does your component require admin manage rights to access it?"
        }, {
          type: "confirm",
          name: "legacyJoomla",
          message: "Support Joomla 2.5x with compatibility layer?"
        }
      ];
      return this.prompt(prompts, (function(props) {
        this.description = props.description;
        this.componentName = props.componentName;
        this.authorName = props.authorName;
        this.authorEmail = props.authorEmail;
        this.authorURL = props.authorURL;
        this.versionno = props.versionno;
        this.license = props.license;
        this.requireManageRights = props.requireManageRights;
        this.legacyJoomla = props.legacyJoomla;
        this.currentDate = this._getCurrentDate();
        this.currentYear = this._getCurrentYear();
        return cb();
      }).bind(this));
    };

    JoomlaSpcGenerator.prototype.app = function() {
      this.mkdir("app");
      this.mkdir("app/templates");
      this.mkdir("app/admin");
      this.mkdir("app/site");
      this.mkdir("src");
      this.template("_package.json", "package.json");
      this.copy("_Gruntfile.js", "Gruntfile.js");
      this.template("_bower.json", "bower.json");
      return this.copy("_gitignore", ".gitignore");
    };

    JoomlaSpcGenerator.prototype._getCurrentDate = function() {
      var dd, mm, today, yyyy;
      today = new Date;
      dd = today.getDate();
      mm = today.getMonth() + 1;
      yyyy = today.getFullYear();
      if (dd < 10) {
        dd = '0' + dd;
      }
      if (mm < 10) {
        mm = '0' + mm;
      }
      return today = mm + '-' + dd + '-' + yyyy;
    };

    JoomlaSpcGenerator.prototype._getCurrentYear = function() {
      var today, year, yyyy;
      today = new Date;
      yyyy = today.getFullYear();
      return year = yyyy;
    };

    JoomlaSpcGenerator.prototype.projectfiles = function() {
      this.copy("editorconfig", ".editorconfig");
      return this.copy("jshintrc", ".jshintrc");
    };

    JoomlaSpcGenerator.prototype.createConfigFiles = function() {
      this.template("_component-name.xml", "src/" + this._.slugify(this.componentName) + ".xml");
      this.template("_config.xml", "src/" + "config.xml");
      return this.template("_access.xml", "src/" + "access.xml");
    };


    /*
    Create legacy files for fallback to Joomla 2.5x
     */

    JoomlaSpcGenerator.prototype.createLegacyFallbackFiles = function() {
      if (this.legacyJoomla === true) {
        return this.template("_legacy.php", "src/" + "legacy.php");
      }
    };

    JoomlaSpcGenerator.prototype.createPHPFiles = function() {
      this.template("_component-name.php", "src/" + this._.slugify(this.componentName) + ".php");
      return this.template("_router.php", "src/" + "router.php");
    };

    JoomlaSpcGenerator.prototype.createDatabaseFiles = function() {
      this.template("sql/_install.mysql.utf8.sql", "src/" + "sql/install.mysql.utf8.sql");
      this.template("sql/_uninstall.mysql.utf8.sql", "src/" + "sql/uninstall.mysql.utf8.sql");
      return this.template("_install-uninstall.php", "src/" + "install-uninstall.php");
    };

    JoomlaSpcGenerator.prototype.createLanguageFiles = function() {
      this.template("languages/en-GB/_en-GB.com_component-name.ini", "src/" + "languages/en-GB/en-GB.com_" + this._.slugify(this.componentName) + ".ini");
      return this.template("languages/en-GB/_en-GB.com_component-name.ini", "src/" + "languages/en-GB/en-GB.com_" + this._.slugify(this.componentName) + ".sys.ini");
    };

    JoomlaSpcGenerator.prototype.createEmptyMVCFolders = function() {
      var emptyMVCFolders, folderName, i, len;
      emptyMVCFolders = ["src/" + "controllers", "src/" + "helpers", "src/" + "models", "src/" + "sql", "src/" + "tables", "src/" + "views"];
      for (i = 0, len = emptyMVCFolders.length; i < len; i++) {
        folderName = emptyMVCFolders[i];
        this.template("_index.html", folderName + "/index.html");
      }
      this.template("_index.html", "src/" + "index.html");
      this.template("_index.html", "src/" + "languages/index.html");
      return this.template("_index.html", "src/" + "languages/en-GB/index.html");
    };

    return JoomlaSpcGenerator;

  })(yeoman.generators.Base);

}).call(this);
