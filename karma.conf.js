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
            // 'data/Data.js',
            { pattern: 'store/index.js', watched: false },
            { pattern: 'tests/spec/tests/**/*.spec.js', watched: false },
            { pattern: 'tests/spec/helpers/*.helper.js', included: false },
            { pattern: 'tests/spec/fixtures/*.fixture.html', included: false },
            { pattern: 'node_modules/karma-jasmine-html-reporter/src/css/jasmine.css' },
            { pattern: 'node_modules/karma-jasmine-html-reporter/src/lib/html.jasmine.reporter.js' },
            { pattern: 'node_modules/karma-jasmine-html-reporter/src/lib/adapter.js' },
        ],

        // list of files to exclude
        exclude: [],

        // preprocess matching files before serving them to the browser
        //  available preprocessors: https://npmjs.org/browse/keyword/karma-preprocessor
        //  preprocessors: {
        //      // 'resources/assets/js/data/*.js': ['rollup', 'browserify'],
        //      'node_modules/jasmine-core': [ 'browserify' ],
        //      'tests/spec/**/*.js': [  'browserify' ],
        //      'resources/assets/js/**/*.js': [ 'browserify' ],
        //  },


        // browserify: {
        //     debug: true,
        //     transform: [
        //         [ 'babelify', { "presets": [ "env","latest" ] } ],
        //         'stringify',
        //         'vueify'
        //     ],
        // },
        //
        //  files: [
        //      // all files ending in "_test"
        //      {pattern: 'test/*_test.js', watched: false},
        //      {pattern: 'test/**/*_test.js', watched: false}
        //      // each file acts as entry point for the webpack configuration
        //  ],
        //
        preprocessors: {
            // add webpack as preprocessor
            'tests/spec/tests/**/*.spec.js': [ 'webpack' ]
        },
        webpack: {
            // karma watches the test entry points
            // (you don't need to specify the entry option)
            module: {
                loaders: [
                    {
                        test: /\.js$/,
                        loader: 'babel-loader',
                        exclude: /node_modules/
                    },
                    {
                        test: /\.vue$/,
                        loader: 'vue-loader'
                    },

                    {
                        test: /\.html$/,
                        loader: 'html-loader'
                    }
                ]
            }
        },

        webpackMiddleware: {
            noInfo: true,
            // webpack-dev-middleware configuration
            // i. e.
            stats: 'errors-only'
        },

        module: {
            noParse: [ /sinon\.js/ ]
        },
        //

        // preprocessors: {
        //     // add webpack as preprocessor
        //     'node_modules/jasmine-core': [ 'webpack' ],
        //     'tests/spec/**/*.js': [  'webpack' , 'sourcemap'],
        //     // 'resources/assets/js/**/*.js': [ 'webpack' , 'sourcemap'],
        //     // 'tests/spec/test_index.js': ['webpack', 'sourcemap']
        //     // 'tests/spec/*_test.js': ['webpack'],
        //     // 'test/**/*_test.js': ['webpack']
        // },
        //
        // webpack: {
        //     // karma watches the test entry points
        //     // (you don't need to specify the entry option)
        //     // webpack watches dependencies
        //
        //     // webpack configuration
        //     devtool: 'inline-source-map'
        // },
        //
        // webpackMiddleware: {
        //     // webpack-dev-middleware configuration
        //     // i. e.
        //     stats: 'errors-only'
        // },
        //

        // test results reporter to use
        // possible values: 'dots', 'progress'
        // available reporters: https://npmjs.org/browse/keyword/karma-reporter
        //reporters: ['progress'],

        // web server port
        port: 9876,


        // enable / disable colors in the output (reporters and logs)
        colors: true,


        // level of logging
        // possible values: config.LOG_DISABLE || config.LOG_ERROR || config.LOG_WARN || config.LOG_INFO || config.LOG_DEBUG
        // logLevel: config.LOG_DEBUG,
        logLevel: config.LOG_ERROR,


        // enable / disable watching file and executing tests whenever any file changes
        autoWatch: true,


        // start these browsers
        // available browser launchers: https://npmjs.org/browse/keyword/karma-launcher
        browsers: [ 'Chrome' ],
        // browsers: ['Chrome', 'Firefox', 'PhantomJS', 'IE'],

        // Continuous Integration mode
        // if true, Karma captures browsers, runs the tests and exits
        singleRun: false,

        // Concurrency level
        // how many browser should be started simultaneous
        concurrency: Infinity,

    } )
}
