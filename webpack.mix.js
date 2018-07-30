/**
 * Created by adam on 3/21/17.
 */
const { mix } = require('laravel-mix');
const VueLoaderPlugin = require('vue-loader/lib/plugin');

// mix.options({
//     extractVueStyles: false,
//     processCssUrls: true,
//     uglify: {},
//     purifyCss: false,
//     //purifyCss: {},
//     postCss: [require('autoprefixer')],
//     clearConsole: false
// });

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for your application, as well as bundling up your JS files.
 |
 */

mix.react(['resources/assets/js/development/bootstrap.js','resources/assets/js/development/newSetup.js'], 'public/js/dev/new-setup-package.js')
    .browserSync('http://localhost:8000/');

mix.react(['resources/assets/js/development/bootstrap.js', 'resources/assets/js/development/newGrading.js'], 'public/js/dev/newest-grading-package.js')
    .browserSync('http://localhost:8000/');

mix.react(['resources/assets/js/development/bootstrap.js', 'resources/assets/js/development/newPublicFeedback.js'], 'public/js/dev/newest-public-feedback-package.js')
    .browserSync('http://localhost:8000/');




// Full API
// mix.js(src, output);
// mix.react(src, output); <-- Identical to mix.js(), but registers React Babel compilation.
// mix.extract(vendorLibs);
// mix.sass(src, output);
// mix.less(src, output);
// mix.stylus(src, output);
// mix.browserSync('my-site.Item');
// mix.combine(files, destination);
// mix.babel(files, destination); <-- Identical to mix.combine(), but also includes Babel compilation.
// mix.copy(from, to);
// mix.minify(file);
// mix.sourceMaps(); // Enable sourcemaps
// mix.version(); // Enable versioning.
// mix.disableNotifications();
// mix.setPublicPath('path/to/public');
// mix.setResourceRoot('prefix/for/resource/locators');
// mix.autoload({}); <-- Will be passed to Webpack's ProvidePlugin.
// mix.webpackConfig({}); <-- Override webpack.config.js, without editing the file directly.
// mix.then(function () {}) <-- Will be triggered each time Webpack finishes building.
// mix.options({
//   extractVueStyles: false, // Extract .vue component styling to file, rather than inline.
//   processCssUrls: true, // Process/optimize relative stylesheet url()'s. Set to false, if you don't want them touched.
//   uglify: {}, // Uglify-specific options. https://webpack.github.io/docs/list-of-plugins.html#uglifyjsplugin
//   postCss: [] // Post-CSS options: https://github.com/postcss/postcss/blob/master/docs/plugins.md
// });
