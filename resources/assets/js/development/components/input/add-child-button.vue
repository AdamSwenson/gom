<template>

    <button v-bind:id="id"
            class="button is-primary is-outlined"
            v-bind:class="stylz"
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
        props: [ 'serialNumber' ],

        data: function () {
            return {

                //Base for the class and id strings
                identifiers: {
                    item: 'add-child-button',
                    exam: 'add-child-to-exam-button'
                }
            };
        },

        computed: {
            item: function () {
                return this.$store.getters.getItemBySerialNumber( this.serialNumber );
            },

            isExam: function(){
              return this.item ? this.item.isExam() : false;
            },

//            node: function () {
//                return this.$store.getters.getItemNodeFromOrder( this.serialNumber );
//            },

//            parentSerialNumber: function () {
//                return this.node.parent;
//            },

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
            stylz: function(){
                return this.identifier; // + '-' + this.serialNumber;
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
