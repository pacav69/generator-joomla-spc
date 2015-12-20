
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
    'use strict';
    var HelperGenerator, chalk, extend, hasProp, path, yeoman, yosay;
    HelperGenerator = void 0;
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
    	@class HelperGenerator sub-generator for joomla spc controllers
     */
    module.exports = HelperGenerator = (function(superClass) {
      'var HelperGenerator';
      HelperGenerator = function(args, options, config) {
        var pkg, ref, ref1, ref2, ref3;
        pkg = void 0;
        ref = void 0;
        ref1 = void 0;
        ref2 = void 0;
        ref3 = void 0;
        HelperGenerator.__super__.constructor.call(this, args, options, config);
        pkg = JSON.parse(this.readFileAsString(path.join(process.cwd(), './package.json')));
        this.componentName = pkg.componentName;
        this.description = pkg.description;
        this.requireManageRights = pkg.requireManageRights;
        this.authorName = (ref = pkg.author) !== null ? ref.name : void 0;
        this.authorEmail = (ref1 = pkg.author) !== null ? ref1.email : void 0;
        this.authorURL = (ref2 = pkg.author) !== null ? ref2.url : void 0;
        this.license = (ref3 = pkg.licenses[0]) !== null ? ref3.type : void 0;
        this.currentYear = (new Date()).getFullYear();
        this.helperName = this._.slugify(this.name);
        this.helperClassName = this._.classify(this.name);
        this.log('You called the helper subgenerator with the argument ' + this.name + '.\nNow let\'s create that helper as helpers/' + this.helperName + '.php for you...');
      };
      extend(HelperGenerator, superClass);
      HelperGenerator.prototype.generateHelper = function() {
        this.template('_helper.php', 'app/admin/helpers/' + this.helperName + '.php');
        return this.template('_helper.php', 'app/site/helpers/' + this.helperName + '.php');
      };
      return HelperGenerator;
    })(yeoman.generators.NamedBase);
  }).call(this);

}).call(this);

//# sourceMappingURL=index.js.map
