<template>

    <button class="settings-display-control button is-info is-outlined is-large"
            v-on:click="toggleVis"
            v-bind:id="serialNumber">

       <span class="icon is-large">
           <i class="fa fa-cogs" aria-hidden="true"></i>
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

        props: [ 'serialNumber' ],

        data: function () {
            return {
                identifiers: {
                    exam: 'exam-settings-button',
                    item: 'item-settings-button'
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
            //
            // node: function () {
            //     return this.$store.getters.getItemNodeFromOrder( this.serialNumber );
            // },
            //
            // depth: function () {
            //     return this.$store.getters[ gTypes.getDepthOfNode ]( this.serialNumber );
            // },
            //
            //
            // height: function () {
            //     return this.$store.getters[ gTypes.getHeightOfNode ]( this.serialNumber );
            // },


            // parentSerialNumber: function () {
            //     return this.node.parent;
            // },

            /**
             * Gets the appropriate base string for the input
             * depending on whether it is attached to an exam or
             * regular item
             */
            identifier: function () {
                return this.isExam ? this.identifiers.exam : this.identifiers.item;
            },
            //
            // /**
            //  * The input's css id
            //  */
            // id: function () {
            //     if ( this.isExam ) return this.identifier;
            //     return this.identifier + "-" + this.height + '-' + this.depth;
            // },

            /**
             * Injected into the classes of the input
             * */
            styling: function () {
                return this.identifier; // + '-' + this.serialNumber;
            }
        },

        methods: {

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
