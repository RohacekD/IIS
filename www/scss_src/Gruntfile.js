module.exports = function(grunt) {

    // Project configuration.
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        config: grunt.file.readJSON('config.json'),
        uglify: {
            options: {
                banner: '/*! <%= pkg.name %> <%= grunt.template.today("yyyy-mm-dd") %> */\n'
            },
            build: {
                src: 'src/js/script.js',
                dest: '<%= config.jsFolder %>/script.min.js'
            },
            libUglify: {
                files: {
                    '<%= config.jsFolder %>/lib/jquery.min.js': ['lib/jquery/jquery.js'],
                    '<%= config.jsFolder %>/lib/bootstrap.min.js': ['lib/sass-bootstrap/bootstrap.js']

                }
            }
        },
        cssmin: {
            options: {
                shorthandCompacting: false,
                roundingPrecision: -1
            },
            libUglify: {
                files: {
                    '<%= config.cssFolder %>/bootstrap.min.css': ['lib/sass-bootstrap/bootstrap.css']
                }
            },
            build: {
				files: [{
					expand: true,
					cwd: '<%= config.cssFolder %>/',
					src: ['*.css', '!*.min.css'],
					dest: '<%= config.cssFolder %>/',
					ext: '.min.css'
				}]
            }
        },
        bower: {
            install: {
                options: {
                    layout: "byType"
                }
            }
        },
        clean: {
            setUp: ["bower_components", "lib"]
        },
        copy: {
            setUp: {
                files: [
                    {expand: true, cwd: 'lib/sass-bootstrap/' ,src: ['**/glyphicons*.*'], dest: '<%= config.fontsFolder %>/', filter: 'isFile'},
                    {expand: true, cwd: 'lib/matchHeight/' ,src: ['**/jquery.matchHeight-min.js'], dest: '<%= config.jsFolder %>/lib/', filter: 'isFile'},
                ]
            },
            fontAwesome: {
                files: [
                    {expand: true, cwd: 'bower_components/fonts' ,src: ['**/*.*'], dest: '<%= config.fontsFolder %>/', filter: 'isFile'},
                    {expand: true, cwd: 'bower_components/scss' ,src: ['**/*.*'], dest: 'src/style/lib/font-awesome', filter: 'isFile'}
                ]
            },
            build:{
                files: [
                    //{expand: true, cwd: 'src/style/' ,src: ['**/*.css'], dest: '<%= config.cssFolder %>/', filter: 'isFile'},
                    {expand: true, cwd: 'src/js/' ,src: ['**/*.js'], dest: '<%= config.jsFolder %>/', filter: 'isFile'}
                ]
            }
        },
        sprite:{
            all: {
                src: 'src/sprites/*.png',
                dest: 'sprites/spritesheet.png',
                destCss: 'src/style/core/_sprites.scss'
            }
        },
		sass: {
			dist: {
				files: [{
					expand: true,
					cwd: 'src/style/',
					src: ['*.scss'],
					dest: '<%= config.cssFolder %>/',
					ext: '.css'
				}]
			}
		}

    });

    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-bower-task');
    grunt.loadNpmTasks('grunt-contrib-copy');
    grunt.loadNpmTasks('grunt-contrib-cssmin');
    grunt.loadNpmTasks('grunt-spritesmith');
    grunt.loadNpmTasks('grunt-contrib-clean');
	grunt.loadNpmTasks('grunt-contrib-sass');

    // Default task(s).
    grunt.registerTask('default', ['sass','copy:build']);
    //produce
    grunt.registerTask('produce', ['uglify:build', 'sass','cssmin:build']);
    // Set Up task
    grunt.registerTask('setUp', ['bower:install', 'uglify:libUglify', 'cssmin:libUglify', 'copy:setUp', 'copy:fontAwesome', 'clean:setUp']);
};