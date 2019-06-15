/* global module */
module.exports = function( grunt ) {

	grunt.initConfig( {

		// Get json file from the google-fonts API
		http: {
			'google-fonts-alpha': {
				options: { url: 'https://www.googleapis.com/webfonts/v1/webfonts?sort=alpha&key=AIzaSyCDiOc36EIOmwdwspLG3LYwCg9avqC5YLs' },
				dest: 'modules/webfonts/webfonts-alpha.json'
			},
			'google-fonts-popularity': {
				options: { url: 'https://www.googleapis.com/webfonts/v1/webfonts?sort=popularity&key=AIzaSyCDiOc36EIOmwdwspLG3LYwCg9avqC5YLs' },
				dest: 'modules/webfonts/webfonts-popularity.json'
			},
			'google-fonts-trending': {
				options: { url: 'https://www.googleapis.com/webfonts/v1/webfonts?sort=trending&key=AIzaSyCDiOc36EIOmwdwspLG3LYwCg9avqC5YLs' },
				dest: 'modules/webfonts/webfonts-trending.json'
			}
		},

		// Compile CSS
		sass: {
			dist: {
				files: {
					'assets/vendor/selectWoo/kirki.css': 'assets/vendor/selectWoo/kirki.scss',
					'modules/tooltips/tooltip.css': 'modules/tooltips/tooltip.scss',
					'modules/custom-sections/sections.css': 'modules/custom-sections/sections.scss',
					'controls/css/styles.css': 'controls/scss/styles.scss'
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
					'controls/scss/*.scss',
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

					'controls/js/src/background.js',
					'controls/js/src/color-palette.js',
					'controls/js/src/dashicons.js',
					'controls/js/src/date.js',
					'controls/js/src/dimension.js',
					'controls/js/src/dimensions.js',
					'controls/js/src/editor.js',
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
	grunt.loadNpmTasks( 'grunt-http' );
	grunt.loadNpmTasks( 'grunt-wp-readme-to-markdown' );
	grunt.loadNpmTasks( 'grunt-jscs' );

	grunt.registerTask( 'dev', [ 'sass', 'jscs', 'watch' ] );
	grunt.registerTask( 'googlefontsProcess', function() {
		var alphaFonts,
			popularityFonts,
			trendingFonts,
			finalObject = {
				items: {},
				order: {
					popularity: [],
					trending: []
				}
			},
			finalJSON,
			i,
			fontFiles = {};
			fontNames = [];

		// Get file contents.
		alphaFonts      = grunt.file.readJSON( 'modules/webfonts/webfonts-alpha.json' );
		popularityFonts = grunt.file.readJSON( 'modules/webfonts/webfonts-popularity.json' );
		trendingFonts   = grunt.file.readJSON( 'modules/webfonts/webfonts-trending.json' );

		// Populate the fonts.
		for ( i = 0; i < alphaFonts.items.length; i++ ) {
			finalObject.items[ alphaFonts.items[ i ].family ] = {
				family: alphaFonts.items[ i ].family,
				category: alphaFonts.items[ i ].category,
				variants: alphaFonts.items[ i ].variants.sort()

				/* Deprecated
				subsets: alphaFonts.items[ i ].subsets.sort(),
				files: alphaFonts.items[ i ].files
				*/
			};
		}

		// Add the popularity order.
		for ( i = 0; i < popularityFonts.items.length; i++ ) {
			finalObject.order.popularity.push( popularityFonts.items[ i ].family );
			fontNames.push( popularityFonts.items[ i ].family );
		}

		// Add the rrending order.
		for ( i = 0; i < trendingFonts.items.length; i++ ) {
			finalObject.order.trending.push( trendingFonts.items[ i ].family );
		}

		// Generate the font-files object.
		for ( i = 0; i < popularityFonts.items.length; i++ ) {
			fontFiles[ popularityFonts.items[ i ].family ] = popularityFonts.items[ i ].files;
		}

		// Write the final object to json.
		finalJSON = JSON.stringify( finalObject );
		grunt.file.write( 'modules/webfonts/webfonts.json', finalJSON );
		grunt.file.write( 'modules/webfonts/webfont-names.json', JSON.stringify( fontNames ) );
		grunt.file.write( 'modules/webfonts/webfont-files.json', JSON.stringify( fontFiles ) );

		// Delete files no longer needed.
		grunt.file.delete( 'modules/webfonts/webfonts-alpha.json' ); // jshint ignore:line
		grunt.file.delete( 'modules/webfonts/webfonts-popularity.json' ); // jshint ignore:line
		grunt.file.delete( 'modules/webfonts/webfonts-trending.json' ); // jshint ignore:line
	} );
	grunt.registerTask( 'googlefonts', function() {
		grunt.task.run( 'http' );
		grunt.task.run( 'googlefontsProcess' );
	} );
	grunt.registerTask( 'default', [ 'sass:dist', 'concat', 'uglify' ] );
	grunt.registerTask( 'readme', [ 'wp_readme_to_markdown' ] );
	grunt.registerTask( 'all', [ 'default', 'googlefonts', 'wp_readme_to_markdown' ] );
};
