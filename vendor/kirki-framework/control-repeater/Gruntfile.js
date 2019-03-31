/* global module */
module.exports = function( grunt ) {

	grunt.initConfig( {

		// Compile CSS
		sass: {
			dist: {
				files: {
					'src/assets/styles/style.css': 'src/assets/styles/style.scss'
				}
			}
		},

		// Watch task (run with "grunt watch")
		watch: {
			css: {
				files: [
					'src/assets/styles/*.scss'
				],
				tasks: [ 'sass' ]
			}
		}
	} );

	grunt.loadNpmTasks( 'grunt-contrib-sass' );
	grunt.loadNpmTasks( 'grunt-contrib-watch' );

	grunt.registerTask( 'default', [ 'sass:dist' ] );
};
