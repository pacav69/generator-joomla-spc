module.exports = function(grunt) {
	require('time-grunt')(grunt);
  var chalk = require('chalk');

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
    watch: {

                src: {
                    files: ['src/indexapp.coffee', 'src/controller/index.coffee','src/helper/index.coffee','src/model/index.coffee','src/view/index.coffee'],
                    tasks: ['coffeelint','coffee','jshint'],
            }
    },
    attention: {
       watching: {
        options: {
          message: chalk.bold.yellow('watch started: ') +
            chalk.inverse.yellow('watching coffee files'),
          borderColor: 'bgGreen'
        }
      }
    },
      coffeelint: {
      app: ['src/indexapp.coffee','src/controller/index.coffee', 'src/helper/index.coffee','src/model/index.coffee','src/view/index.coffee'],
    },
    jshint: {
      all: ['Gruntfile.js', 'app/index.js', 'controller/index.js','helper/index.js','model/index.js','view/index.js']
    },
    coffee: {
      compileWithMaps: {
        options: {
          sourceMap: true
        },
  	    files: {
  	      'app/index.js': 'src/indexapp.coffee', // 1:1 compile
          'controller/index.js': 'src/controller/index.coffee',
          'helper/index.js': 'src/helper/index.coffee',
          'model/index.js': 'src/model/index.coffee',
          'view/index.js': 'src/view/index.coffee'
  	      //'path/to/another.js': ['path/to/sources/*.coffee', 'path/to/more/*.coffee'] // compile and concat into single file
  	    	}
		}
	 }
  });

  // Load the plugin that provides the "uglify" task.
  grunt.loadNpmTasks('grunt-attention');
  grunt.loadNpmTasks('grunt-contrib-uglify');
  grunt.loadNpmTasks('grunt-contrib-coffee');
  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-coffeelint');
  grunt.loadNpmTasks('grunt-contrib-jshint');




  // Default task(s).
  // grunt.registerTask('default', ['uglify']);
  grunt.registerTask('default', ['attention','watch']);

};
