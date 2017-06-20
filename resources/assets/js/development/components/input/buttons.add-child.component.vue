<template>

    <button class="button add-child-button is-primary is-outlined"
            v-on:click="add"
    >
       <span class="icon is-small">
           <i class="fa fa-list-alt" aria-hidden="true"></i>
       </span>
        <span>Add Child</span>
    </button>

</template>
<style>

</style>
<script>
    import * as aTypes from '../../../store/action-types';
    import * as mTypes from '../../../store/mutation-types';

    export default {
        props: [ 'item', 'index', 'serialNumber' ],

        data: function () {
            return {};
        },

        computed: {
            parentSerialNumber: function () {
                let node = this.$store.getters.getItemNodeFromOrder( this.serialNumber );
                return node.parent;
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
                this.$store.dispatch( aTypes.createItem, this.serialNumber );
            }
        },

        directives: {},

        events: {},

        mounted: function () {
//            console.log( 'itemAddButton', 'ready', this.$store );
        }
    }
</script>
