var elixir = require('laravel-elixir');

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
elixir(function(mix) {

    //mix.browserSync();
/* ---------------------------------------------- styles ----------------------------------------------------*/
    //Styles used on grading page
    mix.sass(
        [
            'grading/mainGrading.scss'
        ], 'public/css/grading-styles.css');

    mix.sass([
        'help/pictureStyling.scss',
        'help/sideNav.scss',
        'help/bodyText.scss'
    ], 'public/css/help-styles.css');


/* ---------------------------------------------- scripts ----------------------------------------------------*/
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
    mix.scripts(
        [
        'common/flashMessageHandling.js'
        ], 'public/js/commonScripts.js');

    //scripts used on the feedback page
    mix.scripts(
        [
            'feedback/feedbackCharts.js'
        ], 'public/js/feedback-package.js');

    //scripts used on exam grading page
    mix.scripts(
        [
            'grading/letterGradeButton.js'
        ], 'public/js/grading-package.js');

//new homepage
//    mix.sass(
//        [
//
//            'grading/mainGrading.scss',
//        ], 'public/css/home-styles.css');


    mix.styles(['libraries/bootstrap.min.css',
        'libraries/bootstrap-theme.min.css',
        'libraries/bootstrap-slider.css',
        'libraries/jquery-ui-1.11.4.css',
        'pages/homepage.css'
    ],'public/css/home-styles.css')

    mix.browserify([
        //'https://code.jquery.com/jquery-2.2.0.js',
        //'https://code.jquery.com/ui/1.11.3/jquery-ui.js',
        //'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js',
        'interactiveHome/home.js'],
        'public/js/home-package.js');


//        .browsersync('public/js/home-package.js');

    //mix.scripts([
    //    'jquery-1.11.3.js',
    //
    //], 'public/js/libraries.js');

  //mix.browserify('app.js')
  //.browserify('grade.js', 'public/js/grade-package.js');

    //mix.sass('app.scss');

   // mix.sass(['feedback/chartStyling.scss', 'feedback/textStyling.scss'], 'public/css/output.css');
});