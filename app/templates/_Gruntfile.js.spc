module.exports = function(grunt) {
    require('time-grunt')(grunt);

    // Project configuration.
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        zip: {
            'using-cwd': {
                cwd: 'src/',
                // Files will zip with src as the root
                src: ['src/**'],
                dest: 'dist/com_<%= pkg.name %>_v<%= pkg.version %>.zip'
            }
        }

    });

    // Load the plugin that provides the task.

    grunt.loadNpmTasks('grunt-zip');

    // Default task(s).
    grunt.registerTask('default', ['zip']);

};