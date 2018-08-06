// webpack.config.js
const path = require( 'path' )
let glob = require( 'glob' );
let webpack = require( 'webpack' );
let dotenv = require( 'dotenv' )

// const VueLoaderPlugin = require( 'vue-loader/lib/plugin' )

const nodeExternals = require( 'webpack-node-externals' );


let root = path.resolve( __dirname );
/*
 |--------------------------------------------------------------------------
 | Load Environment Variables
 |--------------------------------------------------------------------------
 |
 | Load environment variables from .env file. dotenv will never modify
 | any environment variables that have already been set.
 |
 */
dotenv.config( {
    path: root + "/.env"  // string
} );

module.exports = {

    /*
    Entry
    An entry point indicates which module webpack should use to begin building out its internal dependency graph,
     webpack will figure out which other modules and libraries that entry point depends on (directly and indirectly).
    By default its value is ./src/index.js, but you can specify a different (or multiple entry points)
    by configuring the entry property in the webpack configuration. For example:
    https://webpack.js.org/concepts/
    */
    // entry: root, // + '/resources/js',
    output: root + '/public/js',

    // externals: [ nodeExternals() ], // in order to ignore all modules in node_modules folder

    output: {
        // use absolute paths in sourcemaps (important for debugging via IDE)
        devtoolModuleFilenameTemplate: '[absolute-resource-path]',
        devtoolFallbackModuleFilenameTemplate: '[absolute-resource-path]?[hash]'
    },

    target: 'node',  // webpack should compile node compatible code

    module: {
        rules: [
            {
                test: /\.vue$/,
                loader: 'vue-loader',
                // options: {
                //     loaders: {
                //         js: 'babel-loader',
                //         scss: 'vue-style-loader!css-loader!sass-loader',
                //         sass: 'vue-style-loader!css-loader!sass-loader?indentedSyntax',
                //     }
                // },
            },

            // this will apply to both plain `.scss` files
            // AND `<style lang="scss">` blocks in `.vue` files
            {
                test: /\.scss$/,
                use: [
                    'vue-style-loader',
                    'css-loader',
                    'sass-loader'
                ]
            },

// this will apply to both plain `.js` files
// AND `<script>` blocks in `.vue` files
            {
                test: /\.js$/,
                loader: 'babel-loader',
                // options: {
                //     cacheDirectory: true,
                //     presets: [
                //         [
                //             'env',
                //             {
                //                 modules: false,
                //                 targets: {
                //                     browsers: [ '> 2%' ],
                //                     uglify: true
                //                 }
                //             }
                //         ]
                //     ],
                //     plugins: [
                //         'transform-object-rest-spread',
                //         [
                //             'transform-runtime',
                //             {
                //                 polyfill: false,
                //                 helpers: false
                //             }
                //         ]
                //     ]
                // },
            },
// this will apply to both plain `.css` files
// AND `<style>` blocks in `.vue` files
            {
                test: /\.css$/,
                use:
                    [
                        'vue-style-loader',
                        'css-loader'
                    ]
            }
        ]
    },
    plugins: [
        // make sure to include the plugin for the magic
        new VueLoaderPlugin()
    ]
}


// console.log( 'webpack.mocha.config', 'root', 11, root);


//
//
// // module.exports.mode = 'development';
//
//
//
// //Setting this causes this error --- TypeError: _vm._ssrClass is not a function
// // module.exports.target = 'node';
//
// module.exports.externals = [ nodeExternals() ]; // in order to ignore all modules in node_modules folder
//
// // module.exports.mode = 'development';
//
//
// // module.exports.context = root + '/node_modules';
//
//
//
// // module.exports.output = root + '/public/js';
// //
// module.exports.output = {
//     // use absolute paths in sourcemaps (important for debugging via IDE)
//     devtoolModuleFilenameTemplate: '[absolute-resource-path]',
//     devtoolFallbackModuleFilenameTemplate: '[absolute-resource-path]?[hash]'
// };
//
//
// /*
//  |--------------------------------------------------------------------------
//  | Rules
//  |--------------------------------------------------------------------------
//  |
//  | Webpack rules allow us to register any number of loaders and options.
//  | Out of the box, we'll provide a handful to get you up and running
//  | as quickly as possible, though feel free to add to this list.
//  |
//  */
//
// let plugins = [];
//
//
// let rules = [
//     {
//         test: /\.vue$/,
//         loader: 'vue-loader',
//         options: {
//             // loaders: Mix.options.extractVueStyles ? {
//             //     js: 'babel-loader' + Mix.babelConfig(),
//             //     scss: vueExtractTextPlugin.extract( {
//             //         use: 'css-loader!sass-loader',
//             //         fallback: 'vue-style-loader'
//             //     } ),
//             //     sass: vueExtractTextPlugin.extract( {
//             //         use: 'css-loader!sass-loader?indentedSyntax',
//             //         fallback: 'vue-style-loader'
//             //     } ),
//             //     less: vueExtractTextPlugin.extract( {
//             //         use: 'css-loader!less-loader',
//             //         fallback: 'vue-style-loader'
//             //     } ),
//             //     stylus: vueExtractTextPlugin.extract( {
//             //         use: 'css-loader!stylus-loader?paths[]=node_modules',
//             //         fallback: 'vue-style-loader'
//             //     } ),
//             //     css: vueExtractTextPlugin.extract( {
//             //         use: 'css-loader',
//             //         fallback: 'vue-style-loader'
//             //     } )
//             // } : {
//                 js: 'babel-loader' +
//                     {
//                         cacheDirectory: true,
//                         presets: [
//                             [
//                                 'env',
//                                 {
//                                     modules: false,
//                                     targets: {
//                                         browsers: ['> 2%'],
//                                         uglify: true
//                                     }
//                                 }
//                             ]
//                         ],
//                         plugins: [
//                             'transform-object-rest-spread',
//                             [
//                                 'transform-runtime',
//                                 {
//                                     polyfill: false,
//                                     helpers: false
//                                 }
//                             ]
//                         ]
//                     },
//                     // { "presets": ["env", "latest"],
//                     // "plugins": ["transform-object-rest-spread", "syntax-async-functions","transform-regenerator"]
//                 // },// + Mix.babelConfig(),
//             // scss: vueExtractTextPlugin.extract( {
//                 //         use: 'css-loader!sass-loader',
//                 //         fallback: 'vue-style-loader'
//                 //     } ),
//                 //
//                 scss: 'vue-style-loader!css-loader!sass-loader',
//                 sass: 'vue-style-loader!css-loader!sass-loader?indentedSyntax',
//                 less: 'vue-style-loader!css-loader!less-loader',
//                 stylus: 'vue-style-loader!css-loader!stylus-loader?paths[]=node_modules'
//             // },
//
//         }
//     },
//
//     {
//         test: /\.css$/,
//         loaders: [ 'style-loader', 'css-loader' ]
//     },
//
//
//
// ];
//
// let extensions = [ '*', '.js', '.jsx', '.vue' ];
//
// module.exports.module = { rules };
//
//
// /*
//  |--------------------------------------------------------------------------
//  | Resolve
//  |--------------------------------------------------------------------------
//  |
//  | Here, we may set any options/aliases that affect Webpack's resolving
//  | of modules. To begin, we will provide the necessary Vue alias to
//  | load the Vue common library. You may delete this, if needed.
//  |
//  */
//
// module.exports.resolve = {
//     extensions,
//
//     alias: {
//         'vue$': 'vue/dist/vue.common.js'
//     }
// };
//
//
// module.exports.devtool = 'cheap-source-map'; //Mix.options.sourcemaps;
//
//
// module.exports.plugins = plugins;
//
//
// //
// //
// // module.exports = {
// //   module: {
// //       rules: rules,
// //           // [
// //           // {
// //           //     test: /\.vue$/,
// //           //     use: 'vue-loader',
// //           //     options: {
// //           //         loaders: Mix.options.extractVueStyles ? {
// //           //             js: 'babel-loader' + Mix.babelConfig(),
// //           //             scss: vueExtractTextPlugin.extract({
// //           //                 use: 'css-loader!sass-loader',
// //           //                 fallback: 'vue-style-loader'
// //           //             }),
// //           //             sass: vueExtractTextPlugin.extract({
// //           //                 use: 'css-loader!sass-loader?indentedSyntax',
// //           //                 fallback: 'vue-style-loader'
// //           //             }),
// //           //             less: vueExtractTextPlugin.extract({
// //           //                 use: 'css-loader!less-loader',
// //           //                 fallback: 'vue-style-loader'
// //           //             }),
// //           //             stylus: vueExtractTextPlugin.extract({
// //           //                 use: 'css-loader!stylus-loader?paths[]=node_modules',
// //           //                 fallback: 'vue-style-loader'
// //           //             }),
// //           //             css: vueExtractTextPlugin.extract({
// //           //                 use: 'css-loader',
// //           //                 fallback: 'vue-style-loader'
// //           //             })
// //           //         }: {
// //           //             js: 'babel-loader' + Mix.babelConfig(),
// //           //             scss: 'vue-style-loader!css-loader!sass-loader',
// //           //             sass: 'vue-style-loader!css-loader!sass-loader?indentedSyntax',
// //           //             less: 'vue-style-loader!css-loader!less-loader',
// //           //             stylus: 'vue-style-loader!css-loader!stylus-loader?paths[]=node_modules'
// //           //         },
// //           //
// //           //         postcss: Mix.options.postCss,
// //           //
// //           //         preLoaders: Mix.options.vue.preLoaders,
// //           //
// //           //         postLoaders: Mix.options.vue.postLoaders
// //           //     }
// //           // },
// //
// //       // ],
// //
// //       output: {
// //           // use absolute paths in sourcemaps (important for debugging via IDE)
// //           devtoolModuleFilenameTemplate: '[absolute-resource-path]',
// //           devtoolFallbackModuleFilenameTemplate: '[absolute-resource-path]?[hash]'
// //       },
// //
// //       target: 'node',  // webpack should compile node compatible code
// //
// //       externals: [nodeExternals()], // in order to ignore all modules in node_modules folder
// //
// //       devtool: "inline-cheap-module-source-map"
// //   }
// //
//
//
//
