<template>
    <div
            class="buttons-depth-control item-nav-component "
            v-on:click="goTo"
    >
        <div class="nav-arrow text-center">
            <span v-bind:class="arrow"></span>
        </div>
    </div>
</template>
<style>

</style>
<script>
    /**
     * Created by adam on 2/17/17.
     */
    import * as aTypes from '../../../store/action-types';
    import * as mTypes from '../../../store/mutation-types';
    import Payload from '../../../models/Payload'

    /**
     * These make an item into a child of another or makes them into siblings.
     *
     * @type {{template: *, props: Array, data: module.exports.data, computed: {}, methods: {}, directives: {}, events: {}, ready: module.exports.ready}}
     */
    export default {

        props: [
            'index',
            'type' //promote, demote
        ],

        data: function () {
            return {
                icons: {
                    leftArrow: 'glyphicon glyphicon-arrow-left',
                    rightArrow: 'glyphicon glyphicon-arrow-right'
                    // leftArrow: 'glyphicon glyphicon-chevron-left',
                    // rightArrow: 'glyphicon glyphicon-chevron-right'
                }
            };
        },

        computed: {

            /**
             * Returns the appropriate icon
             */
            arrow: function () {
                switch ( this.type ) {
                    case 'promote':
                        return this.icons.leftArrow;
                        break;

                    case 'demote':
                        return this.icons.rightArrow;
                        break;

                    default:
                        return '';
                }

            }
        },


        methods: {
            showLeft: function () {
                let item = this.$store.getters.getItemByIndex( this.index );
                //  if(item.depth > 0){
                return true;
                //}
                //return false;
            },

            goTo: function () {
                switch ( this.type ) {
                    case 'promote':
                        return this.promoteItem();
                        break;

                    case 'demote':
                        return this.demoteItem();
                        break;

                    default:
                }
            },

            /**
             * Requests that the item be made into a sibling of its former parent
             *
             */
            promoteItem: function () {
                console.log( 'CALLED', 'promoteItem' );
                let pl = Payload.factory( {index: this.index} );
                this.$store.dispatch( aTypes.promoteItem, pl );
            },

            /**
             * Requests that an item be made a child of another
             */
            demoteItem: function () {
                console.log( 'CALLED', 'demoteItem' );
                let pl = Payload.factory( {index: this.index} );
                this.$store.dispatch( aTypes.demoteItem, pl );
            },
        },

        directives: {},

        events: {},

        mounted: function () {
//            console.log( 'itemNav ready ', this.type );
        },
    };
</script>
