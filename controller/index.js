
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
  "use strict";
  var ControllerGenerator, path, yeoman,
    extend = function(child, parent) { for (var key in parent) { if (hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; },
    hasProp = {}.hasOwnProperty;

  yeoman = require("yeoman-generator");

  path = require("path");


  /*
  	@class ControllerGenerator sub-generator for joomla component controllers
   */

  module.exports = ControllerGenerator = (function(superClass) {
    extend(ControllerGenerator, superClass);

    function ControllerGenerator(args, options, config) {
      var pkg, ref, ref1, ref2, ref3;
      ControllerGenerator.__super__.constructor.call(this, args, options, config);
      pkg = JSON.parse(this.readFileAsString(path.join(process.cwd(), "./package.json")));
      this.componentName = pkg.componentName;
      this.description = pkg.description;
      this.requireManageRights = pkg.requireManageRights;
      this.authorName = (ref = pkg.author) != null ? ref.name : void 0;
      this.authorEmail = (ref1 = pkg.author) != null ? ref1.email : void 0;
      this.authorURL = (ref2 = pkg.author) != null ? ref2.url : void 0;
      this.license = (ref3 = pkg.licenses[0]) != null ? ref3.type : void 0;
      this.currentYear = new Date().getFullYear();
      this.controllerClassName = this._.classify(this.name);
      console.log("You called the controller subgenerator with the argument " + this.name + ".\nNow let's create that controller " + this.controllerClassName + ".php for you...");
    }

    ControllerGenerator.prototype.generateController = function() {
      return this.template("_controller.php", "src/" + ("controllers/" + this.controllerClassName + ".php"));
    };

    return ControllerGenerator;

  })(yeoman.generators.NamedBase);

}).call(this);
