// Karma configuration
// Generated on Mon Jul 11 2016 14:59:04 GMT-0700 (PDT)

module.exports = function ( config ) {
    config.set( {

        // base path that will be used to resolve all patterns (eg. files, exclude)
        basePath: '',

        // frameworks to use
        // available frameworks: https://npmjs.org/browse/keyword/karma-adapter
        frameworks: [ 'browserify', 'jasmine', 'sinon', 'vue-component' ],


        // list of files / patterns to load in the browser
        files: [
            // 'resources/assets/js/data/Store.js',
            'data/Data.js',
            'tests/spec/tests/**/*.spec.js',
            { pattern: 'tests/spec/helpers/*.helper.js', included: false },
            { pattern: 'tests/spec/fixtures/*.fixture.html', included: false },
            { pattern: 'node_modules/karma-jasmine-html-reporter/src/css/jasmine.css' },
            { pattern: 'node_modules/karma-jasmine-html-reporter/src/lib/html.jasmine.reporter.js' },
            { pattern: 'node_modules/karma-jasmine-html-reporter/src/lib/adapter.js' },
        ],

        // list of files to exclude
        exclude: [],

        // preprocess matching files before serving them to the browser
        // available preprocessors: https://npmjs.org/browse/keyword/karma-preprocessor
        preprocessors: {
            // 'resources/assets/js/data/*.js': ['rollup', 'browserify'],
            'node_modules/jasmine-core': [ 'browserify' ],
            'tests/spec/**/*.js': [  'browserify' ],
            'resources/assets/js/**/*.js': [ 'browserify' ],
        },


        browserify: {
            debug: true,
            transform: [
                [ 'babelify', { "presets": [ "es2015" ] } ],
                'stringify',
                'vueify'
            ],
        },


        // test results reporter to use
        // possible values: 'dots', 'progress'
        // available reporters: https://npmjs.org/browse/keyword/karma-reporter
        //reporters: ['progress'],
    reporters : ['dots', 'junit'],
    junitReporter : {
        outputFile: 'build/testsjs/karma-test-results.xml'
    },
        // // the default configuration
        // junitReporter: {
        //     outputDir: '', // results will be saved as $outputDir/$browserName.xml
        //     outputFile: undefined, // if included, results will be saved as $outputDir/$browserName/$outputFile
        //     suite: '', // suite will become the package name attribute in xml testsuite element
        //     useBrowserName: true, // add browser name to report and classes names
        //     nameFormatter: undefined, // function (browser, result) to customize the name attribute in xml testcase element
        //     classNameFormatter: undefined, // function (browser, result) to customize the classname attribute in xml testcase element
        //     properties: {} // key value pair of properties to add to the <properties> section of the report
        // }
        // web server port
        port: 9876,


        // enable / disable colors in the output (reporters and logs)
        colors: true,


        // level of logging
        // possible values: config.LOG_DISABLE || config.LOG_ERROR || config.LOG_WARN || config.LOG_INFO || config.LOG_DEBUG
        logLevel: config.LOG_DEBUG,


        // enable / disable watching file and executing tests whenever any file changes
        autoWatch: false,


        // start these browsers
        // available browser launchers: https://npmjs.org/browse/keyword/karma-launcher
        browsers: [ 'Chrome' ],
        // browsers: ['Chrome', 'Firefox', 'PhantomJS', 'IE'],

        // Continuous Integration mode
        // if true, Karma captures browsers, runs the tests and exits
        singleRun: true,

        // Concurrency level
        // how many browser should be started simultaneous
        concurrency: Infinity,

    } )
}
