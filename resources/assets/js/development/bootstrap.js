/**
 * This file bootstraps the application
 */
window.console.log( 'bootstrap', 'bootstrapping', 4, );
window._ = require( 'lodash' );

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */
window.$ = window.jQuery = require( 'jquery' );

//set csrf token
window.Laravel = { csrfToken: $( 'meta[name=csrf-token]' ).attr( "content" ) };


/**
 * Styling and templating libraries
 */
//Pull in bootstrap libraries
require( 'bootstrap' );
require( 'bootstrap-sass' );
// require('bootstrap-vue')
// require('bootstrap-vue/dist/bootstrap-vue.css')


/**
 * Vue is a modern JavaScript library for building interactive web interfaces
 * using reactive data binding and reusable components. Vue's API is clean
 * and simple, leaving you to focus on building your next great project.
 */

// window.Vue = require('vue');

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require( 'axios' );

window.axios.defaults.headers.common = {
    'X-CSRF-TOKEN': window.Laravel.csrfToken,
    'X-Requested-With': 'XMLHttpRequest'
};

window.axios.defaults.baseURL = routeRoot;

// `transformRequest` allows changes to the request data before it is sent to the server
// This is only applicable for request methods 'PUT', 'POST', and 'PATCH'
// The last function in the array must return a string, an ArrayBuffer, FormData, or a Stream
// window.axios.defaults.transformRequest = function ( data ) {
//     // Do whatever you want to transform the data
//     window.console.log( 'axiosConfig', 'transformRequest', 56 );
//     return data;
// };
//
// // `transformResponse` allows changes to the response data to be made before
// // it is passed to then/catch
// window.axios.defaults.transformResponse = function ( data ) {
//     // Do whatever you want to transform the data
//     window.console.log( 'axiosConfig', 'transformResponse', 26 );
//     return data;
// };

// window.axios.defaults.onUploadProgress = function ( progressEvent ) {
//     // Do whatever you want with the native progress event
//     window.console.log( 'axiosConfig', 'onUploadProgress', 90, );
// };
//
// // `onDownloadProgress` allows handling of progress events for downloads
// window.axios.defaults.onDownloadProgress = function ( progressEvent ) {
//     // Do whatever you want with the native progress event
//     window.console.log( 'axiosConfig', 'onDownloadProgress', 95, );
// };
//

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from "laravel-echo"

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: 'your-pusher-key'
// });

import 'babel-polyfill'
