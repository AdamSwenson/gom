<template>

    <button class="button children-display-control is-info is-outlined is-large"
            v-on:click="toggleVisibility"
            v-bind:id="id"
    >
        <span class="icon is-large">
           <i class="fa fa-sitemap" aria-hidden="true"></i>
       </span></button>


</template>
<style>

</style>

<script>

    import Item from '../../../models/Item'
    import Payload from '../../../models/Payload'

    import * as aTypes from '../../../store/action-types'
    import * as mTypes from '../../../store/mutation-types'
    import * as gTypes from '../../../store/getter-types'

    /**
     * Handles showing and hiding the item settings pane
     *
     * Created by adam on 2/18/17.
     */
    export default {

        props: [ 'serialNumber' ],

        data: function () {
            return {
                identifiers: {
                    exam: 'exam-children-display-button',
                    item: 'item-children-display-button'
                }
            };
        },

        computed: {
            item: function () {
                return this.$store.getters.getItemBySerialNumber( this.serialNumber );
            },

            isExam: function () {
                return this.item ? this.item.isExam() : false;
            },

            node: function () {
                return this.$store.getters.getItemNodeFromOrder( this.serialNumber );
            },

            depth: function () {
                return this.$store.getters[ gTypes.getDepthOfNode ]( this.serialNumber );
            },


            height: function () {
                return this.$store.getters[ gTypes.getHeightOfNode ]( this.serialNumber );
            },


            /**
             * Gets the appropriate base string for the input
             * depending on whether it is attached to an exam or
             * regular item
             */
            identifier: function () {
                return this.isExam ? this.identifiers.exam : this.identifiers.item;
            },

            /**
             * The input's css id
             */
            id: function () {
                if ( this.isExam ) return this.identifier;

                return this.identifier + "-" + this.height + '-' + this.depth;
            },

            /**
             * Injected into the classes of the input
             * */
            styling: function () {
                return this.identifier; // + '-' + this.serialNumber;
            },

            //for toggling the display state of the button
            isActive: function () {

            }

        },

        methods: {
            toggleVisibility: function () {
                //change stored state
                window.console.log( 'children-display-control', 'toggleVisibility', 45, this.serialNumber );
//            this.$state.commit();
                if ( this.isExam ) {
                    this.$store.commit( 'toggleExamChildrenVisibility' )
                } else {
                    let payload = Payload.factory( { serialNumber: this.serialNumber } );
                    this.$store.commit( 'toggleChildrenVisibility', payload );

                }
            }
        },

        directives: {},

        events: {},

        mounted: function () {
        }
    }
</script>