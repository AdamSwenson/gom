<template>
    <a class="item-remove-button button is-danger is-outlined "
            v-on:click="remove"
            v-bind:id="buttonId"
    >
       <span class="icon is-small">
           <i class="fa fa-times" aria-hidden="true"></i>
       </span>
        <span>{{ label}}</span>
    </a>
</template>

<style>
</style>

<script>
    import * as aTypes from '../../../store/action-types';
    let bootbox = require( 'bootbox' );

    export default {
        props: [ 'index', 'id', 'serialNumber' ],

        computed: {
            buttonId: function () {
                return 'remove-item-button-' + this.serialNumber;
            },
            visible: function () {
            },

            label: function () {
                return "Remove";
            }
        },

        methods: {
            isVisible: function () {
            },

            /**
             * Called when the button is clicked. Handles
             * the request to remove the item from the exam.
             * This does not request that the item be deleted from
             * the database.
             */
            remove: function () {
                console.log( 'remove  pressed' );

            },

            /**
             * This sends the actual request(s) for deletion
             */
            sendRequest: function () {
                this.$store.dispatch( aTypes.removeItem, { index: this.index, id: this.id } );
            },
        },

        mounted: function () {
        },
    };
</script>
