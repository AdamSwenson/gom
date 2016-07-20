/**
 * Created by adam on 7/16/16.
 */
//var $ = require('jquery');
//window.$ = $;
//TODO needs typeahead stuff
module.exports = {

    template: require( '../templates/current-student-area.template.html' ),

    props: [],

    data: function () {
        return {
            /**
             * The data repository store shared by everyone
             */
            store: store,

            /**
             * The name of the student currently being graded
             */
            studentName: '',

            /**
             * The identifier of the student currently being graded
             */
            studentIdentifier: ''
        };
    },

    computed: {
        studentNamesVisible: function () {
            return this.store.isBlind
        }
    },

    methods: {
        /**
         * Dispatches a notification that the visibility of names
         * has changed
         */
        notifyToggleNameVisibility: function () {
            this.$dispatch('name-visibility-toggled');
        },


        /**
         * When the pencil icon is selected, toggle visibility of roster names and selected name area
         */
        toggleNameVisibility: function () {
            this.store.isBlind = ! this.store.isBlind;
            this.notifyToggleNameVisibility();
        },


    },

    events: {
        'student-select-event': function ( obj ) {
            window.console.log('currentStudentArea', 'caught student-select-event', obj);
            this.studentName = obj.studentName;
            this.studentIdentifier = obj.studentIdentifier;

            //return true just in case someone else is listening and
            //needs to hear the event
            return true;
        }
    },

    directives: {}
};