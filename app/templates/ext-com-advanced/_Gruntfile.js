// grunt file for ext-com
module.exports = function(grunt) {
    require('time-grunt')(grunt);

    // Project configuration.
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        compress: {
            main: {
                options: {
                    mode: 'zip',
                    archive: 'dist/'+ "com_" + "<%= componentName %>" + "_v" + "<%= versionno %>" + '.zip'
                },
                expand: true,
                cwd: 'app/',
                src: ['**/*'],
                dest: ''
            }
        }

    });

    // Load the plugin that provides the task.

    grunt.loadNpmTasks('grunt-contrib-compress');

    // Default task(s).
    grunt.registerTask('default', ['compress']);

};