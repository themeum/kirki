'use strict';
module.exports = function(grunt) {

	grunt.initConfig({
		sass: {
			dist: {
				files: [
					{
						expand: true,
						cwd: 'includes/controls/',
						src: ['**/*.scss'],
						dest: 'includes/controls/',
						ext: '.css'
					},
					{
						'assets/css/customizer.css': 'assets/css/customizer.scss'
					},
					{
						'assets/css/production.css': 'assets/css/production.scss'
					}
				]
			}
		}
	});

	grunt.loadNpmTasks('grunt-contrib-sass');
	grunt.registerTask('default', ['sass']);

};
