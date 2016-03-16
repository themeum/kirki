'use strict';
module.exports = function(grunt) {

	grunt.initConfig({
		// Get json file from the google-fonts API
		curl: {
			'google-fonts-source': {
				src: 'https://www.googleapis.com/webfonts/v1/webfonts?sort=alpha&key=AIzaSyCDiOc36EIOmwdwspLG3LYwCg9avqC5YLs',
				dest: 'assets/json/webfonts.json'
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
				src: [
					'assets/js/kirki-functions.js',
					'assets/js/controls/*.js'
				],
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
					domainPath: 'languages',
					exclude: [
						'tests/.*'
					]
				}
			}
		},
		// Convert readme.txt to readme.md
		wp_readme_to_markdown: {
			your_target: {
				files: {
					'README.md': 'readme.txt'
				},
			},
		},
		// Watch task (run with "grunt watch")
  		watch: {
			css: {
				files: 'assets/**/*.scss',
				tasks: ['sass', 'cssmin'],
			},
			scripts: {
				files: 'assets/**/*.js',
				tasks: ['concat', 'uglify'],
			},
			readme: {
				files: 'readme.txt',
				tasks: ['wp_readme_to_markdown'],
			}
		}
	});

	grunt.loadNpmTasks('grunt-contrib-sass');
	grunt.loadNpmTasks('grunt-contrib-concat');
	grunt.loadNpmTasks('grunt-contrib-uglify');
	grunt.loadNpmTasks('grunt-contrib-cssmin');
	grunt.loadNpmTasks('grunt-wp-i18n');
	grunt.loadNpmTasks('grunt-contrib-watch');
	grunt.loadNpmTasks('grunt-curl');
	grunt.loadNpmTasks('grunt-wp-readme-to-markdown');

	grunt.registerTask('default', ['sass', 'concat', 'uglify', 'cssmin', 'makepot', 'wp_readme_to_markdown']);
	grunt.registerTask('googlefonts', ['curl:google-fonts-source']);

};
