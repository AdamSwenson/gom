/**
 * Created by  adam on 3/3/16.
 */

var $ = require( 'jquery' );
var jQuery = $;
window.$ = $;
window.jQuery = $;
require( 'bootstrap' );

var Vue = require( 'vue' );

//dev
Vue.config.debug = true;


new Vue( {
    el: '#app',

    components: {
        'exam-buttons': require('./components/reportExamButtons.js')
    },


    data: {},

    computed: {},

    methods: {},

    events: {},


    directives: {},

    ready: function () {

    }
} );

