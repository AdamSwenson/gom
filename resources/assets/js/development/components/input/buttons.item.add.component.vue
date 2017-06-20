<template>
    <button id="add-item-button"
            class="btn btn-info"
            v-on:click="addItem"
    >
        <span class="glyphicon glyphicon-plus"></span>
        <span class="hidden-md"> Add item</span>
    </button>
</template>
<style>

</style>
<script>
    import * as aTypes from '../../../store/action-types';
    import * as mTypes from '../../../store/mutation-types';

    export default {
        props: ['item', 'index'],

        data: function () {
            return {};
        },

        computed: {},

        methods: {
            /**
             * Called on click.
             * It in turn calls a handler
             */
            addItem: function () {
                console.log( 'CALLED', 'addItem' );
                this.sendRequest();
            },

            /**
             * This sends the actual request(s)
             */
            sendRequest: function () {
                this.$store.dispatch( aTypes.createItem, this.item );
            }
        },

        directives: {},

        events: {},

        mounted: function () {
            console.log( 'itemAddButton', 'ready', this.$store );
        }
    }
</script>
