var elixir = require( 'laravel-elixir' );
//todo This needs to be enabled!!!!! Turned off because one package it depends on was killing gulp
require('laravel-elixir-images');
require('laravel-elixir-vueify')
require('laravel-elixir-webpack-official')



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

    //Normally this stuff will be integrated with another package. This is just for pages
    //which have no other js.
    mix.browserify( 'common.js', 'public/js/common-package.js' );


    // mix.browserify('development/new-setup.vue', 'public/js/dev/new-setup-package.js');
    mix.browserify(['development/bootstrap.js','development/newSetup.js'], 'public/js/dev/new-setup-package.js');
mix.sass(['development/newSetup.sass', '../../../node_modules/bootstrap-vue/dist/bootstrap-vue.css' ], 'public/css/new-setup-package.css');

    //
    // elixir(function(mix) {
    //     mix.browserSync({
    //         proxy: "localhost:8000"
    //     });
    // });

    // mix.browserSync({
    //     proxy: 'project.dev'
    // });



} );