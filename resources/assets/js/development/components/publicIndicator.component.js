/**
 * This is the indicator which tells the user whether the thing it
 * is attached to is visible to the public.
 * On being clicked it emits an event and listens for a request
 * to change from public to hidden or vice versa.
 *
 * This can be used for anything potentially public.
 * That is, it can be used by:
 *      Exam
 *      ExamName
 *      Question
 *      QuestionName
 *      Element
 *      ElementName
 *      Comment
 *
 * Created by adam on 2/17/17.
 */
//var $ = require('jquery');
//window.$ = $;

module.exports = {

    template: require( '../templates/public-indicator.template.html' ),

    props: [],

    data: function () {
        return {
            //
            // defaults: {
            // /**
            //  * If this indicator is associated with a particular
            //  * item, that item's id will be stored here.
            //  * It will use this value in listening for events
            //  * and in sending requests
            //  */
            // itemId: null,
            //
            //     /**
            //      * Things are private by default
            //      */
            //     public: false,
            // },

            styles: {
                public: 'bg-warning',
                private: ''
            },

            icons: {
                eye: {
                    open: 'glyphicon glyphicon-eye-open',
                    close: 'glyphicon glyphicon-eye-close'
                }
            }
        };
    },

    computed: {
        public: function () {
            return this.$parent.public;
        },

        /**
         * This alters the styling of the indicator
         * to help highlight the possibility that others
         * may see the thing it is attached to
         * @returns {string}
         */
        styling: function () {
            return this.public ? this.styles.public : this.styles.private;
        },


        icon: function () {
            if ( this.public ) {
                return this.icons.eye.open;
            }
            return this.icons.eye.close;
        }
    },

    methods: {
        /**
         * Returns boolean for whether the thing
         * this is attached to is visible to students
         * (or potentially others, if there was a use).
         * @returns {*}
         */
        isPublic: function () {
            return this.public;
        },

        isPrivate: function () {
            return !this.public;
        },

        /**
         * Called when the indicator is clicked.
         * It subsequently calls other functions to
         * do the work.
         */
        togglePublic: function () {
            console.log( 'CALLED', 'togglePublic' );
            this.$dispatch( 'toggle-public' );
        },


    },

    directives: {},

    events: {},

    ready: function () {
    },
};