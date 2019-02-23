/* global module */
module.exports = function( grunt ) {

	grunt.initConfig( {

		// Compile CSS
		sass: {
			dist: {
				files: {
					'assets/vendor/selectWoo/kirki.css': 'assets/vendor/selectWoo/kirki.scss',
					'modules/tooltips/tooltip.css': 'modules/tooltips/tooltip.scss',
					'modules/custom-sections/sections.css': 'modules/custom-sections/sections.scss'
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

		// Watch task (run with "grunt watch")
		watch: {
			css: {
				files: [
					'assets/**/*.scss',
					'modules/**/*.scss'
				],
				tasks: [ 'sass' ]
			},
			scripts: {
				files: [
					'Gruntfile.js',
					'controls/js/src/*.js',
					'modules/**/*.js'
				],
				tasks: [ 'concat', 'uglify' ]
			}
		},

		concat: {
			options: {
				separator: ''
			},
			dist: {
				src: [
					'controls/js/src/set-setting-value.js',
					'controls/js/src/kirki.js',
					'controls/js/src/kirki.control.js',
					'controls/js/src/kirki.input.js',
					'controls/js/src/kirki.setting.js',
					'controls/js/src/kirki.util.js',
					'controls/js/src/dynamic-control.js',

					'controls/js/src/dashicons.js',
					'controls/js/src/date.js',
					'controls/js/src/dimension.js',
					'controls/js/src/dimensions.js',
					'controls/js/src/editor.js',
					'controls/js/src/fontawesome.js',
					'controls/js/src/multicheck.js',
					'controls/js/src/multicolor.js',
					'controls/js/src/number.js',
					'controls/js/src/palette.js',
					'controls/js/src/radio-buttonset.js',
					'controls/js/src/radio-image.js',
					'controls/js/src/repeater.js',
					'controls/js/src/slider.js',
					'controls/js/src/sortable.js',
					'controls/js/src/switch.js',
					'controls/js/src/toggle.js',
					'controls/js/src/typography.js'
				],
				dest: 'controls/js/script.js'
			}
		},

		uglify: {
			dev: {
				options: {
					mangle: {
						reserved: [ 'jQuery', 'wp', '_' ]
					}
				},
				files: [ {
					expand: true,
					src: [ 'controls/js/*.js', '!controls/js/*.min.js' ],
					dest: '.',
					cwd: '.',
					rename: function( dst, src ) {
						return dst + '/' + src.replace( '.js', '.min.js' );
					}
				} ]
			}
		}
	} );

	grunt.loadNpmTasks( 'grunt-contrib-sass' );
	grunt.loadNpmTasks( 'grunt-contrib-concat' );
	grunt.loadNpmTasks( 'grunt-contrib-uglify' );
	grunt.loadNpmTasks( 'grunt-contrib-watch' );
	grunt.loadNpmTasks( 'grunt-wp-readme-to-markdown' );
	grunt.loadNpmTasks( 'grunt-jscs' );

	grunt.registerTask( 'dev', [ 'sass', 'jscs', 'watch' ] );
	grunt.registerTask( 'default', [ 'sass:dist', 'concat', 'uglify' ] );
	grunt.registerTask( 'readme', [ 'wp_readme_to_markdown' ] );
	grunt.registerTask( 'all', [ 'default', 'wp_readme_to_markdown' ] );
};
