<template>
    <a v-bind:id="id"
            class="button is-primary is-outlined"
            v-bind:class="styling"
            v-on:click="add"
    >
       <span class="icon is-small">
           <i class="fa fa-plus" aria-hidden="true"></i>
       </span>
        <span>Add Sibling</span>
    </a>
</template>
<style>

</style>
<script>
    import * as aTypes from '../../../store/action-types';
    import * as mTypes from '../../../store/mutation-types';

    import mixin from './item-buttons.mixin';
    export default {
        mixins: [mixin],

        props: ['item', 'type' ],

        data: function () {
            return {
                identifier: 'add-sibling-button'
            };
        },

        computed: {

            styling: function(){
                return this.identifier + '-' + this.serialNumber;
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

    }
</script>
