module.exports = function(grunt) {
    require('time-grunt')(grunt);

    // Project configuration.
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        compress: {
            main: {
                options: {
                    mode: 'zip',
                    archive: 'dist/' + 'com_default-value_v1.0.0.zip'
                },
                expand: true,
                cwd: 'src/',
                src: ['**/*'],
                dest: ''
            }
        }
        // zip: {
        //     'using-cwd': {
        //         cwd: 'src/',
        //         // Files will zip with src as the root
        //         src: ['src/**'],
        //         dest: 'dist/com_default-value_v1.0.0.zip'
        //     }
        // }

    });

    // Load the plugin that provides the task.

    grunt.loadNpmTasks('grunt-contrib-compress');

    // Default task(s).
    grunt.registerTask('default', ['compress']);

};