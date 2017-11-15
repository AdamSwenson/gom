var nodeExternals = require('webpack-node-externals');

let path = require('path');
let glob = require('glob');
let webpack = require('webpack');
let Mix = require('laravel-mix').config;
let webpackPlugins = require('laravel-mix').plugins;
let dotenv = require('dotenv')


/*
 |--------------------------------------------------------------------------
 | Mix Initialization
 |--------------------------------------------------------------------------
 |
 | As our first step, we'll require the project's Laravel Mix file
 | and record the user's requested compilation and build steps.
 | Once those steps have been recorded, we may get to work.
 |
 */

Mix.initialize();

//Setting this causes this error --- TypeError: _vm._ssrClass is not a function
// module.exports.target = 'node';

module.exports.externals =  [ nodeExternals() ]; // in order to ignore all modules in node_modules folder


/*
 |--------------------------------------------------------------------------
 | Webpack Output
 |--------------------------------------------------------------------------
 |
 | Webpack naturally requires us to specify our desired output path and
 | file name. We'll simply echo what you passed to with Mix.js().
 | Note that, for Mix.version(), we'll properly hash the file.
 |
 */

module.exports.output =  {
    // use absolute paths in sourcemaps (important for debugging via IDE)
    devtoolModuleFilenameTemplate: '[absolute-resource-path]',
    devtoolFallbackModuleFilenameTemplate: '[absolute-resource-path]?[hash]'
};


module.exports.devtool = "inline-cheap-module-source-map";


let rules = [
    {
        test: /\.vue$/,
        loader: 'vue-loader',
        options: {
            loaders: Mix.options.extractVueStyles ? {
                js: 'babel-loader' + Mix.babelConfig(),
                scss: vueExtractTextPlugin.extract({
                    use: 'css-loader!sass-loader',
                    fallback: 'vue-style-loader'
                }),
                sass: vueExtractTextPlugin.extract({
                    use: 'css-loader!sass-loader?indentedSyntax',
                    fallback: 'vue-style-loader'
                }),
                less: vueExtractTextPlugin.extract({
                    use: 'css-loader!less-loader',
                    fallback: 'vue-style-loader'
                }),
                stylus: vueExtractTextPlugin.extract({
                    use: 'css-loader!stylus-loader?paths[]=node_modules',
                    fallback: 'vue-style-loader'
                }),
                css: vueExtractTextPlugin.extract({
                    use: 'css-loader',
                    fallback: 'vue-style-loader'
                })
            }: {
                js: 'babel-loader' + Mix.babelConfig(),
                scss: 'vue-style-loader!css-loader!sass-loader',
                sass: 'vue-style-loader!css-loader!sass-loader?indentedSyntax',
                less: 'vue-style-loader!css-loader!less-loader',
                stylus: 'vue-style-loader!css-loader!stylus-loader?paths[]=node_modules'
            },

            postcss: Mix.options.postCss,

            preLoaders: Mix.options.vue.preLoaders,

            postLoaders: Mix.options.vue.postLoaders
        }
    },

    {
        test: /\.jsx?$/,
        exclude: /(node_modules|bower_components)/,
        loader: 'babel-loader' + Mix.babelConfig()
    },

    {
        test: /\.css$/,
        loaders: ['style-loader', 'css-loader']
    },

    {
        test: /\.html$/,
        loaders: ['html-loader']
    },

    {
        test: /\.(png|jpe?g|gif)$/,
        loaders: [
            {
                loader: 'file-loader',
                options: {
                    name: path => {
                        if (! /node_modules|bower_components/.test(path)) {
                            return 'images/[name].[ext]?[hash]';
                        }

                        return 'images/vendor/' + path
                            .replace(/\\/g, '/')
                            .replace(
                                /((.*(node_modules|bower_components))|images|image|img|assets)\//g, ''
                            ) + '?[hash]';
                    },
                    publicPath: Mix.options.resourceRoot
                }
            },
            {
                loader: 'img-loader',
                options: Mix.options.imgLoaderOptions
            }
        ]
    },

    {
        test: /\.(woff2?|ttf|eot|svg|otf)$/,
        loader: 'file-loader',
        options: {
            name: path => {
                if (! /node_modules|bower_components/.test(path)) {
                    return 'fonts/[name].[ext]?[hash]';
                }

                return 'fonts/vendor/' + path
                    .replace(/\\/g, '/')
                    .replace(
                        /((.*(node_modules|bower_components))|fonts|font|assets)\//g, ''
                    ) + '?[hash]';
            },
            publicPath: Mix.options.resourceRoot
        }
    },

    {
        test: /\.(cur|ani)$/,
        loader: 'file-loader',
        options: {
            name: '[name].[ext]?[hash]',
            publicPath: Mix.options.resourceRoot
        }
    }
];

let extensions = ['*', '.js', '.jsx', '.vue'];
module.exports.module = { rules };

//
//
// module.exports = {
//   module: {
//       rules: rules,
//           // [
//           // {
//           //     test: /\.vue$/,
//           //     use: 'vue-loader',
//           //     options: {
//           //         loaders: Mix.options.extractVueStyles ? {
//           //             js: 'babel-loader' + Mix.babelConfig(),
//           //             scss: vueExtractTextPlugin.extract({
//           //                 use: 'css-loader!sass-loader',
//           //                 fallback: 'vue-style-loader'
//           //             }),
//           //             sass: vueExtractTextPlugin.extract({
//           //                 use: 'css-loader!sass-loader?indentedSyntax',
//           //                 fallback: 'vue-style-loader'
//           //             }),
//           //             less: vueExtractTextPlugin.extract({
//           //                 use: 'css-loader!less-loader',
//           //                 fallback: 'vue-style-loader'
//           //             }),
//           //             stylus: vueExtractTextPlugin.extract({
//           //                 use: 'css-loader!stylus-loader?paths[]=node_modules',
//           //                 fallback: 'vue-style-loader'
//           //             }),
//           //             css: vueExtractTextPlugin.extract({
//           //                 use: 'css-loader',
//           //                 fallback: 'vue-style-loader'
//           //             })
//           //         }: {
//           //             js: 'babel-loader' + Mix.babelConfig(),
//           //             scss: 'vue-style-loader!css-loader!sass-loader',
//           //             sass: 'vue-style-loader!css-loader!sass-loader?indentedSyntax',
//           //             less: 'vue-style-loader!css-loader!less-loader',
//           //             stylus: 'vue-style-loader!css-loader!stylus-loader?paths[]=node_modules'
//           //         },
//           //
//           //         postcss: Mix.options.postCss,
//           //
//           //         preLoaders: Mix.options.vue.preLoaders,
//           //
//           //         postLoaders: Mix.options.vue.postLoaders
//           //     }
//           // },
//
//       // ],
//
//       output: {
//           // use absolute paths in sourcemaps (important for debugging via IDE)
//           devtoolModuleFilenameTemplate: '[absolute-resource-path]',
//           devtoolFallbackModuleFilenameTemplate: '[absolute-resource-path]?[hash]'
//       },
//
//       target: 'node',  // webpack should compile node compatible code
//
//       externals: [nodeExternals()], // in order to ignore all modules in node_modules folder
//
//       devtool: "inline-cheap-module-source-map"
//   }
//



