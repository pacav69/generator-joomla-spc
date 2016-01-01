
/*
    generator-joomla-spc
    v0.1.3
    added selection of component levels basic, intermediate, advanced

    v0.1.2
    added selection of plugin group
 */

(function() {
  'use strict';
  (function() {
    var Generator, chalk, config, exec, fs, inquirer, path, pkg, rimraf, semver, stringLength, ucfirst, updateNotifier, util, yeoman, yosay;
    Generator = void 0;
    config = void 0;
    exec = void 0;
    fs = void 0;
    path = void 0;
    rimraf = void 0;
    semver = void 0;
    util = void 0;
    yeoman = void 0;
    Generator = function() {
      yeoman.generators.Base.apply(this, arguments);
      this.generator = Object.create(null);
      this.sourceRoot(path.join(__dirname, 'templates'));
      this.generator.installDependencies = false;
    };
    util = require('util');
    path = require('path');
    fs = require('fs');
    yeoman = require('yeoman-generator');
    yosay = require('yosay');
    updateNotifier = require('update-notifier');
    stringLength = require('string-length');
    pkg = require('../package.json');
    chalk = require('chalk');
    inquirer = require('inquirer');
    ucfirst = require('ucfirst');
    rimraf = require('rimraf');
    exec = require('child_process').exec;
    semver = require('semver');
    config = require('../configuserglobal.js');
    module.exports = Generator;
    util.inherits(Generator, yeoman.generators.NamedBase);

    /*
     * 1000 * 60 * 60 * 24; // 1 day
     * 1000 * 60 * 60 * 24 * 7 // 1 week
     */
    Generator.prototype.updateCheck = function() {
      var message, notifier;
      notifier = updateNotifier({
        pkg: pkg,
        updateCheckInterval: 1000 * 60 * 60 * 24
      });
      message = [];
      if (notifier.update) {
        message.push('Update available: ' + chalk.green.bold(notifier.update.latest) + chalk.gray(' (current: ' + notifier.update.current + ')'));
        message.push('Run ' + chalk.magenta('npm install -g yo ' + pkg.name) + ' to update.');
        message.push('\n' + chalk.white.bold('Recommend updating ') + chalk.green.bold(pkg.name) + chalk.white.bold(' before continuing.'));
        console.log(yosay(message.join(' '), {
          maxLength: stringLength(message[0])
        }));
      }
    };
    Generator.prototype.startGenerator = function() {
      this.log(yosay(chalk.white('Welcome to the SPC Joomla Extension generator!') + chalk.white('\nVersion ') + chalk.white.bold(pkg.version)));
    };
    Generator.prototype.askForType = function() {
      var done;
      done = this.async();
      this.prompt({
        type: 'list',
        name: 'type',
        message: 'What type of extension do you want to create?',
        choices: [
          {
            name: 'Component',
            value: 'ext-com'
          }, {
            name: 'Plug-in',
            value: 'ext-plg'
          }, {
            name: 'Template Front End',
            value: 'ext-tpl'
          }, {
            name: 'Template Admin',
            value: 'ext-tpladmin'
          }, {
            name: 'Module',
            value: 'ext-mod'
          }
        ]
      }, (function(typeAnswer) {
        this.generator.type = typeAnswer.type;
        done();
      }).bind(this));
    };
    Generator.prototype.getConfig = function() {
      var cb, self;
      cb = void 0;
      self = void 0;
      cb = this.async();
      self = this;
      self.configExists = false;
      config.getConfig(function(err, data) {
        if (!err) {
          self.configExists = true;
        }
        self.defaultAuthorName = data.authorName;
        self.defaultAuthorURL = data.authorURL;
        self.defaultAuthorEmail = data.authorEmail;
        self.latestVersion = data.latestVersion;
        cb();
      });
    };
    Generator.prototype.askFor = function() {
      var cb, prompts, self;
      cb = void 0;
      prompts = void 0;
      self = void 0;
      cb = this.async();
      self = this;
      switch (this.generator.type) {
        case 'ext-com':
          prompts = [
            {
              type: 'list',
              name: 'componentComGroup',
              message: 'What\'s the Component level?',
              choices: [
                {
                  name: 'Basic',
                  value: 'basic'
                }, {
                  name: 'Intermediate',
                  value: 'intermediate'
                }, {
                  name: 'Advanced',
                  value: 'advanced'
                }
              ]
            }, {
              name: 'description',
              message: 'Describe your component',
              'default': 'A sample description'
            }, {
              name: 'componentName',
              message: 'What\'s the component\'s name?',
              'default': 'defaultcomponentvalue'
            }, {
              name: 'authorName',
              message: 'What\'s your name?',
              'default': self.defaultAuthorName
            }, {
              name: 'authorEmail',
              message: 'What\'s your e-mail?',
              'default': self.defaultAuthorEmail
            }, {
              name: 'authorURL',
              message: 'What\'s your website?',
              'default': self.defaultAuthorURL
            }, {
              name: 'versionno',
              message: 'What\'s the version number?',
              'default': '1.0.0'
            }, {
              name: 'license',
              message: 'What\'s the copyright license?',
              'default': 'MIT'
            }, {
              type: 'confirm',
              name: 'requireManageRights',
              message: 'Does your component require admin manage rights to access it?'
            }, {
              type: 'confirm',
              name: 'legacyJoomla',
              message: 'Support Joomla 2.5x with compatibility layer?'
            }
          ];
          break;
        case 'ext-plg':
          prompts = [
            {
              type: 'list',
              name: 'componentGroup',
              message: 'What\'s the plugin\'s Group?',
              choices: [
                {
                  name: 'Content',
                  value: 'content'
                }, {
                  name: 'Extension',
                  value: 'extension'
                }, {
                  name: 'Authentication',
                  value: 'authentication'
                }, {
                  name: 'Captcha',
                  value: 'captcha'
                }, {
                  name: 'Editors',
                  value: 'editors'
                }, {
                  name: 'Editors-XTD',
                  value: 'editors-xtd'
                }, {
                  name: 'Quick-Icons',
                  value: 'quick-icons'
                }, {
                  name: 'Search',
                  value: 'search'
                }, {
                  name: 'Smart Search (Finder)',
                  value: 'smart-search'
                }, {
                  name: 'System',
                  value: 'system'
                }, {
                  name: 'Two Factor Auth',
                  value: 'twofactorauth'
                }, {
                  name: 'User',
                  value: 'user'
                }
              ]
            }, {
              name: 'description',
              message: 'Describe your plugin',
              'default': 'A sample description'
            }, {
              name: 'componentName',
              message: 'What\'s the plugin\'s name?',
              'default': 'defaultplugin-value'
            }, {
              name: 'authorName',
              message: 'What\'s your name?',
              'default': self.defaultAuthorName
            }, {
              name: 'authorEmail',
              message: 'What\'s your e-mail?',
              'default': self.defaultAuthorEmail
            }, {
              name: 'authorURL',
              message: 'What\'s your website?',
              'default': self.defaultAuthorURL
            }, {
              name: 'versionno',
              message: 'What\'s the version number?',
              'default': '1.0.0'
            }, {
              name: 'license',
              message: 'What\'s the copyright license?',
              'default': 'MIT'
            }
          ];
          break;
        case 'ext-tpl':
          console.log('in switch', this.generator.type);
          prompts = [
            {
              name: 'description',
              message: 'Describe your template',
              'default': 'A sample description'
            }, {
              name: 'componentName',
              message: 'What\'s the template\'s name?',
              'default': 'default-template-value'
            }, {
              name: 'authorName',
              message: 'What\'s your name?',
              'default': self.defaultAuthorName
            }, {
              name: 'authorEmail',
              message: 'What\'s your e-mail?',
              'default': self.defaultAuthorEmail
            }, {
              name: 'authorURL',
              message: 'What\'s your website?',
              'default': self.defaultAuthorURL
            }, {
              name: 'versionno',
              message: 'What\'s the version number?',
              'default': '1.0.0'
            }, {
              name: 'license',
              message: 'What\'s the copyright license?',
              'default': 'MIT'
            }
          ];
          break;
        case 'ext-tpladmin':
          console.log('in switch', this.generator.type);
          prompts = [
            {
              name: 'description',
              message: 'Describe your Admin template',
              'default': 'A sample description'
            }, {
              name: 'componentName',
              message: 'What\'s the Admin template\'s name?',
              'default': 'default-Admin-template-value'
            }, {
              name: 'authorName',
              message: 'What\'s your name?',
              'default': self.defaultAuthorName
            }, {
              name: 'authorEmail',
              message: 'What\'s your e-mail?',
              'default': self.defaultAuthorEmail
            }, {
              name: 'authorURL',
              message: 'What\'s your website?',
              'default': self.defaultAuthorURL
            }, {
              name: 'versionno',
              message: 'What\'s the version number?',
              'default': '1.0.0'
            }, {
              name: 'license',
              message: 'What\'s the copyright license?',
              'default': 'MIT'
            }
          ];
          break;
        case 'ext-mod':
          console.log('in switch', this.generator.type);
          prompts = [
            {
              name: 'description',
              message: 'Describe your Module',
              'default': 'A sample description'
            }, {
              name: 'componentName',
              message: 'What\'s the Module\'s name?',
              'default': 'default-Module-value'
            }, {
              name: 'authorName',
              message: 'What\'s your name?',
              'default': self.defaultAuthorName
            }, {
              name: 'authorEmail',
              message: 'What\'s your e-mail?',
              'default': self.defaultAuthorEmail
            }, {
              name: 'authorURL',
              message: 'What\'s your website?',
              'default': self.defaultAuthorURL
            }, {
              name: 'versionno',
              message: 'What\'s the version number?',
              'default': '1.0.0'
            }, {
              name: 'license',
              message: 'What\'s the copyright license?',
              'default': 'MIT'
            }
          ];
          break;
        default:
          break;
      }
      this.prompt(prompts, (function(props) {
        var values;
        values = void 0;
        this.description = props.description;
        this.componentName = props.componentName;
        this.componentGroup = props.componentGroup;
        this.componentComGroup = props.componentComGroup;
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
          return cb();
        }
      }).bind(this));
    };

    /*
     *
     *  Write files
     *
     */
    Generator.prototype.writing = function() {
      this._common();
      this._projectfiles();

      /*
       * set the template root to templates/[typename]
       */
      this.sourceRoot(path.join(__dirname, './templates/' + this.generator.type));
      switch (this.generator.type) {
        case 'ext-com':

          /*
           * this.generator.installDependencies = true;
           * @generator.installDependencies = true
           */
          this.generator.installDependencies = true;
          switch (this.componentComGroup) {
            case 'basic':
              console.log('componentComGroup basic');
              this.sourceRoot(path.join(__dirname, './templates/' + this.generator.type + '-' + this.componentComGroup));
              this._wcom();
              break;
            case 'intermediate':
              this.sourceRoot(path.join(__dirname, './templates/' + this.generator.type + '-' + this.componentComGroup));
              this._wcomInt();
              break;
            case 'advanced':
              this.sourceRoot(path.join(__dirname, './templates/' + this.generator.type + '-' + this.componentComGroup));
              this._wcomAdv();
              break;
            default:

              /*
               * unknown project type
               */
              break;
          }
          break;
        case 'ext-plg':
          this._writingPlg();
          this.generator.installDependencies = true;
          break;
        case 'ext-tpl':
          this._writingTpl();
          this.generator.installDependencies = true;
          break;
        case 'ext-tpladmin':
          this._writingTpladmin();
          this.generator.installDependencies = true;
          break;
        case 'ext-mod':
          this._writingMod();
          this.generator.installDependencies = true;
          break;
        default:

          /* unknown project type */
          break;
      }

      /*
       * files for extension type Com - basic
       */
    };
    Generator.prototype._wcom = function() {
      var done;
      done = this.async();
      console.log('_wcom function');
      this._createEmptyMVCFolders();

      /*
       * files are located in templates/ext-com-basic
       * Admin files
       */
      this.template('admin/helpers/_component-name.php', 'app/admin/helpers/' + this._.slugify(this.componentName) + '.php');
      this.template('admin/language/en-GB/_en-GB.com_component-name.ini', 'app/admin/' + 'language/en-GB/en-GB.com_' + this._.slugify(this.componentName) + '.ini');
      this.template('admin/language/en-GB/_en-GB.com_component-name.sys.ini', 'app/admin/' + 'language/en-GB/en-GB.com_' + this._.slugify(this.componentName) + '.sys.ini');
      this.template('admin/libraries/_component-name.php', 'app/admin/libraries/' + this._.slugify(this.componentName) + '.php');
      this.template('admin/libraries/_component-name.php', 'app/admin/libraries/' + this._.slugify(this.componentName) + '.php');
      this.template('admin/libraries/_ziparchive.php', 'app/admin/libraries/' + 'ziparchive' + '.php');
      this.template('admin/models/_gallery.php', 'app/admin/models/' + 'gallery' + '.php');
      this.template('admin/views/gallery/tmpl/default.php', 'app/admin/views/gallery/tmpl/' + 'default.php');
      this.template('admin/views/gallery/view.html.php', 'app/admin/views/gallery/' + '/view.html.php');
      this.template('admin/_component-name.php', 'app/admin/' + this._.slugify(this.componentName) + '.php');
      this.template('admin/_access.xml', 'app/admin/' + 'access.xml');
      this.template('admin/_config.xml', 'app/admin/' + 'config.xml');
      this.template('admin/controller.php', 'app/admin/' + 'controller.php');
      this.template('admin/releasenotes.txt', 'app/admin/' + 'releasenotes.txt');

      /*
       * Site files
       */
      this.template('site/helpers/route.php', 'app/site/helpers/' + 'route' + '.php');
      this.template('site/language/en-GB/en-GB.com_component-name.ini', 'app/site/' + 'language/en-GB/en-GB.com_' + this._.slugify(this.componentName) + '.ini');
      this.directory('site/lib', 'app/site/lib');
      this.template('site/models/gallery.php', 'app/site/models/' + 'gallery' + '.php');
      this.template('site/views/gallery/tmpl/default.php', 'app/site/views/gallery/tmpl/' + '/default.php');
      this.template('site/views/gallery/tmpl/default.xml', 'app/site/views/gallery/tmpl/' + '/default.xml');
      this.template('site/views/gallery/view.html.php', 'app/site/views/gallery/' + 'view.html.php');
      this.template('site/_component-name.php', 'app/site/' + this._.slugify(this.componentName) + '.php');
      this.template('site/controller.php', 'app/site/' + 'controller.php');
      this.template('site/router.php', 'app/site/' + 'router.php');
      this.template('_component-name.xml', 'app/' + this._.slugify(this.componentName) + '.xml');
      this.template('script.php', 'app/' + 'script.php');
      this.template('media/images/_component-name_menu.png', 'app/media/images/' + this._.slugify(this.componentName) + '_menu.png');
      this.template('media/images/_component-name_toolbar.png', 'app/media/images/' + this._.slugify(this.componentName) + '_toolbar.png');
      this.template('_Gruntfile.js', 'Gruntfile.js');
      done();
    };

    /*
     * files for extension type Com-intermediate
     */
    Generator.prototype._wcomInt = function() {
      var done;
      done = this.async();
      this._createEmptyMVCFolders();

      /*
       * files are located in templates/ext-com-intermediate
       * Admin files
       */
      this.template('admin/controllers/_component-name.php', 'app/admin/controllers/' + this._.slugify(this.componentName) + '.php');
      this.template('admin/controllers/_component-names.php', 'app/admin/controllers/' + this._.slugify(this.componentName) + 's' + '.php');
      this.template('admin/helpers/_component-name.php', 'app/admin/helpers/' + this._.slugify(this.componentName) + '.php');
      this.template('admin/language/en-GB/_en-GB.com_component-name.ini', 'app/admin/' + 'language/en-GB/en-GB.com_' + this._.slugify(this.componentName) + '.ini');
      this.template('admin/language/en-GB/_en-GB.com_component-name.sys.ini', 'app/admin/' + 'language/en-GB/en-GB.com_' + this._.slugify(this.componentName) + '.sys.ini');
      this.template('admin/models/fields/_component-name.php', 'app/admin/models/fields/' + this._.slugify(this.componentName) + '.php');
      this.template('admin/models/forms/_component-name.js', 'app/admin/models/forms/' + this._.slugify(this.componentName) + '.js');
      this.template('admin/models/forms/_component-name.xml', 'app/admin/models/forms/' + this._.slugify(this.componentName) + '.xml');
      this.template('admin/models/forms/_filter_component-name.xml', 'app/admin/models/forms/filter' + this._.slugify(this.componentName) + '.xml');
      this.template('admin/models/rules/greeting.php', 'app/admin/models/rules/' + 'greeting.php');
      this.template('admin/models/_component-name.php', 'app/admin/models/' + this._.slugify(this.componentName) + '.php');
      this.template('admin/models/_component-names.php', 'app/admin/models/' + this._.slugify(this.componentName) + 's' + '.php');
      this.template('admin/sql/_install.mysql.utf8.sql', 'app/admin/' + 'sql/install.mysql.utf8.sql');
      this.template('admin/sql/_uninstall.mysql.utf8.sql', 'app/admin/' + 'sql/uninstall.mysql.utf8.sql');
      this.template('admin/tables/_component-name.php', 'app/admin/tables/' + this._.slugify(this.componentName) + '.php');
      this.template('admin/views/_component-name/tmpl/edit.php', 'app/admin/views/' + this._.slugify(this.componentName) + '/tmpl/' + 'edit.php');
      this.template('admin/views/_component-name/submitbutton.js', 'app/admin/views/' + this._.slugify(this.componentName) + '/submitbutton.js');
      this.template('admin/views/_component-name/view.html.php', 'app/admin/views/' + this._.slugify(this.componentName) + '/view.html.php');
      this.template('admin/views/_component-names/tmpl/default.php', 'app/admin/views/' + this._.slugify(this.componentName) + 's' + '/tmpl/' + 'default.php');
      this.template('admin/views/_component-names/view.html.php', 'app/admin/views/' + this._.slugify(this.componentName) + 's' + '/view.html.php');
      this.template('admin/_component-name.php', 'app/admin/' + this._.slugify(this.componentName) + '.php');
      this.template('admin/_access.xml', 'app/admin/' + 'access.xml');
      this.template('admin/_config.xml', 'app/admin/' + 'config.xml');
      this.template('admin/controller.php', 'app/admin/' + 'controller.php');

      /*
       * Site files
       */
      this.template('site/language/en-GB/en-GB.com_component-name.ini', 'app/site/' + 'language/en-GB/en-GB.com_' + this._.slugify(this.componentName) + '.ini');
      this.template('site/models/_component-name.php', 'app/site/models/' + this._.slugify(this.componentName) + '.php');
      this.template('site/views/_component-name/tmpl/default.php', 'app/site/views/' + this._.slugify(this.componentName) + '/tmpl/' + 'default.php');
      this.template('site/views/_component-name/tmpl/default.xml', 'app/site/views/' + this._.slugify(this.componentName) + '/tmpl/' + 'default.xml');
      this.template('site/views/_component-name/view.html.php', 'app/site/views/' + this._.slugify(this.componentName) + '/view.html.php');
      this.template('site/_component-name.php', 'app/site/' + this._.slugify(this.componentName) + '.php');
      this.template('site/controller.php', 'app/site/' + 'controller.php');
      this.template('_component-name.xml', 'app/' + this._.slugify(this.componentName) + '.xml');
      this.template('script.php', 'app/' + 'script.php');
      this.template('_Gruntfile.js', 'Gruntfile.js');
      this.directory('media', 'app/media');
      this.directory('admin/sql/updates/', 'app/admin/sql/updates/');
      done();

      /*
       * files for extension type Com - advanced
       */
    };
    Generator.prototype._wcomAdv = function() {
      var done;
      done = this.async();
      this._createEmptyMVCFolders();

      /*
       * files are located in templates/ext-com-advanced
       * Admin files
       */
      this.template('admin/helpers/_component-name.php', 'app/admin/helpers/' + this._.slugify(this.componentName) + '.php');
      this.template('admin/language/en-GB/_en-GB.com_component-name.ini', 'app/admin/' + 'language/en-GB/en-GB.com_' + this._.slugify(this.componentName) + '.ini');
      this.template('admin/language/en-GB/_en-GB.com_component-name.sys.ini', 'app/admin/' + 'language/en-GB/en-GB.com_' + this._.slugify(this.componentName) + '.sys.ini');
      this.template('admin/libraries/_component-name.php', 'app/admin/libraries/' + this._.slugify(this.componentName) + '.php');
      this.template('admin/libraries/_component-name.php', 'app/admin/libraries/' + this._.slugify(this.componentName) + '.php');
      this.template('admin/libraries/_ziparchive.php', 'app/admin/libraries/' + 'ziparchive' + '.php');
      this.template('admin/models/_gallery.php', 'app/admin/models/' + 'gallery' + '.php');
      this.template('admin/views/gallery/tmpl/default.php', 'app/admin/views/gallery/tmpl/' + 'default.php');
      this.template('admin/views/gallery/view.html.php', 'app/admin/views/gallery/' + '/view.html.php');
      this.template('admin/_component-name.php', 'app/admin/' + this._.slugify(this.componentName) + '.php');
      this.template('admin/_access.xml', 'app/admin/' + 'access.xml');
      this.template('admin/_config.xml', 'app/admin/' + 'config.xml');
      this.template('admin/controller.php', 'app/admin/' + 'controller.php');
      this.template('admin/releasenotes.txt', 'app/admin/' + 'releasenotes.txt');

      /*
       * Site files
       */
      this.template('site/helpers/route.php', 'app/site/helpers/' + 'route' + '.php');
      this.template('site/language/en-GB/en-GB.com_component-name.ini', 'app/site/' + 'language/en-GB/en-GB.com_' + this._.slugify(this.componentName) + '.ini');
      this.directory('site/lib', 'app/site/lib');
      this.template('site/models/gallery.php', 'app/site/models/' + 'gallery' + '.php');
      this.template('site/views/gallery/tmpl/default.php', 'app/site/views/gallery/tmpl/' + '/default.php');
      this.template('site/views/gallery/tmpl/default.xml', 'app/site/views/gallery/tmpl/' + '/default.xml');
      this.template('site/views/gallery/view.html.php', 'app/site/views/gallery/' + 'view.html.php');
      this.template('site/_component-name.php', 'app/site/' + this._.slugify(this.componentName) + '.php');
      this.template('site/controller.php', 'app/site/' + 'controller.php');
      this.template('site/router.php', 'app/site/' + 'router.php');
      this.template('_component-name.xml', 'app/' + this._.slugify(this.componentName) + '.xml');
      this.template('script.php', 'app/' + 'script.php');
      this.template('media/images/_component-name_menu.png', 'app/media/images/' + this._.slugify(this.componentName) + '_menu.png');
      this.template('media/images/_component-name_toolbar.png', 'app/media/images/' + this._.slugify(this.componentName) + '_toolbar.png');
      this.template('_Gruntfile.js', 'Gruntfile.js');
      done();
    };

    /*
     * files for extension type Plg
     * files are located in templates/ext-plg
     */
    Generator.prototype._writingPlg = function() {
      var done, pluginfolder;
      done = this.async();
      pluginfolder = 'plg_' + this._.slugify(this.componentGroup) + '_' + this._.slugify(this.componentName) + '/';
      console.log('pluginfolder = ', pluginfolder);
      this.template('_Gruntfile.js', 'Gruntfile.js');
      this.template('_plugin-name.xml', 'app/' + pluginfolder + this._.slugify(this.componentName) + '.xml');
      this.template('language/en-GB/_en-GB.com_component-name.ini', 'app/' + pluginfolder + 'language/en-GB/en-GB.plg_' + this._.slugify(this.componentName) + '.ini');
      this.template('language/en-GB/_en-GB.com_component-name.sys.ini', 'app/' + pluginfolder + 'language/en-GB/en-GB.plg_' + this._.slugify(this.componentName) + '.sys.ini');
      this.template('_plugin-name.php', 'app/' + pluginfolder + this._.slugify(this.componentName) + '.php');
      this.template('_index.html', 'app/' + pluginfolder + '/index.html');
      this.template('_index.html', 'app/' + pluginfolder + 'language/' + '/index.html');
      this.template('_index.html', 'app/' + pluginfolder + 'language/en-GB/' + '/index.html');
      done();
    };

    /*
     * files for extension type Tpl
     */
    Generator.prototype._writingTpl = function() {
      var done;
      done = this.async();
      console.log('_writingTpl function');
      done();
    };

    /*
     * files for extension type Tpladmin
     */
    Generator.prototype._writingTpladmin = function() {
      var done;
      done = this.async();
      console.log('_writingTpladmin function');
      done();
    };

    /*
     * files for extension type Mod
     */
    Generator.prototype._writingMod = function() {
      var done;
      done = this.async();
      console.log('_writingMod function');
      done();
    };
    Generator.prototype._common = function() {
      this.template('_package.json', 'package.json');
      this.copy('../USAGE', 'USAGE');
      this.template('_bower.json', 'bower.json');
      return this.copy('_gitignore', '.gitignore');
    };
    Generator.prototype._getCurrentDate = function() {
      var dd, mm, today, yyyy;
      dd = void 0;
      mm = void 0;
      today = void 0;
      yyyy = void 0;
      dd = void 0;
      mm = void 0;
      today = void 0;
      yyyy = void 0;
      today = new Date();
      dd = today.getDate();
      mm = this._getCurrentMonthName();
      yyyy = today.getFullYear();
      if (dd < 10) {
        dd = '0' + dd;
      }
      if (mm < 10) {
        mm = '0' + mm;
      }
      today = dd + '-' + mm + '-' + yyyy;
      return today;
    };
    Generator.prototype._getCurrentMonthName = function() {
      var d, month, n;
      d = void 0;
      month = void 0;
      n = void 0;
      d = void 0;
      month = void 0;
      n = void 0;
      d = new Date();
      month = [];
      month[0] = 'January';
      month[1] = 'February';
      month[2] = 'March';
      month[3] = 'April';
      month[4] = 'May';
      month[5] = 'June';
      month[6] = 'July';
      month[7] = 'August';
      month[8] = 'September';
      month[9] = 'October';
      month[10] = 'November';
      month[11] = 'December';
      n = month[d.getMonth()];
      return n;
    };
    Generator.prototype._getCurrentYear = function() {
      var today, year, yyyy;
      today = void 0;
      year = void 0;
      yyyy = void 0;
      today = void 0;
      year = void 0;
      yyyy = void 0;
      today = new Date();
      yyyy = today.getFullYear();
      year = yyyy;
      return year;
    };
    Generator.prototype._projectfiles = function() {
      this.copy('editorconfig', '.editorconfig');
      return this.copy('jshintrc', '.jshintrc');
    };

    /*
     *  Create legacy files for fallback to Joomla 2.5x
     */
    Generator.prototype._createEmptyMVCFolders = function() {
      var emptyMVCFolders, folderName, i, len;
      emptyMVCFolders = void 0;
      folderName = void 0;
      i = void 0;
      len = void 0;
      emptyMVCFolders = void 0;
      folderName = void 0;
      i = void 0;
      len = void 0;
      emptyMVCFolders = ['app/admin/', 'app/site/', 'app/admin/' + 'controllers', 'app/site/' + 'controllers', 'app/admin/' + 'language', 'app/site/' + 'language', 'app/admin/' + 'language/en-GB/', 'app/site/' + 'language/en-GB/', 'app/admin/' + 'helpers', 'app/site/' + 'helpers', 'app/' + 'media', 'app/' + 'media/images/', 'app/admin/' + 'models', 'app/site/' + 'models', 'app/admin/' + 'models/fields/', 'app/site/' + 'models/fields/', 'app/admin/' + 'models/forms/', 'app/site/' + 'models/forms/', 'app/admin/' + 'models/rules/', 'app/site/' + 'models/rules/', 'app/admin/' + 'sql', 'app/site/' + 'sql', 'app/admin/' + 'sql/updates/', 'app/site/' + 'sql/updates/', 'app/admin/' + 'tables', 'app/site/' + 'tables', 'app/admin/' + 'views', 'app/site/' + 'views'];
      i = 0;
      len = emptyMVCFolders.length;
      while (i < len) {
        folderName = emptyMVCFolders[i];
        this.template('_index.html', folderName + '/index.html');
        i++;
      }
      return this.template('_index.html', 'app/' + 'index.html');
    };

    /*
     * Installation
     */
    Generator.prototype.install = function() {
      if (this.generator.installDependencies) {
        this.installDependencies({
          npm: true,
          bower: false
        });
      }
    };
    Generator.prototype.end = function() {
      this.log('');
      this.log(chalk.white('Your extension ' + chalk.yellow.bold(this.componentName) + chalk.white(' has been created!')));
      this.log('');
      this.log(chalk.white('Go here to download and install bitnami joomla for your system ' + chalk.cyan('https://bitnami.com/stack/joomla')));
      this.log(chalk.white('================================='));
      this.log('');
      this.log(chalk.white('To get a list of sub-generators type the following:'));
      this.log(chalk.white('yo joomla-spc --help'));
    };
  }).call(this);

}).call(this);

//# sourceMappingURL=index.js.map
