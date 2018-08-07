// webpack.config.js
const path = require( 'path' )
const glob = require( 'glob' );
const webpack = require( 'webpack' );
const dotenv = require( 'dotenv' );
const nodeExternals = require( 'webpack-node-externals' );
require('babel-polyfill');

//todo dev not needed until upgrade to webpack 4
// const VueLoaderPlugin = require( 'vue-loader/lib/plugin' )

let root = path.resolve( __dirname );
let context = root;

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
    // entry,

    //Important so ide can use sourcemaps for debugging
    devtool: "inline-cheap-module-source-map",

    context,

    externals: [ nodeExternals() ], // in order to ignore all modules in node_modules folder


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
                options: {
                    loaders: {
                        js: 'babel-loader',
                        scss: 'vue-style-loader!css-loader!sass-loader',
                        sass: 'vue-style-loader!css-loader!sass-loader?indentedSyntax',
                    }
                },
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
                options: {
                    // cacheDirectory: true,

                },
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
        // todo dev will need to do this when upgrade to webpack 4
        // make sure to include the plugin for the magic
        // new VueLoaderPlugin()
    ],

    /*
     |--------------------------------------------------------------------------
     | Resolve
     |--------------------------------------------------------------------------
     |
     | Here, we may set any options/aliases that affect Webpack's resolving
     | of modules. To begin, we will provide the necessary Vue alias to
     | load the Vue common library. You may delete this, if needed.
     |
     */
    resolve: {
        /*
        | Automatically resolve certain extensions. This defaults to:
        |      resolve: {
        |        extensions: ['.wasm', '.mjs', '.js', '.json']
        |     }
        | which is what enables users to leave off the extension when importing:
        |       import File from '../path/to/file';
        | Using this will override the default array, meaning that webpack will no longer
        | try to resolve modules using the default extensions. For modules that are imported with their extension,
        | e.g. import SomeFile from "./somefile.ext", to be properly resolved,
        | a string containing "*" must be included in the array.
         */
        extensions : [ '.js', '.vue' ],
        // Including this in extensions caused problems with loading modules
        // '*',


        // See https://webpack.js.org/configuration/resolve/#resolve-alias
        alias: {
            'vue$': 'vue/dist/vue.common.js'
        }
    },

}

