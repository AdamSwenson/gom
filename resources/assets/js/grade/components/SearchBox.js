/**
 * Created by adam on 5/15/16.
 */
var $ = require('jquery');
window.$ = $;
var jQuery = $;
window.jQuery = jQuery;

module.exports = {
        /** studentNames supplies name data for the search box (typeahead) */
        studentNames: [],

        /** Student identifier data for the ID search box (typeahead) */
        studentIdents: [],

        /** Total number of students */
        numStudents: null,

        /**
         * grab the name of the student, and perform a click on the appropriate row in the student roster
         */
        handleStudentNameSearch: function () {
            this.initialize();
            var nameToFind = $( '#activeStudentName' ).val().replace(/\s+/g, ' ');
            var i = this.studentNames.indexOf( nameToFind );
            window.console.log('handlingNameSearch',nameToFind, i);
            //not sure if this needs to be added
            //$( "#activeStudentName" ).blur();
            if ( i >= 0 ) {
                $( '#studentListItem' + i ).triggerHandler( 'click' );
            }
        },

        /**
         * do the same with ID search
         */
        handleStudentIdentifierSearch: function () {
            window.console.log('handlingIdSearch');
            this.initialize();
            var idToFind = $( '#activeStudentIdentifier' ).val();
            var i = this.studentIdents.indexOf( idToFind );
            window.console.log('handlingIdSearch', i);
            $( "#activeStudentIdentifier" ).blur();
            if ( i >= 0 ) {
                $( '#studentListItem' + i ).triggerHandler( 'click' );
            }
        },

        initialize: function () {
            //only do this once if the list is empty
            // should this also check idents? probably not because those are optional
            if ( this.studentNames.length > 0 ) return;
            var me = this;
            var $studentNames = $( '[id^="studentName"]' );
            $studentNames.each( function () {
                me.studentNames.push( $( this ).text() );
            } );

            //Calculate the number of students and store
            this.numStudents = $studentNames.length;

            //Load the student id numbers
            var $studentIdents = $( '[id^="studentIdentifier"]' );
            $studentIdents.each( function () {
                me.studentIdents.push( $( this ).text() );
            } );

            window.console.log( 'search box data initialized', this );
        }
    


}