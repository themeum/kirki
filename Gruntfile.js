module.exports = function( grunt ) {

	grunt.initConfig({

		// Get json file from the google-fonts API
		curl: {
			'google-fonts-source': {
				src: 'https://www.googleapis.com/webfonts/v1/webfonts?sort=alpha&key=AIzaSyCDiOc36EIOmwdwspLG3LYwCg9avqC5YLs',
				dest: 'core/webfonts.json'
			}
		},

		// Compile CSS
		sass: {
			dist: {
				files: {
					'assets/css/customizer.css': 'assets/scss/customizer.scss',
					'controls/checkbox/checkbox.css': 'controls/checkbox/checkbox.scss',
					'controls/color/color.css': 'controls/color/color.scss',
					'controls/spacing/spacing.css': 'controls/spacing/spacing.scss',
					'controls/color-palette/color-palette.css': 'controls/color-palette/color-palette.scss',
					'controls/code/code.css': 'controls/code/code.scss'
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
				src: ['core/webfonts.json']
			}
		},

		// Check JS syntax
		jscs: {
		    src: [
                'Gruntfile.js',
				'assets/js/**/*.js',
				'controls/**/*.js',
                '!assets/js/**/*.min.js',
                '!assets/js/vendor/*'
            ],
		    options: {
		        config: '.jscsrc',
		        verbose: true
		    }
		},

		// Delete the json array
		clean: [
			'core/webfonts.json'
		],

		// Watch task (run with "grunt watch")
		watch: {
			css: {
				files: [
					'assets/**/*.scss',
					'controls/**/*.scss'
				],
				tasks: ['sass']
			},
			scripts: {
				files: [
					'assets/**/*.js',
					'Gruntfile.js'
				],
				tasks: ['jscs']
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

	grunt.registerTask( 'default', ['sass'] );
	grunt.registerTask( 'dev', ['sass', 'jscs', 'watch'] );
	grunt.registerTask( 'googlefonts', ['curl:google-fonts-source', 'json2php', 'clean'] );
	grunt.registerTask( 'readme', ['wp_readme_to_markdown'] );

};
