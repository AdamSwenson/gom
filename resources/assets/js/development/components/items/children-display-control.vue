<template>

    <button
            class="children-display-control button is-large"
            v-bind:class="styling"
            v-on:click="toggleVisibility"
    >
        <span class="icon is-large">
           <i class="fa fa-sitemap" aria-hidden="true"></i>
       </span>
    </button>


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
                },
                styles: {
                    unselected: "is-info is-outlined",
                    selected: "is-info"
                },

            };
        },

        computed: {
            item: function () {
                return this.$store.getters.getItemBySerialNumber( this.serialNumber );
            },

            isExam: function () {
                return this.item ? this.item.isExam() : false;
            },

            numberChildren: function(){
                let c = this.$store.getters.getItemChildren( this.item );
                return (!_.isUndefined( c ) && ! _.isNull(c) ) ? c.length : 0;
            },

            styling: function () {
                let isVisible = this.$store.getters.isItemChildrenVisible( this.serialNumber );

                if ( isVisible ) {
                    return this.styles.unselected;
                }
                return this.styles.selected;

            }
        },

        methods: {
            toggleVisibility: function () {
                //change stored state
                // window.console.log( 'children-display-control', 'toggleVisibility', 45, this.serialNumber );

                if ( this.isExam ) {
                    this.$store.commit( 'toggleExamChildrenVisibility' )
                } else {
                    //only add the item to the list if it actually has children
                    if ( this.numberChildren > 0 ) {
                        let payload = Payload.factory( { serialNumber: this.serialNumber, mutateSilently: true } );
                        this.$store.commit( 'toggleChildrenVisibility', payload );
                    }
                }
            }
        },

    }
</script>