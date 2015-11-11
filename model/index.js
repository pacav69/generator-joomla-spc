
/*
	generator-joomla-spc

	index.coffee

	@author Sean Goresht

	@note uses Codoc
	@see https://github.com/mklabs/yeoman/wiki/generators coffeescript with yeoman
	@see https://github.com/coffeedoc/codo
 */

(function() {
  "use strict";
  var ModelGenerator, path, yeoman,
    extend = function(child, parent) { for (var key in parent) { if (hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; },
    hasProp = {}.hasOwnProperty;

  yeoman = require("yeoman-generator");

  path = require("path");


  /*
  	@class ModelGenerator sub-generator for joomla spc controllers
   */

  module.exports = ModelGenerator = (function(superClass) {
    extend(ModelGenerator, superClass);

    function ModelGenerator(args, options, config) {
      var pkg, ref, ref1, ref2, ref3;
      ModelGenerator.__super__.constructor.call(this, args, options, config);
      pkg = JSON.parse(this.readFileAsString(path.join(process.cwd(), "./package.json")));
      this.componentName = pkg.componentName;
      this.description = pkg.description;
      this.requireManageRights = pkg.requireManageRights;
      this.authorName = (ref = pkg.author) != null ? ref.name : void 0;
      this.authorEmail = (ref1 = pkg.author) != null ? ref1.email : void 0;
      this.authorURL = (ref2 = pkg.author) != null ? ref2.url : void 0;
      this.license = (ref3 = pkg.licenses[0]) != null ? ref3.type : void 0;
      this.currentYear = new Date().getFullYear();
      this.modelName = this._.slugify(this.name);
      this.modelClassName = this._.classify(this.name);
      console.log("You called the model subgenerator with the argument " + this.name + ".\nNow let's create that model as models/" + this.modelName + ".php for you...");
    }

    ModelGenerator.prototype.generateModel = function() {
      return this.template("_model.php", "src/" + ("models/" + this.modelName + ".php"));
    };

    return ModelGenerator;

  })(yeoman.generators.NamedBase);

}).call(this);
