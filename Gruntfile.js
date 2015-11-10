module.exports = function(grunt) {
	require('time-grunt')(grunt);

  // Project configuration.
  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),
    uglify: {
      options: {
        banner: '/*! <%= pkg.name %> <%= grunt.template.today("yyyy-mm-dd") %> */\n'
      },
      build: {
        src: 'src/<%= pkg.name %>.js',
        dest: 'build/<%= pkg.name %>.min.js'
      }
    },
    coffee: {
	  	compile: {
	    files: {
	      'app/index.js': 'app/index.coffee', // 1:1 compile
        'controller/index.js': 'controller/index.coffee',
        'helper/index.js': 'helper/index.coffee',
        'model/index.js': 'model/index.coffee',
        'view/index.js': 'view/index.coffee'
	      //'path/to/another.js': ['path/to/sources/*.coffee', 'path/to/more/*.coffee'] // compile and concat into single file
	    	}
		}
	}
  });

  // Load the plugin that provides the "uglify" task.
  grunt.loadNpmTasks('grunt-contrib-uglify');
  grunt.loadNpmTasks('grunt-contrib-coffee');

  // Default task(s).
  // grunt.registerTask('default', ['uglify']);
  grunt.registerTask('default', ['coffee']);

};
