<template>

    <button type="button"
            class="btn settings-button"
            v-on:click="toggleVis"
    >
        <span class="glyphicon glyphicon-cog"></span>
    </button>

</template>
<style>

</style>

<script>

    import Item from '../../models/Item'
    import Payload from '../../models/Payload'
    import * as mTypes from '../../store/mutation-types'
    import * as gTypes from '../../store/getter-types'

    /**
     * Handles showing and hiding the item settings pane
     *
     * Created by adam on 2/18/17.
     */
    export default {

        props: [ 'index'],

        data: function () {
            return {};
        },

        computed: {},

        methods: {
                toggleVis: function () {
                    console.log( 'buttons.settings-control', 'CALLED', 'toggle' , this.index);
                    let isVis = this.$store.getters[ gTypes.isItemSettingsVisible ]( this.index );
//                    console.log( 'isvis', isVis );
                    if(isVis){
                        //if comes back true, we know that currently visible
                        //call the mutation with our index
                        this.$store.commit( mTypes.hideItemSettings, Payload.factory( {index: this.index} ) );
                    }else {
//                    let mutation = this.$store.getters[ gTypes.isItemSettingsVisible ]( this.index ) ? mTypes.showItemSettings : mTypes.hideItemSettings;

                        //call the mutation to show with our index
                        this.$store.commit( mTypes.showItemSettings, Payload.factory( {index: this.index} ) );
                    }
                }
        },

        mounted: function () {
        },
    };
</script>
