<template>

    <a v-bind:id="id"
            class="button is-primary is-outlined"
            v-bind:class="stylz"
            v-on:click="add"
    >
       <span class="icon is-small">
           <i class="fa fa-list-alt" aria-hidden="true"></i>
       </span>
        <span>Add Child</span>
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

        props: ['item' ],

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

            /**
             * Gets the appropriate base string for the input
             * depending on whether it is attached to an exam or
             * regular item
             */
            identifier : function(){
              return this.isExam ? this.identifiers.exam : this.identifiers.item;
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

    }
</script>
