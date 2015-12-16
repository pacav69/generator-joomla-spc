
/*
  generator-joomla-spc

  index.coffee

  @author Sean Goresht

  @note uses Codoc
  @see https://github.com/mklabs/yeoman/wiki/generators coffeescript with yeoman
  @see https://github.com/coffeedoc/codo
 */

(function() {
  (function() {
    (function() {
      (function() {
        'use strict';
        var ViewGenerator, chalk, extend, hasProp, path, yeoman, yosay;
        ViewGenerator = void 0;
        extend = void 0;
        hasProp = void 0;
        path = void 0;
        yeoman = void 0;
        ViewGenerator = void 0;
        extend = void 0;
        hasProp = void 0;
        path = void 0;
        yeoman = void 0;
        ViewGenerator = void 0;
        path = void 0;
        yeoman = void 0;
        extend = function(child, parent) {
          var Ctor, key;
          Ctor = void 0;
          key = void 0;
          Ctor = void 0;
          key = void 0;
          Ctor = function() {
            this.constructor = child;
          };
          for (key in parent) {
            key = key;
            key = key;
            if (hasProp.call(parent, key)) {
              child[key] = parent[key];
            }
          }
          Ctor.prototype = parent.prototype;
          child.prototype = new Ctor();
          child.__super__ = parent.prototype;
          return child;
        };
        hasProp = {}.hasOwnProperty;
        yeoman = require('yeoman-generator');
        yosay = require('yosay');
        chalk = require('chalk');
        path = require('path');

        /*
          @class ViewGenerator sub-generator for joomla component controllers
         */
        module.exports = ViewGenerator = (function(superClass) {
          'var ViewGenerator';
          ViewGenerator = function(args, options, config) {
            var pkg, ref, ref1, ref2, ref3;
            pkg = void 0;
            ref = void 0;
            ref1 = void 0;
            ref2 = void 0;
            ref3 = void 0;
            pkg = void 0;
            ref = void 0;
            ref1 = void 0;
            ref2 = void 0;
            ref3 = void 0;
            pkg = void 0;
            ref = void 0;
            ref1 = void 0;
            ref2 = void 0;
            ref3 = void 0;
            ViewGenerator.__super__.constructor.call(this, args, options, config);
            pkg = JSON.parse(this.readFileAsString(path.join(process.cwd(), './package.json')));
            this.componentName = pkg.componentName;
            this.description = pkg.description;
            this.requireManageRights = pkg.requireManageRights;
            this.authorName = (ref = pkg.author) !== null ? ref.name : void 0;
            this.authorEmail = (ref1 = pkg.author) !== null ? ref1.email : void 0;
            this.authorURL = (ref2 = pkg.author) !== null ? ref2.url : void 0;
            this.license = (ref3 = pkg.licenses[0]) !== null ? ref3.type : void 0;
            this.currentYear = (new Date()).getFullYear();
            this.viewFolderName = this._.slugify(this.name);
            this.viewClassName = this._.classify(this.name);
            this.log(yosay(chalk.white('You called the view subgenerator with the argument ' + this.name + '.\nNow let\'s create that view under the subdirectory views/' + this.viewFolderName + ' for you...')));
          };
          extend(ViewGenerator, superClass);
          ViewGenerator.prototype.generateView = function() {
            this.template('_view.html.php', 'app/admin/' + ("views/" + this.viewFolderName + "/view.html.php"));
            this.template('_default.php', 'app/admin/' + ("views/" + this.viewFolderName + "/default.php"));
            this.template('_view.html.php', 'app/site/' + 'views/' + this.viewFolderName + '/view.html.php');
            this.template('_default.php', 'app/site/' + ("views/" + this.viewFolderName + "/view.html.php"));
          };
          return ViewGenerator;
        })(yeoman.generators.NamedBase);
      }).call(this);
    }).call(this);
  }).call(this);

}).call(this);

//# sourceMappingURL=index.js.map
