<template>
    <button
            class="add-sibling-button is-primary is-outlined"
            v-on:click="add"
    >
       <span class="icon is-small">
           <i class="fa fa-plus" aria-hidden="true"></i>
       </span>
        <span>Add Sibling</span>
    </button>
</template>
<style>

</style>
<script>
    import * as aTypes from '../../../store/action-types';
    import * as mTypes from '../../../store/mutation-types';

    export default {
        props: [ 'item', 'index', 'serialNumber', 'type' ],

        data: function () {
            return {};
        },

        computed: {
            node: function () {
                return this.$store.getters.getItemNodeFromOrder( this.serialNumber );
            },
            parentSerialNumber: function () {
                return this.node.parent;
            },
            icon: function () {
                let icons = {
                    sibling: '<span class="glyphicon glyphicon-list"></span>',
                    child: '<span class="glyphicon glyphicon-add"></span>'
                };

            }
        },

        methods: {
            /**
             * Called on click.
             * It in turn calls a handler
             */
            add: function () {
                console.log( 'CALLED', 'add', this.serialNumber );
                this.sendRequest();
            },

            /**
             * This sends the actual request(s)
             */
            sendRequest: function () {
                this.$store.dispatch( aTypes.createItem, this.parentSerialNumber );
            }
        },

        directives: {},

        events: {},

        mounted: function () {
//            console.log( 'itemAddButton', 'ready', this.$store );
        }
    }
</script>
