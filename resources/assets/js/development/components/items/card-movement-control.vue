<template>
    <div class="card-movement-control card-footer">
        <a href="#"
           class="move-left-control card-footer-item"
           title="Make the item a sibling of it's parent"
           v-on:click="moveLeft"
        >
            <span class="icon">
                <i aria-hidden="true"
                   class="fa fa-angle-left">
                    <span class="sr-only">Click to make item a sibling of it's parent</span>
                </i></span>
            <span class=" is-hidden-mobile ">Left</span>
        </a>

        <a href="#"
           class="move-up-control card-footer-item"
           title="Move the item up in the order of it's siblings"
           v-on:click="moveUp"
        >
            <span class="icon">
                <i aria-hidden="true"
                   class="fa fa-angle-up">
                    <span class="sr-only">Click to promote the item</span>
                </i>
            </span>
            <span  class=" is-hidden-mobile ">Up</span>
        </a>

        <a href="#"
           class="remove-control card-footer-item"
           title="Remove the item from this exam"
           v-on:click="remove"
        >
            <span class="icon is-small has-text-danger ">
                <i class="fa fa-times" aria-hidden="true">
                    <span class="sr-only">Click to remove item (the item will still exist, it just won't be part of this exam)</span>
                </i>
            </span>
            <span class="has-text-danger is-hidden-mobile">Remove</span>
        </a>

        <a href="#"
           class="move-down-control card-footer-item"
           title="Move the item down in the order of siblings"
           v-on:click=" moveDown"
        >
            <span class="icon">
                <i aria-hidden="true"
                   class="fa fa-angle-down"
                >
                    <span class="sr-only">Click to demote the item</span>
                </i>
            </span>
            <span  class=" is-hidden-mobile ">Down</span>
        </a>

        <a href="#"
           class="move-right-control card-footer-item"
           title="Make the item a child of it's older sibling"
           v-on:click=" moveRight"
        >
            <span  class=" is-hidden-mobile ">Right</span>
            <span class="icon">
                <i aria-hidden="true"
                   class="fa fa-angle-right"
                >
                    <span class="sr-only">Click to make the item it's sibling's child</span>
                </i>
            </span>
        </a>
    </div>

</template>

<style lang="scss">

</style>

<script>
    import Item from '../../../models/Item'
    import Payload from '../../../models/Payload'
    import * as aTypes from '../../../store/action-types';

    import mixin from './item-buttons.mixin';

    export default {
        mixins: [ mixin ],

        props: [ 'item' ],

        data: function () {
            return {
                defaults: {}
            }
        },

        methods: {
            //increases position relative to siblings
            moveUp: function () {
                window.console.log( 'card-movement-control', 'moveUp', 65, );
                let payload = Payload.factory( {
                    objNode: this.node, parentNode: this.parent, type: 'increasePosition'
                } );
                this.$store.dispatch( aTypes.updateItemOrder, payload );
                // this.$store.commit( 'increasePosition', payload )
            },

            /**
             * Decreases position relative to siblings
             */
            moveDown: function () {
                window.console.log( 'card-movement-control', 'moveDown', 69, );
                let payload = Payload.factory( {
                    objNode: this.node, parentNode: this.parent, type: 'decreasePosition'
                } );
                this.$store.dispatch( aTypes.updateItemOrder, payload );
                // this.$store.commit( 'decreasePosition', payload )

            },

            /**
             * Makes sibling of parent
             */
            moveLeft: function () {

                let payload = Payload.factory( {
                    objNode: this.node,
                    parentNode: this.parent,
                    type: 'promote'
                } );

                window.console.log( 'card-movement-control', 'moveLeft', 72, payload );
                this.$store.dispatch( aTypes.updateItemOrder, payload );
                // this.$store.commit( 'promote', payload )

            },
            /**
             * Makes into child of its immediate sibling
             */
            moveRight: function () {
                let payload = Payload.factory( { objNode: this.node, parentNode: this.parent, type: 'demote' } );
                window.console.log( 'card-movement-control', 'moveRight', 75, payload );

                this.$store.dispatch( aTypes.updateItemOrder, payload );

                // this.$store.commit( 'demote', payload )

            },

            remove: function () {
                // window.console.log( 'card-movement-control', 'remove', 151, this.item );
                this.$store.dispatch( aTypes.removeItemFromOrder, { obj: this.item } );

            }
        },

    }
</script>