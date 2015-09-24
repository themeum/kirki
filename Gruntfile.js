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
		uglify: {
			options: {
				compress: {},
				mangle: true,
				sourceMap: true
			},
			target: {
				src: 'assets/js/customizer.js',
				dest: 'assets/js/customizer.min.js'
			}
		},
		cssmin: {
			options: {
				shorthandCompacting: false,
				roundingPrecision: -1
			},
			target: {
				files: {
					'assets/css/customizer.min.css': 'assets/css/customizer.css'
				}
			}
		}
	});

	grunt.loadNpmTasks('grunt-contrib-sass');
	grunt.loadNpmTasks('grunt-contrib-concat');
	grunt.loadNpmTasks('grunt-contrib-uglify');
	grunt.loadNpmTasks('grunt-contrib-cssmin');

	grunt.registerTask('default', ['sass', 'concat', 'uglify', 'cssmin']);

};
