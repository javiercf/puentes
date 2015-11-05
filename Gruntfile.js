module.exports = function(grunt){
	require('grunt-task-loader')(grunt);
	grunt.initConfig({
		pkg : grunt.file.readJSON('package.json'),
		
		jshint: {
			all: ['Gruntfile.js', 'js/**/*.js']
		},

		wiredep: {
			task: {
				src: [
					'index.html',
					'scss/*.scss'
				]
			}
		},
		sass: {
			dist: {
				files: {
					'css/main.css':'scss/main.scss'
				}
			}

		},

		uglify: {
			mainjs : {
				'js/main.min.js':'js/main.js'
			}
		},

		autoprefixer: {
			single_file: {
				src: 'css/main.css'
			}
		},

		watch: {
			options: {
				livereload: true,
			},
			scripts: {
				files: 'js/*.js',
				tasks: 'jshint'
			},

			css: {
				files: 'scss/*.scss',
				tasks: ['sass', 'autoprefixer']
			},

			html: {
				files: '*.html'
			}

		},

		connect: {
			server: {
				options: {
					port: 9001
				}
			}
		}
	});

	grunt.registerTask('dev', ['connect', 'watch']);
};