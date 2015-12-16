
/*

/*
	generator-joomla-spc

	index.coffee

	@author Sean

	@note Created on 2014-10-03 by PhpStorm
	@note uses Codoc
	@see https://github.com/mklabs/yeoman/wiki/generators coffeescript with yeoman
	@see https://github.com/coffeedoc/codo
 */

(function() {
  (function() {
    'use strict';
    var ControllerGenerator, chalk, extend, hasProp, path, yeoman, yosay;
    ControllerGenerator = void 0;
    path = void 0;
    yeoman = void 0;
    extend = function(child, parent) {
      var Ctor, key;
      Ctor = function() {
        this.constructor = child;
      };
      for (key in parent) {
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
    	@class ControllerGenerator sub-generator for joomla component controllers
     */
    module.exports = ControllerGenerator = (function(superClass) {
      'var ControllerGenerator';
      ControllerGenerator = function(args, options, config) {
        var pkg, ref, ref1, ref2, ref3;
        pkg = void 0;
        ref = void 0;
        ref1 = void 0;
        ref2 = void 0;
        ref3 = void 0;
        ControllerGenerator.__super__.constructor.call(this, args, options, config);
        pkg = JSON.parse(this.readFileAsString(path.join(process.cwd(), './package.json')));
        this.componentName = pkg.componentName;
        this.description = pkg.description;
        this.requireManageRights = pkg.requireManageRights;
        this.authorName = (ref = pkg.author) !== null ? ref.name : void 0;
        this.authorEmail = (ref1 = pkg.author) !== null ? ref1.email : void 0;
        this.authorURL = (ref2 = pkg.author) !== null ? ref2.url : void 0;
        this.license = (ref3 = pkg.licenses[0]) !== null ? ref3.type : void 0;
        this.currentYear = (new Date()).getFullYear();
        this.controllerClassName = this._.classify(this.name);
        this.log(yosay(chalk.white('You called the controller subgenerator with the argument ' + this.name + '.\nNow let\'s create that controller ' + this.controllerClassName + '.php for you...')));
      };
      extend(ControllerGenerator, superClass);
      ControllerGenerator.prototype.generateController = function() {
        this.template('_controller.php', 'app/admin/' + 'controllers/' + this.controllerClassName + '.php');
        return this.template('_controller.php', 'app/site/' + 'controllers/' + this.controllerClassName + '.php');
      };
      return ControllerGenerator;
    })(yeoman.generators.NamedBase);
  }).call(this);

}).call(this);

//# sourceMappingURL=index.js.map
