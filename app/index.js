'use strict';

var util = require('util'),
    path = require('path'),
    fs = require('fs'),
    yeoman = require('yeoman-generator'),
    rimraf = require('rimraf'),
    exec = require('child_process').exec,
    semver = require('semver'),
    config = require('../config.js')

module.exports = Generator

function Generator(args, options) {
    yeoman.generators.Base.apply(this, arguments)

    this.sourceRoot(path.join(__dirname, 'templates'))

    this.on('end', function() {
        this.installDependencies({
            skipInstall: options['skip-install']
        })
    })
}

util.inherits(Generator, yeoman.generators.NamedBase)

// try to find the config file and read the infos to set the prompts default values
Generator.prototype.getConfig = function getConfig() {
    var cb = this.async(),
        self = this

    self.configExists = false

    config.getConfig(function(err, data) {
        if (!err) {
            self.configExists = true
        }

        self.defaultAuthorName = data.authorName
        self.defaultAuthorURL = data.authorURL
        self.defaultAuthorEmail = data.authorEmail
        self.latestVersion = data.latestVersion
        cb()
    })
}

Generator.prototype.askFor = function askFor() {
    var cb = this.async(),
        self = this
    // console.log("self = ", self.defaultAuthorName);

    var prompts = [{
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
        "default": self.defaultAuthorName
    }, {
        name: "authorEmail",
        message: "What's your e-mail?",
        "default": self.defaultAuthorEmail
    }, {
        name: "authorURL",
        message: "What's your website?",
        "default": self.defaultAuthorURL
    }, {
        name: "versionno",
        message: "What's the version number?",
        "default": "1.0.0"
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
    }];

    this.prompt(prompts, (function(props) {
        var values;
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
        if (!self.configExists) {
            values = {
                authorName: self.authorName,
                authorURL: self.authorURL,
                authorEmail: self.authorEmail,
                versionno: self.versionno
            };
            return config.createConfig(values, cb);
        } else {
          // self.versionno = this.versionno;
          // self.log.writeln('Updated Version: '+self.versionno);
          // config.updateVersion(self.versionno)
            return cb();
        }
    }).bind(this));
};

Generator.prototype.app = function() {
    this.mkdir("app");
    this.mkdir("app/templates");
    this.mkdir("app/admin");
    this.mkdir("app/site");
    this.mkdir("src");
    this.template("_package.json", "package.json");
    this.copy("_Gruntfile.js", "Gruntfile.js");
    this.copy("../USAGE", "USAGE");
    this.template("_bower.json", "bower.json");
    return this.copy("_gitignore", ".gitignore");
};

Generator.prototype._getCurrentDate = function() {
    var dd, mm, today, yyyy;
    today = new Date;
    dd = today.getDate();
    mm = this._getCurrentMonthName();
    yyyy = today.getFullYear();
    if (dd < 10) {
        dd = '0' + dd;
    }
    if (mm < 10) {
        mm = '0' + mm;
    }
    return today = dd + '-' + mm + '-' + yyyy;
};

Generator.prototype._getCurrentMonthName = function() {
    var d, month, n;
    d = new Date();
    month = new Array();
    month[0] = "January";
    month[1] = "February";
    month[2] = "March";
    month[3] = "April";
    month[4] = "May";
    month[5] = "June";
    month[6] = "July";
    month[7] = "August";
    month[8] = "September";
    month[9] = "October";
    month[10] = "November";
    month[11] = "December";
    return n = month[d.getMonth()];
};

Generator.prototype._getCurrentYear = function() {
    var today, year, yyyy;
    today = new Date;
    yyyy = today.getFullYear();
    return year = yyyy;
};



Generator.prototype.projectfiles = function() {
    this.copy("editorconfig", ".editorconfig");
    return this.copy("jshintrc", ".jshintrc");
};

Generator.prototype.createConfigFiles = function() {
    this.template("_component-name.xml", "src/" + this._.slugify(this.componentName) + ".xml");
    this.template("_config.xml", "src/" + "config.xml");
    return this.template("_access.xml", "src/" + "access.xml");
};


/*
    Create legacy files for fallback to Joomla 2.5x
     */

Generator.prototype.createLegacyFallbackFiles = function() {
    if (this.legacyJoomla === true) {
        return this.template("_legacy.php", "src/" + "legacy.php");
    }
};

Generator.prototype.createPHPFiles = function() {
    this.template("_component-name.php", "src/" + this._.slugify(this.componentName) + ".php");
    return this.template("_router.php", "src/" + "router.php");
};

Generator.prototype.createDatabaseFiles = function() {
    this.template("sql/_install.mysql.utf8.sql", "src/" + "sql/install.mysql.utf8.sql");
    this.template("sql/_uninstall.mysql.utf8.sql", "src/" + "sql/uninstall.mysql.utf8.sql");
    return this.template("_install-uninstall.php", "src/" + "install-uninstall.php");
};

Generator.prototype.createLanguageFiles = function() {
    this.template("languages/en-GB/_en-GB.com_component-name.ini", "src/" + "languages/en-GB/en-GB.com_" + this._.slugify(this.componentName) + ".ini");
    return this.template("languages/en-GB/_en-GB.com_component-name.ini", "src/" + "languages/en-GB/en-GB.com_" + this._.slugify(this.componentName) + ".sys.ini");
};

Generator.prototype.createEmptyMVCFolders = function() {
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


Generator.prototype.endGenerator = function endGenerator() {
    this.log.writeln('')
    this.log.writeln('Looks like we\'re done!')
    this.log.writeln('')
}