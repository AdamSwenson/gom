/**
 * Created by adam on 2/15/17.
 */
//var $ = require('jquery');
//window.$ = $;

module.exports = {

    template: require( '../templates/tools-dashboard.template.html' ),

    props: [],

    data: function () {
        return {
            /**
             * Whether to highlight missing or badly ordered items
             */
            isHolesShown: false
        }
    },

    computed: {

    },

    methods: {
        /**
         * Displays the buttons for removing items
         */
        activateDeleteMode: function () {

        },

        /**
         * Hides the delete item buttons
         */
        cancelDeleteMode: function () {

        },

        /**
         * Opens a pop up window for viewing what a student
         * would see, given current settings
         */
        showSampleFeedback: function(){
         //dispatch request
        },

        /**
         * Toggle value of isHolesShown
         */
        toggleHolesShown: function ()
        {
            this.isHolesShown = !this.isHolesShown;
        }

    },

    directives: {},

    events: {},

    ready: function () {
        console.log( 'tools-dashboard ready' );
    },
};