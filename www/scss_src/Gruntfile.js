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
                    '<%= config.jsFolder %>/lib/bootstrap.min.js': ['lib/sass-bootstrap/bootstrap.js'],
                    '<%= config.jsFolder %>/lib/bootstrap-datepicker.min.js': ['bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js'],
                    '<%= config.jsFolder %>/lib/ublaboo-datagrid/datagrid.js': ['bower_components/ublaboo-datagrid/assets/dist/datagrid.min.js'],
                    '<%= config.jsFolder %>/lib/happy/happy.js': ['bower_components/happy/dist/happy.min.js'],
                    '<%= config.jsFolder %>/lib/ublaboo-datagrid/datagrid-instant-url-refresh.js': ['bower_components/ublaboo-datagrid/assets/dist/datagrid-instant-url-refresh.min.js'],
                    '<%= config.jsFolder %>/lib/ublaboo-datagrid/datagrid-spinners.js': ['bower_components/ublaboo-datagrid/assets/dist/datagrid-spinners.min.js'],
                    '<%= config.jsFolder %>/lib/nette/netteForms.min.js': ['bower_components/nette-forms/src/assets/netteForms.js'],
                    '<%= config.jsFolder %>/lib/nette/nette.ajax.min.js': ['bower_components/nette.ajax.js/nette.ajax.js'],
                    '<%= config.jsFolder %>/lib/jquery-ui-sortable.min.js': ['bower_components/jquery-ui-sortable/jquery-ui-sortable.js']


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
                    '<%= config.cssFolder %>/bootstrap.min.css': ['lib/sass-bootstrap/bootstrap.css'],
                    '<%= config.cssFolder %>/happy.min.css': ['lib/happy/dist/happy.css'],
                    '<%= config.cssFolder %>/bootstrap-datepicker3.min.css': ['bootstrap-datepicker/dist/css/bootstrap-datepicker3.css'],
                    '<%= config.cssFolder %>/datagrid.min.css': ['lib/ublaboo-datagrid/assets/dist/datagrid.css'],
                    '<%= config.cssFolder %>/datagrid-spinners.min.css': ['lib/ublaboo-datagrid/assets/dist/datagrid-spinners.css'],
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