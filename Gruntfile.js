module.exports = function (grunt) {
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),

        qunit: {
            options: {
                // 'phantomPath': "/usr/local/lib/node_modules/phantomjs/lib/phantom/bin/phantomjs",
                // timeout: 10000//,
                //coverage: {
                //    src: ['src/www/inc/js/*.js'],
                //    instrumentedFiles: 'build/temp/',
                //    htmlReport: 'build/jsreport/coverage/',
                //    coberturaReport: 'build/jsreport/',
                //    linesThresholdPct: 20,
                //    reportOnFail: true,
                //    cloverReport: 'build/jsreport/'
                //}
            },
            all: ['tests/jsTests/*.html'],
            coverage: {
                src: ['tests/jsTests/*.html'],
                instrumentedFiles: 'build/temp/',
                htmlReport: 'build/jsreport/coverage/',
                coberturaReport: 'build/jsreport/',
                linesThresholdPct: 20,
                reportOnFail: true,
                cloverReport: 'build/jsreport/'
            }
        },
        qunit_junit: {
            options: {
                dest: 'build/js_report/'
            }
        }
        //},
        //coverageInstrument: {
        //    test: {
        //        // NOTE: we instrument only subset of our sources ('lib')
        //        src: 'lib/**/*.js',
        //        expand: true,
        //        cwd: 'src',
        //        dest: '.tmp'
        //    }
        //},
        //coverageReport: {
        //    test: {
        //        options: {
        //            reports: {
        //                html: 'coverageReports/'
        //            }
        //        }
        //    }
        //}

    });

    grunt.loadNpmTasks('grunt-croc-qunit');
    grunt.loadNpmTasks('grunt-qunit-istanbul');
    grunt.loadNpmTasks('grunt-qunit-junit');

    grunt.registerTask('default', ['qunit_junit', 'qunit']);

    //run unit test without coverage
    grunt.registerTask('js_unit_tests', ['qunit']);

    // Create task for minifying (doesn't run by default)
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.registerTask('minify', ['uglify']);

};

//,
//        coverageInstrument: {
//            test: {
//                og: 'og/js/*.js',
//                expand: true,
//                cwd: 'og',
//                dest: 'build/temp/tmp'
//            }
//        },
//        coverageReport: {
//            test: {
//                options: {
//                    reports: {
//                        html: 'build/coverageReports/'
//                    }
//                }
//            }
//        }
//grunt.registerTask('default', ['coverageInstrument',  'coverageReport', 'qunit_junit']);
//  grunt.registerTask('default', ['coverageInstrument', 'qunit:test', 'qunit_junit', 'coverageReport']);
//  grunt.registerTask('default', ['coverageInstrument', 'qunit', 'qunit_junit', 'coverageReport']);


//  grunt.loadNpmTasks('grunt-qunit-junit');
//   gruntConfig.qunit-junit = {
//       options: {
//           dest: 'build/report/'
//       }
//   };