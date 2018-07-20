<template>

    <button class="children-display-control button is-large"
            v-bind:title="linkTitle"
            v-bind:class="linkClass"
            v-on:click="handleClick"
    >
        <span class="icon is-large">
           <i class="fa fa-sitemap"
              aria-hidden="true"
           >
               <span class="sr-only">{{ screenReaderText }}</span>
           </i>
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
        name: 'children-display-control',

        props: [ 'serialNumber' ],

        data: function () {
            return {
                linkTitle: "Toggle the display of this item's children",

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

            numberChildren: function () {
                let c = this.$store.getters.getItemChildren( this.item );
                return (!_.isUndefined( c ) && !_.isNull( c )) ? c.length : 0;
            },

            isVisible: function () {
                return this.$store.getters.isItemChildrenVisible( this.serialNumber );
            },

            screenReaderText: function () {
                if ( this.isVisible ) return 'Click to hide children';
                return 'Click to show children';
            },

            linkClass: function () {
                //unselected state
                if ( this.isVisible ) return this.styles.unselected;
                //selected (hidden) state
                return this.styles.selected;
            }
        },


        methods: {
            handleClick: function () {
                this.toggleVisibility();
            },

            /**
             * Changes the stored state for visibility of children
             */
            toggleVisibility: function () {
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