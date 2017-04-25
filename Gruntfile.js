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
					'modules/reset/reset.css':                      'modules/reset/reset.scss',
					'modules/tooltips/tooltip.css':                 'modules/tooltips/tooltip.scss',
					'modules/custom-sections/sections.css':         'modules/custom-sections/sections.scss',
					'modules/collapsible/collapsible.css':          'modules/collapsible/collapsible.scss',

					'controls/background/background.css':           'controls/background/background.scss',
					'controls/code/code.css':                       'controls/code/code.scss',
					'controls/color/color.css':                     'controls/color/color.scss',
					'controls/color-palette/color-palette.css':     'controls/color-palette/color-palette.scss',
					'controls/dashicons/dashicons.css':             'controls/dashicons/dashicons.scss',
					'controls/date/date.css':                       'controls/date/date.scss',
					'controls/dimension/dimension.css':             'controls/dimension/dimension.scss',
					'controls/dimensions/dimensions.css':           'controls/dimensions/dimensions.scss',
					'controls/editor/editor.css':                   'controls/editor/editor.scss',
					'controls/generic/generic.css':                 'controls/generic/generic.scss',
					'controls/multicheck/multicheck.css':           'controls/multicheck/multicheck.scss',
					'controls/multicolor/multicolor.css':           'controls/multicolor/multicolor.scss',
					'controls/number/number.css':                   'controls/number/number.scss',
					'controls/palette/palette.css':                 'controls/palette/palette.scss',
					'controls/preset/preset.css':                   'controls/preset/preset.scss',
					'controls/radio/radio.css':                     'controls/radio/radio.scss',
					'controls/radio-buttonset/radio-buttonset.css': 'controls/radio-buttonset/radio-buttonset.scss',
					'controls/radio-image/radio-image.css':         'controls/radio-image/radio-image.scss',
					'controls/repeater/repeater.css':               'controls/repeater/repeater.scss',
					'controls/select/select.css':                   'controls/select/select.scss',
					'controls/slider/slider.css':                   'controls/slider/slider.scss',
					'controls/sortable/sortable.css':               'controls/sortable/sortable.scss',
					'controls/switch/switch.css':                   'controls/switch/switch.scss',
					'controls/toggle/toggle.css':                   'controls/toggle/toggle.scss',
					'controls/typography/typography.css':           'controls/typography/typography.scss'
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
					'controls/**/*.scss',
					'modules/**/*.scss'
				],
				tasks: ['sass']
			},
			// scripts: {
			// 	files: [
			// 		'assets/**/*.js',
			// 		'Gruntfile.js'
			// 	],
			// 	tasks: ['jscs']
			// }
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

	grunt.registerTask( 'default', ['sass', 'curl:google-fonts-source', 'json2php', 'clean', 'wp_readme_to_markdown'] );
	grunt.registerTask( 'dev', ['sass', 'jscs', 'watch'] );
	grunt.registerTask( 'googlefonts', ['curl:google-fonts-source', 'json2php', 'clean'] );
	grunt.registerTask( 'readme', ['wp_readme_to_markdown'] );

};
