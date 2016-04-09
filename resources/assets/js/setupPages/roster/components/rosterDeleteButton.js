/**
 * Created by adam on 3/25/16.
 */
var $ = require('jquery');
window.$ = $;

var bootbox = require('bootbox');

module.exports = {

    template: require( '../templates/roster-delete-button.template.html' ),

    props: [],

    data: function () {
        return {
            me: this
        };
    },

    computed: {},

    methods: {
        /**
         * confirm, then delete all students.
         */
        deleteRoster: function() {
            var $roster = $( '#studentRosterBody' ).find( 'tr' );
            if ( $roster.length == 0 ) return;

            bootbox.dialog( {
                message: "Warning: This will remove all students from the current roster, including their grades and feedback.",
                title: "Delete Roster",
                buttons: {
                    success: {
                        label: 'Cancel',
                        className: "btn-sm",
                        callback: function () {
                        }
                    },
                    danger: {
                        label: '<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> Delete',
                        className: "btn-danger btn-sm",
                        callback: function () {
                            $roster.each( function () {
                                $( this ).remove();
                            } );
                            bootbox.alert( {
                                message: "Removal of students will not be complete until you click 'Save and Finish'. "
                            } );
                        }
                    }
                }
            } );
        },
    },

    directives: {}
};