/* global module */
module.exports = function( grunt ) {

	grunt.initConfig({

		// Get json file from the google-fonts API
		curl: {
			'google-fonts-source': {
				src: 'https://www.googleapis.com/webfonts/v1/webfonts?sort=alpha&key=AIzaSyCDiOc36EIOmwdwspLG3LYwCg9avqC5YLs',
				dest: 'modules/webfonts/webfonts.json'
			}
		},

		// Compile CSS
		sass: {
			dist: {
				files: {
					'assets/vendor/selectWoo/kirki.css': 'assets/vendor/selectWoo/kirki.scss',
					'modules/tooltips/tooltip.css': 'modules/tooltips/tooltip.scss',
					'modules/custom-sections/sections.css': 'modules/custom-sections/sections.scss',
					'modules/collapsible/collapsible.css': 'modules/collapsible/collapsible.scss',
					'controls/css/styles.css': 'controls/scss/styles.scss'
				}
			},

			customBuild: {
				dist: {
					options: {
						style: 'compressed'
					},
					files: {
						'build.css': 'build.scss'
					}
				}
			}
		},

		// Convert readme.txt to readme.md
		wp_readme_to_markdown: {
			your_target: {
				files: {
					'README.md': 'readme.txt'
				}
			}
		},

		// Convert json array to PHP array
		json2php: {
			convert: {
				expand: true,
				ext: '.php',
				src: ['modules/webfonts/webfonts.json']
			}
		},

		// Check JS syntax
		jscs: {
			src: [
				'Gruntfile.js',
				'controls/**/*.js',
				'modules/**/*.js',
				'!modules/search/fuse.js',
				'!modules/search/fuse.min.js',
				'!assets/vendor/*'
			],
			options: {
				config: '.jscsrc',
				verbose: true
			}
		},

		// Delete the json array
		clean: [
			'modules/webfonts/webfonts.json'
		],

		// Watch task (run with "grunt watch")
		watch: {
			css: {
				files: [
					'assets/**/*.scss',
					'controls/scss/*.scss',
					'modules/**/*.scss'
				],
				tasks: ['sass']
			},
			scripts: {
				files: [
					'Gruntfile.js',
					'controls/js/src/*.js',
					'modules/**/*.js'
				],
				tasks: ['concat', 'uglify']
			}
		},

		concat: {
			options: {
				separator: ';'
			},
			dist: {
				src: [
					'controls/js/src/set-setting-value.js',
					'controls/js/src/dynamic-control.js',

					'controls/js/src/background.js',
					'controls/js/src/code.js',
					'controls/js/src/color-palette.js',
					'controls/js/src/color.js',
					'controls/js/src/dashicons.js',
					'controls/js/src/date.js',
					'controls/js/src/dimension.js',
					'controls/js/src/dimensions.js',
					'controls/js/src/editor.js',
					'controls/js/src/fontawesome.js',
					'controls/js/src/generic.js',
					'controls/js/src/image.js',
					'controls/js/src/multicheck.js',
					'controls/js/src/multicolor.js',
					'controls/js/src/number.js',
					'controls/js/src/palette.js',
					'controls/js/src/preset.js',
					'controls/js/src/radio-buttonset.js',
					'controls/js/src/radio-image.js',
					'controls/js/src/radio.js',
					'controls/js/src/repeater.js',
					'controls/js/src/select.js',
					'controls/js/src/slider.js',
					'controls/js/src/sortable.js',
					'controls/js/src/switch.js',
					'controls/js/src/toggle.js',
					'controls/js/src/typography.js'
				],
				dest: 'controls/js/dist/script.js'
			},
			legacy: {
				src: [
					'controls/js/src/set-setting-value.js',
					'controls/js/src/dynamic-control.js',

					'controls/js/src/background-legacy.js',
					'controls/js/src/code.js',
					'controls/js/src/color-palette.js',
					'controls/js/src/color.js',
					'controls/js/src/dashicons.js',
					'controls/js/src/date.js',
					'controls/js/src/dimension.js',
					'controls/js/src/dimensions.js',
					'controls/js/src/editor.js',
					'controls/js/src/fontawesome.js',
					'controls/js/src/generic.js',
					'controls/js/src/image.js',
					'controls/js/src/multicheck.js',
					'controls/js/src/multicolor-legacy.js',
					'controls/js/src/number.js',
					'controls/js/src/palette.js',
					'controls/js/src/preset.js',
					'controls/js/src/radio-buttonset.js',
					'controls/js/src/radio-image.js',
					'controls/js/src/radio.js',
					'controls/js/src/repeater.js',
					'controls/js/src/select.js',
					'controls/js/src/slider.js',
					'controls/js/src/sortable.js',
					'controls/js/src/switch.js',
					'controls/js/src/toggle.js',
					'controls/js/src/typography-legacy.js'
				],
				dest: 'controls/js/dist/script-legacy.js'
			}
		},

		uglify: {
			dev: {
				options: {
					mangle: {
						reserved: ['jQuery', 'wp', '_']
					}
				},
				files: [{
					expand: true,
					src: ['controls/js/dist/*.js', '!controls/js/dist/*.min.js'],
					dest: '.',
					cwd: '.',
					rename: function( dst, src ) {
						return dst + '/' + src.replace( '.js', '.min.js' );
					}
				}]
			}
		}
	});

	grunt.loadNpmTasks( 'grunt-contrib-sass' );
	grunt.loadNpmTasks( 'grunt-contrib-concat' );
	grunt.loadNpmTasks( 'grunt-contrib-uglify' );
	grunt.loadNpmTasks( 'grunt-contrib-watch' );
	grunt.loadNpmTasks( 'grunt-curl' );
	grunt.loadNpmTasks( 'grunt-wp-readme-to-markdown' );
	grunt.loadNpmTasks( 'grunt-json2php' );
	grunt.loadNpmTasks( 'grunt-contrib-clean' );
	grunt.loadNpmTasks( 'grunt-jscs' );

	grunt.registerTask( 'default', ['sass:dist', 'concat', 'uglify', 'curl:google-fonts-source', 'json2php', 'clean', 'wp_readme_to_markdown'] );
	grunt.registerTask( 'dev', ['sass', 'jscs', 'watch'] );
	grunt.registerTask( 'googlefonts', ['curl:google-fonts-source', 'json2php', 'clean'] );
	grunt.registerTask( 'readme', ['wp_readme_to_markdown'] );
	grunt.registerTask( 'customBuild', ['sass:customBuild', 'uglify:customBuild'] );

};
