<template>

    <button class="button children-display-control is-info is-outlined is-large"
            v-on:click="toggleVisibility"
            v-bind:id="buttonId"><span class="icon is-large">
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

        props: [ 'index' , 'isExam', 'serialNumber'],

        data: function () {
            return {};
        },

        computed: {
            buttonId: function () {
                return 'children-display-button-' + this.serialNumber;
            },

            //for toggling the display state of the button
            isActive: function(){

            }

        },

        methods: {
            toggleVisibility: function () {
                //change stored state
                window.console.log( 'children-display-control', 'toggleVisibility', 45, this.serialNumber);
//            this.$state.commit();
            }
        },

        directives: {},

        events: {},

        mounted: function () {
        }
    }
</script>