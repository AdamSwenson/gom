/**
 * This instantiates the vue instance which runs the breadcrumbs
 * Created by  adam on 1/9/17.
 */

var $ = require('jquery');
window.$ = $;
require('bootstrap');

var Vue = require('vue');

//dev
Vue.config.debug = true;


new Vue({
    el: '#app',

    components: {
        'breadcrumbs': require('./components/breadcrumbs'),
        // 'crumb-link': require('./components/crumbLink')
    },

    data: {},

    computed: {},

    methods: {},

    events: {},


    directives: {},

    ready: function () {
        // $.ajaxSetup({
        //     headers: {
        //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //     }
        // });
        window.console.log('crumbNav.js ready');

    }
});

