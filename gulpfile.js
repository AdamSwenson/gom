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

    mix.sass( [
        'help/pictureStyling.scss',
        'help/sideNav.scss',
        'help/bodyText.scss'
    ], 'public/css/help-styles.css' );

    mix.styles( [ 'libraries/bootstrap.min.css',
        'libraries/bootstrap-theme.min.css',
        'libraries/bootstrap-slider.css',
        'libraries/jquery-ui-1.11.4.css',
        'pages/homepage.css'
    ], 'public/css/home-styles.css' );




    mix.sass([
        'common/common.sass'
    ], 'public/css/common-package.css');


    //Styles used on grade page
    mix.sass(
        [
            'grade/mainGrading.scss'
        ], 'public/css/grade-package.css' );


    //reports pages
    mix.sass([
        'reports/examControls.scss'
    ], 'public/css/exam-controls-package.css');
    mix.sass([
        'reports/examAnalytics.scss'
    ], 'public/css/exam-analytics-package.css');


    //setup pages
    mix.sass([
        'common/common.sass',
        'setup/editRoster.scss'
    ], 'public/css/edit-roster-package.css');

    mix.sass([
        'common/common.sass',
        'setup/selectExam.scss'
    ], 'public/css/select-exam-package.css');

    /* ---------------------------------------------- scripts ----------------------------------------------------*/

    //Include in development
    mix.browserify(['utilities/vueDebug.js'], 'public/js/debug.js');

    mix.browserify( [
            //'https://code.jquery.com/jquery-2.2.0.js',
            //'https://code.jquery.com/ui/1.11.3/jquery-ui.js',
            //'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js',
            'interactiveHome/home.js' ],
        'public/js/home-package.js' );

    //Normally this stuff will be integrated with another package. This is just for pages
    //which have no other js.
    mix.browserify( 'common.js', 'public/js/common-package.js' );

    //Setup pages
    mix.browserify( 'setupPages/examForm.js', 'public/js/exam-setup-package.js' );
    mix.browserify( 'setupPages/editElement.js', 'public/js/element-edit-package.js' );
    mix.browserify( 'setupPages/editQuestion.js', 'public/js/question-edit-package.js' );
    mix.browserify( 'setupPages/editRoster.js', 'public/js/roster-edit-package.js' );
    mix.browserify( 'setupPages/selectExam.js', 'public/js/exam-select-package.js' );

    //Report pages
    mix.browserify( 'reports/examAnalytics.js', 'public/js/exam-analytics-package.js' );
    mix.browserify( 'reports/examControls.js', 'public/js/exam-controls-package.js' );
    mix.browserify( 'reports/studentControls.js', 'public/js/student-controls-package.js' );
    mix.browserify( 'reports/examSelect.js', 'public/js/exam-select-package.js' );
    mix.browserify('reports/qualityControl.js', 'public/js/quality-control-package.js');

    //Grading pages
    mix.browserify( 'grade/gradeAssign.js', 'public/js/grade-assign-package.js' );
    mix.browserify( 'grade/gradeExam.js', 'public/js/grade-exam-package.js' );
    mix.browserify( 'grade/examSelect.js', 'public/js/grade-exam-select-package.js' );

    //Feedback pages
    mix.browserify( 'feedback/feedbackLogin.js', 'public/js/feedback-login-package.js' );
    mix.browserify( 'feedback/feedbackCharts.js', 'public/js/feedback-package.js' );

    ////Compile all the scripts used by the homepage into public/js/home-package.js
    //mix.scripts([
    //    'homepage/jquery-1.8.3.min.js',
    //    'homepage/museutils.js',
    //    'homepage/webpro.js',
    //    'homepage/musewpslideshow.js',
    //    'homepage/jquery.museoverlay.js',
    //    'homepage/touchswipe.js',
    //    'homepage/jquery.watch.js'
    //], 'public/js/home-package.js');

    //Helper scripts which should be included on every page into public/js/commonScripts.js
    //mix.scripts(
    //    [
    //        'common/flashMessageHandling.js'
    //    ], 'public/js/commonScripts.js' );

    //scripts used on the feedback page
    //mix.scripts(
    //    [
    //        'feedback/feedbackCharts.js'
    //    ], 'public/js/feedback-package.js' );

    //scripts used on exam grade page
    //mix.scripts(
    //    [
    //        'grade/letterGradeButton.js'
    //    ], 'public/js/grade-package.js' );

//new homepage
//    mix.sass(
//        [
//
//            'grade/mainGrading.scss',
//        ], 'public/css/home-styles.css');


//        .browsersync('public/js/home-package.js');

    //mix.scripts([
    //    'jquery-1.11.3.js',
    //
    //], 'public/js/libraries.js');

    //mix.browserify('app.js')
    //.browserify('grade.js', 'public/js/grade-package.js');

    //mix.sass('app.scss');

    // mix.sass(['feedback/chartStyling.scss', 'feedback/textStyling.scss'], 'public/css/output.css');
} );