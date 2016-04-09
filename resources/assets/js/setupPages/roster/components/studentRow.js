/**
 * Created by adam on 3/23/16.
 */
var $ = require( 'jquery' );
var jQuery = $;
window.$ = $;

var bootbox = require( 'bootbox' );

module.exports = {

    template: require( '../templates/student-row.template.html' ),

    props: [
        'student-record-id', //the database record id; 0 if new
        'row-id',
        'last-name',
        'first-name',
        'student-id',
        'email',
        'failed'
    ],

    data: function () {
        return {
            empty: false,
            storage: {
                failed: ''
            }
        };
    },

    computed: {
        
        isFailed: function () {
            if ( typeof this.failed != 'undefined' ) {
                return this.failed;
            }
            return '';
        },
        /**
         * Builds a jQuery selector for the row
         */
        rowSelector: function(){
            return jQuery("#dataRow" + this.rowId);
        }
    },

    methods: {
        /**
         * Checks whether the row has data 
         * @returns {boolean}
         */
        isRowEmpty: function () {
            if( (typeof this.lastName == 'undefined') && (typeof this.firstName == 'undefined') && (typeof this.studentId == 'undefined') && (typeof this.email == 'undefined' )){
                return true;
            }
            return false;
        },
        
        /**
         * Handles the actual row removal
         */
        removeRow: function(){
            var $studentRow = this.rowSelector;
            $studentRow.remove();
            this.sendUpdateRowValuesRequest()
        },

        /**
         * This calls the dialog and then the actual delete function
         */
        deleteStudent: function () {
            // skip confirmation if row is empty
            if ( this.isRowEmpty() ) {
                this.removeRow();
                return;
            }
            var me = this;
            bootbox.dialog( {
                message: '<span class="glyphicon glyphicon-warning-sign text-danger" aria-hidden="true"></span> ' +
                'Warning: this will delete the student, including their feedback and scores.',
                title: "Delete Student",
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
                            me.removeRow();
                        }
                    }
                }
            } );
        },
        
        sendRemoveRowRequest: function(){
            window.console.log('sending please-remove-row-values request');
            this.$dispatch('please-remove-row', this.rowId);
        },

        sendUpdateRowValuesRequest: function () {
            window.console.log('sending please-update-row-values request');
            this.$dispatch( 'please-update-row-values' );
        }
    },

    directives: {
    },
    ready:function(){

    }
};