
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
    var ModelGenerator, extend, hasProp, path, yeoman;
    ModelGenerator = void 0;
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
    path = require('path');

    /*
    	@class ModelGenerator sub-generator for joomla spc controllers
     */
    module.exports = ModelGenerator = (function(superClass) {
      'var ModelGenerator';
      ModelGenerator = function(args, options, config) {
        var pkg, ref, ref1, ref2, ref3;
        pkg = void 0;
        ref = void 0;
        ref1 = void 0;
        ref2 = void 0;
        ref3 = void 0;
        ModelGenerator.__super__.constructor.call(this, args, options, config);
        pkg = JSON.parse(this.readFileAsString(path.join(process.cwd(), './package.json')));
        this.componentName = pkg.componentName;
        this.description = pkg.description;
        this.requireManageRights = pkg.requireManageRights;
        this.authorName = (ref = pkg.author) !== null ? ref.name : void 0;
        this.authorEmail = (ref1 = pkg.author) !== null ? ref1.email : void 0;
        this.authorURL = (ref2 = pkg.author) !== null ? ref2.url : void 0;
        this.license = (ref3 = pkg.licenses[0]) !== null ? ref3.type : void 0;
        this.currentYear = (new Date()).getFullYear();
        this.modelName = this._.slugify(this.name);
        this.modelClassName = this._.classify(this.name);
        console.log('You called the model subgenerator with the argument ' + this.name + '.\nNow let\'s create that model as models/' + this.modelName + '.php for you...');
      };
      extend(ModelGenerator, superClass);
      ModelGenerator.prototype.generateModel = function() {
        this.template('_model.php', 'app/admin/' + 'models/' + this.modelName + '.php');
        return this.template('_model.php', 'app/site/' + 'models/' + this.modelName + '.php');
      };
      return ModelGenerator;
    })(yeoman.generators.NamedBase);
  }).call(this);

}).call(this);

//# sourceMappingURL=index.js.map
