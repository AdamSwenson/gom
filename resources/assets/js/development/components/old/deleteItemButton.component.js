/**
 * Created by adam on 3/10/17.
 */
import * as aTypes from '../../../store/action-types';
let bootbox = require( 'bootbox' )

module.exports = {

    template: require( '../../templates/delete-item-button.template.html' ),

    props: [ 'index', 'id' ],

    computed: {
        visible: function () {
            return this.$store.getters.isDeleteVisible;
        }
    },

    methods: {
        isVisible: function () {
            return this.$store.getters.isDeleteVisible;
        },

        /**
         * Called when the button is clicked. Handles
         * the request for deletion.
         */
        remove: function () {
            console.log( 'deleteItem pressed' );
            let me = this;
            bootbox.dialog( {
                className: 'confirmationModal',
                message: "<p class='questionDeleteWarning' id='questionDeleteWarning'> <span class='glyphicon glyphicon-warning-sign'></span>" +
                " Warning: This will permanently delete all scores associated with the item </p>",
                title: "Delete",
                buttons: {
                    success: {
                        label: 'Cancel',
                        className: "btn-sm bnt-primary cancelQuestionDelete",
                        callback: function () {
                        }
                    },
                    danger: {
                        label: '<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> Delete',
                        className: "btn-danger btn-sm confirmQuestionDelete",
                        callback: function () {
                            me.sendRequest();
                        }
                    }
                }
            } );

        },

        /**
         * This sends the actual request(s) for deletion
         */
        sendRequest: function () {
            this.$store.dispatch( aTypes.deleteItem, {index: this.index, id: this.id} );
        },
    },

    mounted: function () {
    },
};