module.exports = function( grunt ) {

	// Unobtrusive JSON reader.
	function readJSON( filepath ) {
		var data = {};
		try {
			data = grunt.file.readJSON( filepath );
		} catch (e) {}
		return data;
	}

	// HTML minifier algorithm.
	function minifyHTML( src ) {
		return src
			.replace( /(^\s+|\s+$)/gm, '' )
			.replace( /<!--.+-->/g, '' )
			.replace( /([a-z]+)="([a-z0-9-]+)"/igm, '$1=$2' )
			.replace( /\n+/g, ' ' );
	}

	var sourceDir = '../_source/',
		tempDir = '../_temp/',
		distDir = '../_release/',
		testDir = '../_test/',
		hintOptions = readJSON('.jshintrc');

	grunt.initConfig({
		path: {
			src: sourceDir,
			temp: tempDir,
			dist: distDir,
			test: testDir
		},
		concat: {
			loader: {
				src: [
					'<%= path.src %>js/libs/lab.js',
					'<%= path.temp %>js/loader.js'
				],
				dest: '<%= path.temp %>js/loader.js'
			}
		},
		copy: {
			template: {
				files: [
					{ src: '<%= path.src %>js/templates/jst.js', dest: '<%= path.temp %>js/templates/jst.js' },
				]
			},
			dist: {
				files: [
					{ src: '<%= path.src %>js/libs/toolkit.js', dest: '<%= path.temp %>js/toolkit.js' }
				]
			}
		},
		requirejs: {
			scripts: {
				options: {
					baseUrl: sourceDir + 'js/',
					mainConfigFile: sourceDir + 'js/bundle.js',
					name: 'libs/almond',
					include: [ 'bundle' ],
					wrap: true,
					out: tempDir + 'js/bundle.js',
					optimize: 'uglify2',
					preserveLicenseComments: false
				}
			},
			stylesheets: {
				options: {
					cssIn: sourceDir + 'css/bundle.css',
					out: tempDir + 'css/bundle.css',
					optimizeCss: 'standard'
				}
			}
		},
		jshint: {
			scripts: {
				src: [
					'Gruntfile.js',
					'<%= path.src %>js/**/*.js',
					'!<%= path.src %>js/almond.js',
					'!<%= path.src %>js/libs/**/*.js',
					'!<%= path.src %>js/templates/**/*.js'
				],
				options: hintOptions
			}
		},
		jst: {
			options: {
				separator: '\n',
				namespace: 'joms.jst',
				prettify: true,
				processContent: minifyHTML,
				processName: function( filename ) {
					return filename.replace( sourceDir, '' )
						.replace( /\.html$/, '' );
				},
				templateSettings: {
					variable: 'data'
				}
			},
			compile: {
				src: [ '<%= path.src %>html/**/*.html' ],
				dest: '<%= path.src %>js/templates/jst.js'
			}
		},
		rsync: {
			dist: {
				resources: [{
					from: tempDir,
					to: distDir
				}]
			}
		},
		uglify: {
			loader: {
				files: {
					'<%= path.temp %>js/loader.js': [ '<%= path.src %>js/loader.dist.js' ]
				},
				options: {
					preserveComments: 'some',
					report: 'gzip'
				}
			}
		}
	});

	grunt.loadNpmTasks('grunt-contrib-concat');
	grunt.loadNpmTasks('grunt-contrib-copy');
	grunt.loadNpmTasks('grunt-contrib-jshint');
	grunt.loadNpmTasks('grunt-contrib-jst');
	grunt.loadNpmTasks('grunt-contrib-requirejs');
	grunt.loadNpmTasks('grunt-contrib-uglify');

	grunt.registerTask( 'build', [
		'jshint',
		'jst',
		'requirejs',
		'copy:template',
		'uglify',
		'concat',
		'copy:dist',
		'rsync'
	]);

	// Custom tasks.
	// -------------------------------------------------------------------------

	// Remove unnecessary files.
	grunt.registerMultiTask( 'cleanup', function() {
		var files = this.files[ 0 ].src;
		for ( var i = 0; i < files.length; i++ ) {
			grunt.file.delete( files[ i ] );
		}
	});

	// Copy resources without changing modified time.
	grunt.registerMultiTask( 'rsync', function() {
		var exec = require('child_process').exec,
			done = this.async(),
			res = this.data.resources,
			cmd = '';

		if ( res && res.length ) {
			for ( var i = 0; i < res.length; i++ ) {
				cmd += 'rsync -racvi ' + res[ i ].from + ' ' + res[ i ].to + ';';
			}
		}

		cmd || done();
		cmd && exec( cmd, function( err, stdout, stderr ) {
			err && grunt.fail.fatal( 'Problem with rsync: ' + err + ' ' + stderr );
			grunt.log.writeln( stdout );
			done();
		});
	});

};