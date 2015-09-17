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
    mix.scripts([
        'jquery-1.8.3.min.js',
        'museutils.js',
        'webpro.js',
        'musewpslideshow.js',
        'jquery.museoverlay.js',
        'touchswipe.js',
        'jquery.watch.js'
    ], 'public/js/home-package.js');

    //mix.scripts([
    //    'jquery-1.11.3.js',
    //
    //], 'public/js/libraries.js');

  mix.browserify('app.js')
  .browserify('grade.js', 'public/js/grade-package.js');

    mix.sass('app.scss');

    mix.sass(['feedback/chartStyling.scss', 'feedback/textStyling.scss'], 'public/css/output.css');
});