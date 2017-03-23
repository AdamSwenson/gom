/**
 * Created by adam on 3/21/17.
 */
const { mix } = require('laravel-mix');
require('laravel-elixir-webpack-official')
require('laravel-elixir-vue-2');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

// mix.js('resources/assets/js/app.js', 'public/js')
//     .sass('resources/assets/sass/app.scss', 'public/css');


mix.js('development/new-setup.vue', 'public/js/dev/new-setup-package.js')
    .sass(['development/newSetup.sass'], 'public/css/new-setup-package.css');
