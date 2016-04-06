/**
 * This is the main javascript for edit_roster.blade
 * 
 * Created by  adam on 3/23/16.
 */

var $ = require( 'jquery' );
var jQuery = $;
window.$ = $;
window.jQuery = $;

require( 'bootstrap' );

var DataTable = require( 'datatables.net-bs' )( window, $ );
// var sorting = require('datatables.net.dataSourcePlugins')( window, $ );
var buttons = require( 'datatables.net-buttons-bs' )( window, $ );
var colReorder = require( 'datatables.net-colreorder' )( window, $ );

var bootbox = require('bootbox');
var Vue = require( 'vue' );

//dev
Vue.config.debug = true;
Vue.config.devtools = true;

var Row = Vue.extend( require( './roster/components/studentRow.js' ) );

new Vue( {
    el: '#app',

    components: {
        'add-empty-row-button': require('./roster/components/addStudentButton.js'),
        'delete-roster-button': require('./roster/components/rosterDeleteButton.js'),
        'import-roster-button': require( './roster/components/rosterImportButton.js' ),
        'import-roster-help-button': require('./roster/components/rosterImportHelpButton.js'),
        'setup-navs': require('./shared/components/setupNavButtons.js'),
        'student-row': require( './roster/components/studentRow.js' )
    },


    data: {

        storage: {
            maxRow: 0,
        },
        table: false
    },

    computed: {
        maxRow: {
            get: function () {
                if ( this.storage.maxRow === 0 ) {
                    if ( typeof maxRow != 'undefined' ) {
                        this.storage.maxRow = Number( maxRow );
                    }
                }
                return this.storage.maxRow;
            },

            set: function ( v ) {
                this.storage.maxRow = v;
            }
        }
    },

    methods: {
        updateRowValues: function () {

//                this.table.draw();

         },

        notifyRowValuesUpdated: function () {
            this.$broadcast( 'row-values-updated' );
        },

        addRow: function ( rowId, lastName, firstName, studentId, email ) {
            //add a placeholder to the table
            var s = "dataRow" + rowId;
            var h = "<tr id='" + s + "'></tr>";
            $( '#studentRosterBody' ).append( h );
            var el = function () {
                return "#" + s;
            };
            //initialize the component on the placeholder
            var row = new Row( {
                el: el,
                replace: true,
                data: {
                    studentRecordId: 0, //server expects new students to have an id of 0
                    rowId: rowId,
                    lastName: lastName,
                    firstName: firstName,
                    studentId: studentId,
                    email: email
                }
            } );
            //replace the placeholder
            row.$mount( "#" + s );
        },

        /**
         * This will be called by the nav buttons via throwing
         * the 'please-validate-and-submit' event.
         * It performs the appropriate validation and submits
         * the form if everything is okay
         * @param target String expected by the server (not the route!)
         */
        validateAndSubmit: function ( target ) {
            var $table = $( '#studentRosterBody' );
            var valid = true;

            // check that first and last names have values
            $table.find( '[id$="Name"]' ).each( function () {
                if ( $( this ).val() == '' ) {
                    valid = false;
                }
            } );

            if ( valid ) {
                $( '[name="navigateTo"]' ).val( target );
                $( '#rosterData' ).submit();
            } else {
                bootbox.alert( "Name missing! Make sure all students have a first and last name before proceeding.",
                    function () {
                    } );
            }
        }
    },

    events: {
        'please-add-row': function ( rowObj ) {
            window.console.log( 'editRoster.js', 'caught please-add-row', rowObj );
            this.maxRow += 1;
            this.addRow( this.maxRow, rowObj.lastName, rowObj.firstName, rowObj.studentId, rowObj.email );
        },

        'please-add-empty-row': function(){
            window.console.log( 'editRoster.js', 'caught please-add-empty-row' );
            this.maxRow += 1;
            this.addRow( this.maxRow, '', '', '', '');
        },

        'please-remove-row': function ( rowId ) {
            window.console.log( 'editRoster.js', 'caught please-remove-row', rowId );
        },

        'please-update-row-values': function () {
            window.console.log( 'editRoster.js', 'caught please-update-row-values' );
            this.updateRowValues();
        },
        'please-validate-and-submit': function(target){
            window.console.log( 'editRoster.js', 'caught please-validate-and-submit', target );
            this.validateAndSubmit(target);
        }
    },


    directives: {
        datatable: {

            bind: function () {
                window.console.log( 'bind called' );
                /**
                 * Read information from a column of input (type text) elements and return an
                 * array to use as a basis for sorting.
                 *
                 *  @summary Sorting based on the values of `dt-tag input` elements in a column.
                 *  @name Input element data source
                 *  @requires DataTables 1.10+
                 *  @author [Allan Jardine](http://sprymedia.co.uk)
                 */

                $.fn.dataTable.ext.order['dom-text'] = function  ( settings, col )
                {
                    return this.api().column( col, {order:'index'} ).nodes().map( function ( td, i ) {
                        return $('input', td).val();
                    } );
                };

                //$(this.el).DataTable();
                this.table = $( "#rosterTable" ).DataTable(
                    {
                        columnDefs: [
                            //no idea why column didn't work. No idea why only works if type is numeric, even though
                            //the relevant columns are strings. Whatevs. It works.
                            { "orderDataType": "dom-text", "type": "numeric", targets:[0, 1, 2, 3] },
                        ],
                         paging: false,
                        // scrollY: 100,
                    }
                );
            }
        }
    },

    ready: function () {
        $.ajaxSetup( {
            headers: {
                'X-CSRF-TOKEN': $( 'meta[name="csrf-token"]' ).attr( 'content' )
            }
        } );
        window.console.log( 'editRoster.js ready' );
    }
} );

