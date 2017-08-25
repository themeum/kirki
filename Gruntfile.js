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
					'modules/reset/reset.css':                      'modules/reset/reset.scss',
					'modules/tooltips/tooltip.css':                 'modules/tooltips/tooltip.scss',
					'modules/custom-sections/sections.css':         'modules/custom-sections/sections.scss',
					'modules/collapsible/collapsible.css':          'modules/collapsible/collapsible.scss'
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
					'controls/**/*.scss',
					'modules/**/*.scss'
				],
				tasks: ['sass']
			},
			scripts: {
				files: [
					'Gruntfile.js',
					'controls/**/*.js',
					'modules/**/*.js'
				],
				tasks: ['jscs']
			}
		},

		uglify: {
			options: {
				mangle: false
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

	grunt.registerTask( 'default', ['sass:dist', 'curl:google-fonts-source', 'json2php', 'clean', 'wp_readme_to_markdown'] );
	grunt.registerTask( 'dev', ['sass', 'jscs', 'watch'] );
	grunt.registerTask( 'googlefonts', ['curl:google-fonts-source', 'json2php', 'clean'] );
	grunt.registerTask( 'readme', ['wp_readme_to_markdown'] );

};
