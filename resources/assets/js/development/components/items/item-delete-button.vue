<!--Removes an item and all associated scores from the database permanently-->
<!--This is not for use in removing items from exams-->
<!--It is only for use in explicit item management contexts-->
<template>
    <button class="item-delete-button button is-danger is-outlined js-remove "
            v-bind:id="id"
            v-bind:class="styling"
            v-on:click="deleteItem"
    >
       <span class="icon is-small">
           <i class="fa fa-times" aria-hidden="true"></i>
       </span>
        <span>Delete</span>
    </button>
</template>

<style>
</style>

<script>
    import * as aTypes from '../../../store/action-types';
    let bootbox = require( 'bootbox' );

    export default {
        props: [ 'serialNumber' ],
        data: function () {
            return {

                //Base for the class and id strings
                identifiers: {
                    item: 'remove-item-button',
                    exam: 'remove-exam-button'
                }
            };
        },

        computed: {
            item: function () {
                return this.$store.getters.getItemBySerialNumber( this.serialNumber );
            },

            isExam: function(){
                return this.item.isExam;
            },

            node: function () {
                return this.$store.getters.getItemNodeFromOrder( this.serialNumber );
            },

            parentSerialNumber: function () {
                return this.node.parent;
            },

            /**
             * Gets the appropriate base string for the input
             * depending on whether it is attached to an exam or
             * regular item
             */
            identifier : function(){
                return this.isExam ? this.identifiers.exam : this.identifiers.item;
            },

            /**
             * The input's css id
             */
            id : function(){
                return this.identifier + '-' + this.serialNumber;
            },

            /**
             * Injected into the classes of the input
             * */
            styling: function(){
                return this.identifier + '-' + this.serialNumber;
            },

            visible: function () {
                return this.$store.getters.isDeleteVisible;
            },
        },


        computed: {
            buttonid: function () {
                return 'remove-item-button-' + this.serialNumber;
            },

            /**
             * Gets the appropriate base string for the input
             * depending on whether it is attached to an exam or
             * regular item
             */
            identifier : function(){
                return this.isExam ? this.identifiers.exam : this.identifiers.item;
            },

            /**
             * The input's css id
             */
            id : function(){
                return this.identifier + '-' + this.serialNumber;
            },

            /**
             * Injected into the classes of the input
             * */
            styling: function(){
                return this.identifier + '-' + this.serialNumber;
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
            deleteItem: function () {
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
                this.$store.dispatch( aTypes.deleteItem, { index: this.index, id: this.id } );
            },
        },

        mounted: function () {
        },
    };
</script>
