/**
 * Created by adam on 2/17/17.
 */
//var $ = require('jquery');
//window.$ = $;

module.exports = {

    template: require( '../templates/item-card.template.html' ),

    props: [],

    data: function () {
        return {
            isCommented: false,
            /**
             * Whether students can see the name of the item
             */
            isNamePublic: false,
        };
    },

    computed: {
        /**
         * The name of the item
         */
        itemName: {},

    },

    methods: {
        /**
         * Toggles whether comments are shown for this item.
         * Turning comments off does not delete any existing
         * comments.
         */
        toggleCommentsOn: function(){
            console.log( 'CALLED', 'toggleCommentsOn' );
            this.isCommented = ! this.isCommented;
        },

        /**
         * Toggles whether comments are shown for this item.
         * Turning comments off does not delete any existing
         * comments.
         */
        toggleNameVisibility: function(){
            console.log( 'CALLED', 'toggleNameVisibility' );
            this.isNamePublic = ! this.isNamePublic;
        },


    },

    directives: {},

    events: {},

    ready: function () {
    },
};