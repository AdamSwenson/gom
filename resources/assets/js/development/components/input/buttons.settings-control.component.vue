<template>

    <button class="button settings-button is-info is-outlined is-large"
            v-on:click="toggleVis"
            v-bind:id="settingsButtonId">

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

        props: [ 'index' ],

        data: function () {
            return {};
        },

        computed: {

            addYoungerSiblingButtonId: function () {
                return 'younger-sibling-add-button-' + this.index;
            },

            addOlderSiblingButtonId: function () {
                return 'older-sibling-add-button-' + this.index;
            },
            settingsButtonId: function () {
                return 'item-settings-button-' + this.index;
            }
        },

        methods: {
            addOlderSibling: function () {
                this.$store.dispatch( aTypes.addOlderSibling, Payload.factory( { index: this.index } ) );
            },


            addYoungerSibling: function () {
                this.$store.dispatch( aTypes.addYoungerSibling, Payload.factory( { index: this.index } ) );
            },


            toggleVis: function () {
                if ( this.index === 0 ) {
                    //exam case
                    this.$store.commit( mTypes.toggleExamSettings );
                }
                else if ( this.index > 0 ) {
                    //item cases
                    let isVis = this.$store.getters[ gTypes.isItemSettingsVisible ]( this.index );
                    if ( isVis ) {
                        //if comes back true, we know that currently visible
                        //call the mutation with our index
                        this.$store.commit( mTypes.hideItemSettings, Payload.factory( { index: this.index } ) );
                    } else {

                        //call the mutation to show with our index
                        this.$store.commit( mTypes.showItemSettings, Payload.factory( { index: this.index } ) );
                        this.$router.push( { name: 'item-detail', params: { index: this.index, active: 'details' } } );
                    }
                }
            }
        },

        mounted: function () {
        },

    };
</script>
