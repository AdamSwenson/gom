<template>

    <button class="settings-display-control button is-info is-outlined is-large"
            v-bind:title="linkTitle"
            v-on:click="handleClick"
            v-bind:id="serialNumber">

       <span class="icon is-large">
           <i class="fa fa-cogs"
              aria-hidden="true"
           >
               <span class="sr-only">{{ screenReaderText }}</span>
           </i>
       </span>
        <span></span>
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
        name: 'settings-display-control',

        props: [ 'serialNumber' ],

        data: function () {
            return {
                linkTitle: "Toggle the display of this item's children",

                identifiers: {
                    exam: 'exam-settings-button',
                    item: 'item-settings-button'
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

            /**
             * Gets the appropriate base string for the input
             * depending on whether it is attached to an exam or
             * regular item
             */
            identifier: function () {
                return this.isExam ? this.identifiers.exam : this.identifiers.item;
            },

            /**
             * Injected into the classes of the input
             * */
            styling: function () {
                return this.identifier; // + '-' + this.serialNumber;
            },

            screenReaderText: function () {
                if ( this.isVisible ) return 'Click to hide settings panels';
                return 'Click to show settings panels';
            },

            // linkClass: function () {
            //     //unselected state
            //     if ( this.isVisible ) return this.styles.unselected;
            //     //selected (hidden) state
            //     return this.styles.selected;
            // }
        },

        methods: {
            handleClick: function () {
                this.toggleVis();
            },

            toggleExamVisibility: function () {
                this.$store.commit( mTypes.toggleExamSettings, Payload.factory( { mutateSilently: true } ) );
                this.$router.push(
                    {
                        name: 'exam-detail',
                        params: {
                            serialNumber: this.serialNumber,
                            active: 'details'
                        }
                    }
                );
            },

            toggleItemVisibility: function () {
                //item cases
                let isVis = this.$store.getters[ gTypes.isItemSettingsVisible ]( this.serialNumber );

                if ( isVis ) {
                    //if comes back true, we know that currently visible
                    //call the mutation with our index
                    this.$store.commit( mTypes.hideItemSettings, Payload.factory( {
                        serialNumber: this.serialNumber,
                        mutateSilently: true
                    } ) );
                } else {
                    //call the mutation to show with our index
                    this.$store.commit( mTypes.showItemSettings, Payload.factory( {
                        serialNumber: this.serialNumber,
                        mutateSilently: true
                    } ) );
                    this.$router.push( {
                        name: 'item-detail',
                        params: { serialNumber: this.serialNumber, active: 'details' }
                    } );
                }
            },

            toggleVis: function () {
                if ( this.isExam ) {
                    this.toggleExamVisibility();
                }
                else {
                    this.toggleItemVisibility();
                }
            }
        },

        mounted: function () {
        },

    };
</script>
