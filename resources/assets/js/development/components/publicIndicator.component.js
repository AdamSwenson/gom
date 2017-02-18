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

        // /**
        //  * The id of the item (question, element, etc) whose publicity
        //  * this indicator is tracking
        //  */
        // itemId: function(){
        //     if(typeof this.id == 'undefined'){ return this.defaults.itemId; }
        //     return this.id;
        // },

        /**
         * This alters the styling of the indicator
         * to help highlight the possibility that others
         * may see the thing it is attached to
         * @returns {string}
         */
        styling: function () {
            return this.public ? this.styles.public : this.styles.private;
            // if ( this.public ) {
            //     return this.styles.public;
            // }
            // return this.styles.private;
        },


        // indicatorClass: function () {
        //     if ( this.isPublic() ) {
        //         return 'status-warning';
        //     }
        //
        //
        // },

        icon: function () {
            if ( this.public ) {
                return this.icons.eye.open;
            }
            return this.icons.eye.close;
        }
    },

    methods: {
        // /**
        //  * This handles finding out whether the indicator should be
        //  * public or not. No one needs to know how it goes about its
        //  * business. I'm I making myself clear?
        //  */
        // lookupPublicity: function(){
        //     console.log( 'CALLED', 'lookupPublicity' );
        // },
        //


        /**
         * Returns boolean for whether the thing
         * this is attached to is visible to students
         * (or potentially others, if there was a use).
         * @returns {*}
         */
        isPublic: function () {
            this.public;
            // return this.public || false;

            // //in rare cases, this will have been set by prop,
            // // if that happens use the prop
            // //however this will not normally be the case
            // if ( typeof this.public != 'undefined' ) {
            //     return this.public
            // }
            //
            // //usually, we will look up the item from
            // //the store and return the public setting
            // //from the model
            // //If it can't find anything, it will return the
            // //default
            // return this.lookupPublicity() || this.defaults.public;
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