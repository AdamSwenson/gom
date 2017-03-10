/**
 * This is the representation of a question
 * or element.
 * It can be moved around to reorder the exam.
 * It can be deleted (without worrying the user about other exams being affected)
 * It has several hidden elements which allow settings or customizations
 * Created by adam on 2/17/17.
 */
//var $ = require('jquery');
//window.$ = $;

module.exports = {

    template: require( '../templates/item-card.template.html' ),

    props: [ 'index' ],

    data: function () {
        return {

            defaults: {
                depth: null,
                index: null,
                type: null
            },
            isCommented: false,
            /**
             * Whether students can see the name of the item
             */
            isNamePublic: false,
        };
    },

    computed: {

        depth: {
            get: function () {
                return this.defaults.depth;
            },
            set: function () {

            }
        },
        // index: {
        //     get: function () {
        //
        //         if ( typeof this.item == 'undefined' ) {
        //             return this.item.index;
        //         }
        //         if ( typeof this.itemIndex == 'undefined' ) {
        //             return this.defaults.index;
        //         }
        //         return this.itemIndex;
        //     },
        //
        //     //todo this is a kludge until get store and item worked in
        //     set: function ( v ) {
        //         if ( typeof this.item == 'undefined' ) {
        //             this.item.index = v;
        //         }
        //         if ( typeof this.itemIndex == 'undefined' ) {
        //             this.defaults.index = v;
        //         }
        //         this.itemIndex = v;
        //     }
        // },

        type: {
            get: function () {
                return this.defaults.index;
            },
            set: function () {

            }
        }
    },

    methods: {
        /**
         * Toggles whether comments are shown for this item.
         * Turning comments off does not delete any existing
         * comments.
         */
        toggleCommentsOn: function () {
            console.log( 'CALLED', 'toggleCommentsOn' );
            this.isCommented = !this.isCommented;
        },

        /**
         * Toggles whether comments are shown for this item.
         * Turning comments off does not delete any existing
         * comments.
         */
        toggleNameVisibility: function () {
            console.log( 'CALLED', 'toggleNameVisibility' );
            this.isNamePublic = !this.isNamePublic;
        },


    },

    directives: {},

    events: {
        'display-settings': function () {
            console.log( 'itemName', 'CAUGHT', 'display-settings', this.index);
            this.$broadcast( 'display-settings' );
        },
    },

    ready: function () {
    },
};