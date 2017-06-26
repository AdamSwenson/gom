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

        props: [ 'index' , 'isExam', 'serialNumber'],

        data: function () {
            return {};
        },

        computed: {
            settingsButtonId: function () {
                return 'item-settings-button-' + this.serialNumber;
            }
        },

        methods: {
            toggleVis: function () {
                if ( this.isExam ) {
                    //exam case
                    this.$store.commit( mTypes.toggleExamSettings , Payload.factory({mutateSilently: true}));
                    this.$router.push( { name: 'exam-detail', params: { serialNumber: this.serialNumber, active: 'details' } } );

                }
                else  {
                    //item cases
                    let isVis = this.$store.getters[ gTypes.isItemSettingsVisible ]( this.serialNumber );

                    if ( isVis ) {
                        //if comes back true, we know that currently visible
                        //call the mutation with our index
                        this.$store.commit( mTypes.hideItemSettings, Payload.factory( { serialNumber: this.serialNumber, mutateSilently: true } ) );
                    } else {
                        //call the mutation to show with our index
                        this.$store.commit( mTypes.showItemSettings, Payload.factory( { serialNumber: this.serialNumber, mutateSilently: true } ) );
                        this.$router.push( { name: 'item-detail', params: { serialNumber: this.serialNumber, active: 'details' } } );
                    }
                }
            }
        },

        mounted: function () {
        },

    };
</script>
