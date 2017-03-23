/**
 * Created by adam on 2/15/17.
 */

import * as mTypes from '../../../store/mutation-types';

module.exports = {

    template: require( '../../templates/tools-dashboard.template.html' ),

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
         * Displays or hides the buttons for removing items
         */
        toggleDeleteMode: function () {
            console.log( 'toggleDeleteMode', 'pressed' );
            this.$store.commit(mTypes.toggleDeleteButtonVisibility)
        },

        toggleReorderMode: function(){
            console.log( 'toggleReorderMode', 'pressed' );
            this.$store.commit(mTypes.toggleReorderMode);
        },

        /**
         * Opens a pop up window for viewing what a student
         * would see, given current settings
         */
        showSampleFeedback: function(){
            console.log( 'showSampleFeedback', 'pressed' );
            this.$store.commit(mTypes.toggleSampleFeedback);
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

    mounted: function () {
        console.log( 'tools-dashboard ready' );
    },
};