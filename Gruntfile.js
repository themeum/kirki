'use strict';
module.exports = function(grunt) {

	grunt.initConfig({
		sass: {
			dist: {
				files: { 'assets/css/customizer.css' : 'assets/scss/customizer.scss' }
			}
		},
		concat: {
			options: {
				separator: '',
			},
			dist: {
				src: ['includes/controls/**/script.js'],
				dest: 'assets/js/customizer.js',
			},
		},
	});

	grunt.loadNpmTasks('grunt-contrib-sass');
	grunt.loadNpmTasks('grunt-contrib-concat');

	grunt.registerTask('default', ['sass', 'concat']);

};
