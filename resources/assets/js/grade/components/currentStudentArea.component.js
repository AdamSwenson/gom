/**
 * Created by adam on 7/16/16.
 */
//var $ = require('jquery');
//window.$ = $;


// //TODO figure out which typeahead to use
    var Typeahead = require('typeahead');

// var typeahead = require( '../libraries/bootstrap3-typeahead.min.js' );
// var typeahead = require( '../libraries/typeahead.bundle.js' );
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
            studentIdentifier: '',

            /** studentNames supplies name data for the search box (typeahead) */
            studentNames: [],

            /** Student identifier data for the ID search box (typeahead) */
            studentIdents: [],

            /** Total number of students */
            numStudents: null,

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
            this.$dispatch( 'name-visibility-toggled' );
        },


        /**
         * When the pencil icon is selected, toggle visibility of roster names and selected name area
         */
        toggleNameVisibility: function () {
            this.store.isBlind = ! this.store.isBlind;
            this.notifyToggleNameVisibility();
        },

        /**
         * grab the name of the student, and perform a click on the appropriate row in the student roster
         */
        handleStudentNameSearch: function () {
            this.initialize();
            var nameToFind = $( '#activeStudentName' ).val().replace( /\s+/g, ' ' );
            var i = this.studentNames.indexOf( nameToFind );
                window.console.log('handlingNameSearch', nameToFind, i);
            //not sure if this needs to be added
            //$( "#activeStudentName" ).blur();
            if ( i >= 0 ) {
                window.console.log( $( '#studentListItem' + i ));
                $( '#studentListItem' + i ).trigger( 'click' );
            }
        },

        /**
         * do the same with ID search
         */
        handleStudentIdentifierSearch: function () {
            window.console.log( 'handlingIdSearch' );
            this.initialize();
            var idToFind = $( '#activeStudentIdentifier' ).val();
            var i = this.studentIdents.indexOf( idToFind );
            //    window.console.log('handlingIdSearch', i);
            $( "#activeStudentIdentifier" ).blur();
            if ( i >= 0 ) {
                $( '#studentListItem' + i ).trigger( 'click' );
            }
        },

        initialize: function () {
            //only do this once if the list is empty
            // should this also check idents? probably not because those are optional
            if ( this.studentNames.length > 0 ) return;
            var me = this;
            let $studentNames = $( '[id^="studentName"]' );
            $studentNames.each( function () {
                me.studentNames.push( $( this ).text() );
            } );

            //Calculate the number of students and store
            this.numStudents = $studentNames.length;

            //Load the student id numbers
            let $studentIdents = $( '[id^="studentIdentifier"]' );
            $studentIdents.each( function () {
                me.studentIdents.push( $( this ).text() );
            } );

            window.console.log( 'search box data initialized', this );
        }

    },

    events: {
        'student-select-event': function ( obj ) {
            window.console.log( 'currentStudentArea', 'caught student-select-event', obj );
            this.studentName = obj.studentName;
            this.studentIdentifier = obj.studentIdentifier;

            //return true just in case someone else is listening and
            //needs to hear the event
            return true;
        }
    },

    directives: {},
    ready: function(){

        var me = this;
        var nameBox = document.getElementById('activeStudentName');
        var ta1 = Typeahead(nameBox, {
            source: me.studentNames
        });

        var idBox = document.getElementById('activeStudentIdentifier');
        var ta1 = Typeahead(idBox, {
            source: me.studentIdents
        });
        window.console.log('currentStudentArea.component ready');

//         $( '#activeStudentName' ).typeahead( {
//     source: SearchBox.studentNames
// } );

// $( '#activeStudentIdentifier' ).typeahead( {
//     source: SearchBox.studentIdents
// } );
//
// $( "#activeStudentName" ).on( 'change', function () {
//     SearchBox.handleStudentNameSearch();
// } );
//
// $( "#activeStudentIdentifier" ).on( 'change', function () {
//     SearchBox.handleStudentIdentifierSearch();
// } );

    }
};