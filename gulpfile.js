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

/* ---------------------------------------------- styles ----------------------------------------------------*/
    //Styles used on grading page
    mix.sass(
        [
            'grading/mainGrading.scss'
        ], 'public/css/grading-styles.css');

    mix.sass([
        'help/pictureStyling.scss'
    ], 'public/css/help-styles.css');


/* ---------------------------------------------- scripts ----------------------------------------------------*/
    //Compile all the scripts used by the homepage into public/js/home-package.js
    mix.scripts([
        'homepage/jquery-1.8.3.min.js',
        'homepage/museutils.js',
        'homepage/webpro.js',
        'homepage/musewpslideshow.js',
        'homepage/jquery.museoverlay.js',
        'homepage/touchswipe.js',
        'homepage/jquery.watch.js'
    ], 'public/js/home-package.js');

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


    //mix.scripts([
    //    'jquery-1.11.3.js',
    //
    //], 'public/js/libraries.js');

  //mix.browserify('app.js')
  //.browserify('grade.js', 'public/js/grade-package.js');

    //mix.sass('app.scss');

   // mix.sass(['feedback/chartStyling.scss', 'feedback/textStyling.scss'], 'public/css/output.css');
});