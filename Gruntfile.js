'use strict';
module.exports = function(grunt) {

	grunt.initConfig({
		// Get json file from the google-fonts API
		curl: {
			'google-fonts-source': {
				src: 'https://www.googleapis.com/webfonts/v1/webfonts?key=AIzaSyCDiOc36EIOmwdwspLG3LYwCg9avqC5YLs',
				dest: 'assets/json/webfonts.json'
			}
		},
		// jshint
		jshint: {
			files: [
				'assets/js/**/*.js'
			],
			options: {
				expr: true,
				globals: {
					jQuery: true,
					console: true,
					module: true,
					document: true
				}
			}
		},
		phpdocumentor: {
			dist: {
				options: {
					ignore: 'node_modules'
				}
			}
		},
		// Compile CSS
		sass: {
			dist: {
				files: { 'assets/css/customizer.css' : 'assets/scss/customizer.scss' }
			}
		},
		// Combine JS files
		concat: {
			options: {
				separator: '',
			},
			dist: {
				src: ['assets/js/controls/*.js'],
				dest: 'assets/js/customizer.js',
			},
		},
		// Minify JS
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
		// Minify CSS
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
		},
		// Generate translation file
		makepot: {
			target: {
				options: {
					type: 'wp-plugin',
					domainPath: 'languages'
				}
			}
		},
		watch: {
			files: ['assets/**/*.scss', 'assets/**/*.js'],
			tasks: ['sass', 'concat', 'uglify', 'cssmin']
		}
	});

	grunt.loadNpmTasks('grunt-contrib-sass');
	grunt.loadNpmTasks('grunt-contrib-concat');
	grunt.loadNpmTasks('grunt-contrib-uglify');
	grunt.loadNpmTasks('grunt-contrib-cssmin');
	grunt.loadNpmTasks('grunt-wp-i18n');
	grunt.loadNpmTasks('grunt-contrib-watch');
	grunt.loadNpmTasks('grunt-contrib-jshint');
	grunt.loadNpmTasks('grunt-curl');
	grunt.loadNpmTasks('grunt-phpdocumentor');

	grunt.registerTask('default', ['sass', 'concat', 'uglify', 'cssmin', 'makepot']);
	grunt.registerTask('docs', ['phpdocumentor:dist']);
	grunt.registerTask('googlefonts', ['curl:google-fonts-source']);

};
