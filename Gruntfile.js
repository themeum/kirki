/* global module */
module.exports = function( grunt ) {

	grunt.initConfig( {

		// Compile CSS
		sass: {
			dist: {
				files: {
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
		}
	} );

	grunt.loadNpmTasks( 'grunt-contrib-sass' );
	grunt.loadNpmTasks( 'grunt-contrib-watch' );
	grunt.loadNpmTasks( 'grunt-wp-readme-to-markdown' );
	grunt.loadNpmTasks( 'grunt-jscs' );

	grunt.registerTask( 'dev', [ 'sass', 'jscs', 'watch' ] );
	grunt.registerTask( 'default', [ 'sass:dist', 'wp_readme_to_markdown' ] );
};
