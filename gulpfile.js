var elixir = require( 'laravel-elixir' );

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

<!-- Other scripts -->
elixir( function ( mix ) {

    //mix.browserSync();
    /* ---------------------------------------------- styles ----------------------------------------------------*/
    mix.sass( [ 'libraries/bootswatch-spacelab.scss' ], 'public/css/bootstrap-spacelab.css' );

    mix.sass( [
        'help/pictureStyling.scss',
        'help/sideNav.scss',
        'help/bodyText.scss'
    ], 'public/css/help-styles.css' );

    mix.styles( [ 
        'libraries/bootstrap.min.css',
        'libraries/bootstrap-theme.min.css',
        'libraries/bootstrap-slider.css',
        'libraries/jquery-ui-1.11.4.css',
        'pages/homepage.css'
    ], 'public/css/home-styles.css' );

//mix.sass('../../../node_modules/bootstrap/dist/css/bootstrap.css', 'public/css/bootstrap.css');
//
//    mix.sass('../../../node_modules/bootstrap-sass/dist/css/bootstrap.css', 'public/css/bootstrap.css');

    mix.sass( [
        'common/common.sass'
    ], 'public/css/common-package.css' );

    /* ------------ grade pages -------------- */
    mix.sass( [
            'grade/mainGrading.scss'
        ], 'public/css/grade-package.css' );
    mix.sass( [
        'common/common.sass',
        'grade/examSelectTable.scss'
    ], 'public/css/exam-table-package.css' );


    mix.sass( [
        'common/common.sass',
        'grade/examSelectTable.scss'
    ], 'public/css/exam-table-package.css' );

    /* ------------ reports pages -------------- */
    //main index page
    mix.sass( [
        'common/common.sass',
        'reports/examControls.sass'
    ], 'public/css/report-index-package.css');
    
    mix.sass( [
        'reports/examControls.sass'
    ], 'public/css/exam-controls-package.css' );
    
    mix.sass( [
        'reports/examAnalytics.scss'
    ], 'public/css/exam-analytics-package.css' );

    /* ------------ Setup pages -------------- */
    mix.sass( [
        'common/common.sass',
        'setup/editRoster.sass'
    ], 'public/css/edit-roster-package.css' );

    mix.sass( [
        'common/common.sass',
        'setup/selectExam.scss'
    ], 'public/css/select-exam-package.css' );



    /* ---------------------------------------------- scripts ----------------------------------------------------*/

    //Include in development
    mix.browserify( [ 'utilities/vueDebug.js' ], 'public/js/debug.js' );

    mix.browserify( [
            //'https://code.jquery.com/jquery-2.2.0.js',
            //'https://code.jquery.com/ui/1.11.3/jquery-ui.js',
            //'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js',
            'interactiveHome/home.js' ],
        'public/js/home-package.js' );

    //Normally this stuff will be integrated with another package. This is just for pages
    //which have no other js.
    mix.browserify( 'common.js', 'public/js/common-package.js' );

    //AsyncStorage pages
    mix.browserify( 'setupPages/examForm.js', 'public/js/exam-setup-package.js' );
    mix.browserify( 'setupPages/editElement.js', 'public/js/element-edit-package.js' );
    mix.browserify( 'setupPages/editQuestion.js', 'public/js/question-edit-package.js' );
    mix.browserify( 'setupPages/editRoster.js', 'public/js/roster-edit-package.js' );
    mix.browserify( 'setupPages/selectExam.js', 'public/js/exam-select-package.js' );

    //Report pages
    mix.browserify( 'reports/examAnalytics.js', 'public/js/report-exam-analytics-package.js' );
    mix.browserify( 'reports/examControls.js', 'public/js/report-exam-controls-package.js' );
    mix.browserify( 'reports/studentControls.js', 'public/js/report-student-controls-package.js' );
    mix.browserify( 'reports/qualityControl.js', 'public/js/report-quality-control-package.js' );

    //Grading pages
    mix.browserify( 'grade/gradeAssign.js', 'public/js/grade-assign-package.js' );
    mix.browserify( [ 'grade/gradeExam.js' ], 'public/js/grade-exam-package.js' );
    mix.browserify( 'grade/examSelect.js', 'public/js/grade-exam-select-package.js' );

    //Feedback pages
    mix.browserify( 'feedback/feedbackLogin.js', 'public/js/feedback-login-package.js' );
    mix.browserify( 'feedback/feedbackCharts.js', 'public/js/feedback-package.js' );

    //help
    mix.browserify( 'help/help.js', 'public/js/help-package.js' );

    //testing
    mix.browserify('setupPages/DEVeditRoster.js', 'public/js/dev-roster-edit-package.js');

    mix.browserify(['libraries/jquery-1.11.3.min.js'], 'public/js/jquery.js');
//    mix.browserify( 'reports/examControls.js', 'public/js/dev-exam-buttons.js' );
    
    /* --------------------- Admin ---------------------- */
    mix.browserify(['admin/restrictedRegistration.js'], 'public/js/restricted-registration-package.js');

    // mix.browserify([
    //         "libraries/unitTestHelpers/jquery-1.11.1.js",
    //         "libraries/unitTestHelpers/jquery-ui.js",
    //         "libraries/unitTestHelpers/jquery.tmpl.min.js",
    //         "libraries/unitTestHelpers/qunit-1.15.0.js",
    //         "libraries/unitTestHelpers/json2.js",
    //         "libraries/unitTestHelpers/jquery.mockjax.js",
    //         "libraries/unitTestHelpers/jquery.cookie.js"
    // ], 'public/js/testing/js-test-suite.js');

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