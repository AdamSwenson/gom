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

            studentName: '',

            studentIdentifier: ''
        };
    },

    computed: {
        studentNamesVisible : function(){
                return this.store.isBlind
        }
    },

    methods: {
        /**
         * Dispatches a notification that the visibility of names
         * has changed
         */
        notifyToggleNameVisibility: function(){},



        /**
         * When the pencil icon is selected, toggle visibility of roster names and selected name area
         */
        toggleNameVisibility: function () {
            this.store.isBlind = ! this.store.isBlind;
            this.notifyToggleNameVisibility();

        },


    },

    events: {
        'student-select-event': function(obj){
            window.console.log("~~~~~~~~~~~~~~~~~~~~~~~~%%%%%%%%%%%%%%%%%%%%%%%%%%%% wooo hooooo");
            this.studentName = obj.studentName;
            this.studentIdentifier = obj.studentIdentifier;

        }
    },

    directives: {}
};