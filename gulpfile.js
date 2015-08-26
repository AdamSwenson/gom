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

elixir(function(mix) {
  mix.browserify('app.js')
  .browserify('grade.js', 'public/js/grade-package.js');

    mix.sass('app.scss');

    mix.sass(['feedback/chartStyling.scss', 'feedback/textStyling.scss'], 'public/css/output.css');
});