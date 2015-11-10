
/*
	generator-joomla-component

	index.coffee

	@author Sean Goresht

	@note uses Codoc
	@see https://github.com/mklabs/yeoman/wiki/generators coffeescript with yeoman
	@see https://github.com/coffeedoc/codo
 */

(function() {
  "use strict";
  var ViewGenerator, path, yeoman,
    extend = function(child, parent) { for (var key in parent) { if (hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; },
    hasProp = {}.hasOwnProperty;

  yeoman = require("yeoman-generator");

  path = require("path");


  /*
  	@class ViewGenerator sub-generator for joomla component controllers
   */

  module.exports = ViewGenerator = (function(superClass) {
    extend(ViewGenerator, superClass);

    function ViewGenerator(args, options, config) {
      var pkg, ref, ref1, ref2, ref3;
      ViewGenerator.__super__.constructor.call(this, args, options, config);
      pkg = JSON.parse(this.readFileAsString(path.join(process.cwd(), "./package.json")));
      this.componentName = pkg.componentName;
      this.description = pkg.description;
      this.requireManageRights = pkg.requireManageRights;
      this.authorName = (ref = pkg.author) != null ? ref.name : void 0;
      this.authorEmail = (ref1 = pkg.author) != null ? ref1.email : void 0;
      this.authorURL = (ref2 = pkg.author) != null ? ref2.url : void 0;
      this.license = (ref3 = pkg.licenses[0]) != null ? ref3.type : void 0;
      this.currentDate = new Date().getFullYear();
      this.viewFolderName = this._.slugify(this.name);
      this.viewClassName = this._.classify(this.name);
      console.log("You called the view subgenerator with the argument " + this.name + ".\nNow let's create that view under the subdirectory views/" + this.viewFolderName + " for you...");
    }

    ViewGenerator.prototype.generateView = function() {
      this.template("_view.html.php", "src/" + ("views/" + this.viewFolderName + "/view.html.php"));
      return this.template("_default.php", "src/" + ("views/" + this.viewFolderName + "/default.php"));
    };

    return ViewGenerator;

  })(yeoman.generators.NamedBase);

}).call(this);
