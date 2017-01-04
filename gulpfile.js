var elixir = require( 'laravel-elixir' );

require('laravel-elixir-images');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir( function ( mix ) {

    /* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ styles ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
    mix.sass( [
        'common/common.sass'
    ], 'public/css/common-package.css' );

    /* ------------ Landing and admin pages -------------- */
    mix.sass( [
        'common/common.sass',
        'home/body-styles.sass'
    ], 'public/css/home-package.css' )

    /* ------------ Instruction pages -------------- */
    mix.sass( [
        'common/common.sass',
        'help/pictureStyling.scss',
        'help/sideNav.scss',
        'help/bodyText.scss'
    ], 'public/css/help-styles.css' );

    /* ------------ Setup pages -------------- */
    mix.sass( [
        'common/common.sass',
        'setup/editRoster.sass'
    ], 'public/css/edit-roster-package.css' );

    mix.sass( [
        'common/common.sass',
        'setup/selectExam.scss'
    ], 'public/css/select-exam-package.css' );

    /* ------------ Grade pages -------------- */
    mix.sass( [
        'common/common.sass',
        'grade/mainGrading.scss',
        "../../../node_modules/typeahead/style.css"
    ], 'public/css/grade-package.css' );

    mix.sass( [
        'common/common.sass',
        'grade/examSelectTable.scss'
    ], 'public/css/exam-table-package.css' );

    mix.sass( [
        'common/common.sass',
        'grade/examSelectTable.scss'
    ], 'public/css/exam-table-package.css' );

    /* ------------ Report pages -------------- */
    //main index page
    mix.sass( [
        'common/common.sass',
        'reports/examControls.sass'
    ], 'public/css/report-index-package.css' );

    mix.sass( [
        'common/common.sass',
        'reports/examControls.sass'
    ], 'public/css/exam-controls-package.css' );

    mix.sass( [
        'common/common.sass',
        'reports/examAnalytics.scss'
    ], 'public/css/exam-analytics-package.css' );



    /* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ scripts ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
    //Include in development
    mix.browserify( [ 'utilities/vueDebug.js' ], 'public/js/debug.js' );


    //Normally this stuff will be integrated with another package. This is just for pages
    //which have no other js.
    mix.browserify( 'common.js', 'public/js/common-package.js' );

    /* ------------ Landing and admin pages -------- */
    mix.browserify( [ 'admin/restrictedRegistration.js' ], 'public/js/restricted-registration-package.js' );


    /* ------------ Instruction pages -------------- */
    //help
    mix.browserify( 'help/help.js', 'public/js/help-package.js' );


    /* --------------------- Setup ----------------- */
    mix.browserify( 'setupPages/examForm.js', 'public/js/exam-setup-package.js' );
    mix.browserify( 'setupPages/editElement.js', 'public/js/element-edit-package.js' );
    mix.browserify( 'setupPages/editQuestion.js', 'public/js/question-edit-package.js' );
//this is basically dead. using dev-roster now
    mix.browserify( 'setupPages/editRoster.js', 'public/js/roster-edit-package.js' );
    mix.browserify( 'setupPages/selectExam.js', 'public/js/exam-select-package.js' );
    mix.browserify( 'setupPages/DEVeditRoster.js', 'public/js/dev-roster-edit-package.js' );


    /* --------------------- Reports ---------------------- */
    mix.browserify( 'reports/examAnalytics.js', 'public/js/report-exam-analytics-package.js' );
    mix.browserify( 'reports/examControls.js', 'public/js/report-exam-controls-package.js' );
    mix.browserify( 'reports/studentControls.js', 'public/js/report-student-controls-package.js' );
    mix.browserify( 'reports/qualityControl.js', 'public/js/report-quality-control-package.js' );

    /* --------------------- Grading ---------------------- */
    mix.browserify( 'grade/gradeAssign.js', 'public/js/grade-assign-package.js' );
    mix.browserify( [ 'grade/gradeExam.js' ], 'public/js/grade-exam-package.js' );
    mix.browserify( 'grade/examSelect.js', 'public/js/grade-exam-select-package.js' );
    // mix.scripts('grade/components/Data.js', 'public/js/grade-exam-data.js');

    mix.browserify( 'data/Data.js', 'public/js/grade-exam-data.js' );

    /* --------------------- Feedback ---------------------- */
    mix.browserify( 'feedback/feedbackLogin.js', 'public/js/feedback-login-package.js' );
    mix.browserify( 'feedback/feedbackCharts.js', 'public/js/feedback-package.js' );


    /* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ Images ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
    /*
    The horribly documented package will evaluate the options object as follows:
     responsive: options && options.responsive || config.images.responsive,
     optimizers: options && options.optimizers || config.images.optimizers,
     extensions: options && options.extensions || config.images.extensions,
     sizes: options && options.sizes || config.images.sizes,
     lossy: options && options.lossy || config.images.lossy,
     webp: options && options.webp || config.images.webp
     */
    mix.images(null, 'public/images', {});
        // extensions: {
        //     lossy: {
        //
        //         jpg: {
        //             progressive: true,
        //             max: 50
        //         }
        //     }
        // }
        // }
        // optimizers: {
        //     jpg: require('imagemin-jpegoptim')
        // }
    // });



    /* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ Dev and testing ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
    /* ------ Scripts and styles under development go here ------------------------- */
    //testing
    mix.browserify( [ 'libraries/jquery-1.11.3.min.js' ], 'public/js/jquery.js' );

    mix.scripts( [
        "libraries/unitTestHelpers/jquery-1.11.1.js",
        "libraries/unitTestHelpers/jquery-ui.js",
        "libraries/unitTestHelpers/jquery.tmpl.min.js",
        "libraries/unitTestHelpers/qunit-1.15.0.js",
        "libraries/unitTestHelpers/json2.js",
        "libraries/unitTestHelpers/jquery.mockjax.js",
        "libraries/unitTestHelpers/jquery.cookie.js"
    ], 'public/js/testing/js-test-suite.js' );

    mix.browserify( 'data/Store.js', 'public/js/dev/new-data-package.js' );
    mix.browserify( 'grade/gradeVue.js', 'public/js/dev/grade-vue.js' );

    mix.browserify('data/vuex.Data.js', 'public/js/dev/test-package.js')



    //
    // elixir(function(mix) {
    //     mix.browserSync({
    //         proxy: "localhost:8000"
    //     });
    // });

    // mix.browserSync({
    //     proxy: 'project.dev'
    // });

//
//     var gulpNSP = require('gulp-nsp');
//
// //To check your package.json
//     gulp.task('nsp', function (cb) {
//         gulpNSP({package: __dirname + '/package.json'}, cb);
//     });
//
// //To check your shrinkwrap.json
//     gulp.task('nsp', function (cb) {
//         gulpNSP({shrinkwrap: __dirname + '/npm-shrinkwrap.json'}, cb);
//     });
//
// //If you don't want to stop your gulp flow if some vulnerabilities have been found use the stopOnError option:
//     gulp.task('nsp', function (cb) {
//         gulpNSP({
//             package: __dirname + '/package.json',
//             stopOnError: false
//         }, cb);
//     });
//
// //For enterprises building behind a proxy (HTTP_PROXY or HTTPS_PROXY), use the proxy option:
//     gulp.task('nsp', function (cb) {
//         gulpNSP({
//             shrinkwrap: __dirname + '/npm-shrinkwrap.json',
//             proxy: process.env.HTTPS_PROXY
//         }, cb);
//     });


} );