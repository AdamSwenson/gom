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