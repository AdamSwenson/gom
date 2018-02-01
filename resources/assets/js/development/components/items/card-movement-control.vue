<template>
    <div class="card-footer">
        <a href="#" class="card-footer-item"
           v-on:click=" moveLeft"
        >
            <span class="icon"><i class="fa fa-angle-left"></i></span>
            <span>Left</span>
        </a>

        <a href="#" class="card-footer-item"
           v-on:click="moveUp"
        >
            <span class="icon"><i class="fa fa-angle-up"></i></span>
            <span>Up</span>
        </a>

        <a href="#" class="card-footer-item"
           v-on:click="remove"
        >
            <span class="icon is-small has-text-danger ">
                <i class="fa fa-times" aria-hidden="true"></i>
            </span>
            <span class="has-text-danger">Remove</span>
        </a>

        <a href="#" class="card-footer-item"
           v-on:click=" moveDown"
        >
            <span class="icon"><i class="fa fa-angle-down"></i></span>
            <span>Down</span>
        </a>
        <a href="#" class="card-footer-item"
           v-on:click=" moveRight"
        >
            <span>Right</span>
            <span class="icon"><i class="fa fa-angle-right"></i></span>
        </a>
    </div>
    <!---->
    <!--<div class="card-movement-control tabs ">-->
    <!--<ul>-->
    <!--<li>-->
    <!--<a v-on:click="moveLeft">-->
    <!--<span class="icon"><i class="fa fa-angle-left"></i></span>-->
    <!--<span>Left</span>-->
    <!--</a>-->
    <!--</li>-->

    <!--<li>-->
    <!--<a v-on:click="moveUp">-->
    <!--<span class="icon"><i class="fa fa-angle-up"></i></span>-->
    <!--<span>Up</span>-->
    <!--</a>-->
    <!--</li>-->

    <!--<li>-->
    <!--<h5>    </h5>-->
    <!--</li>-->

    <!--<li>-->
    <!--<a v-on:click="moveDown">-->
    <!--<span class="icon"><i class="fa fa-angle-down"></i></span>-->
    <!--<span>Down</span>-->
    <!--</a>-->
    <!--</li>-->

    <!--<li>-->
    <!--<a v-on:click="moveRight">-->
    <!--<span>Right</span>-->
    <!--<span class="icon"><i class="fa fa-angle-right"></i></span>-->
    <!--</a>-->
    <!--</li>-->

    <!--</ul>-->
    <!--</div>&lt;!&ndash;&ndash;&gt;-->

</template>

<style lang="scss">

</style>

<script>
    import Item from '../../../models/Item'
    import Payload from '../../../models/Payload'

    import mixin from './item-buttons.mixin';
    export default {
        mixins: [mixin],

        props: ['item' ],

        data: function () {
            return {
                defaults: {}
            }
        },

        methods: {
            //increases position relative to siblings
            moveUp: function () {
                window.console.log( 'card-movement-control', 'moveUp', 65, );
                let payload = Payload.factory( { objNode: this.node, parentNode: this.parent } );
                this.$store.commit( 'increasePosition', payload )
            },

            /**
             * Decreases position relative to siblings
             */
            moveDown: function () {
                window.console.log( 'card-movement-control', 'moveDown', 69, );
                let payload = Payload.factory( { objNode: this.node, parentNode: this.parent } );
                this.$store.commit( 'decreasePosition', payload )
            },

            /**
             * Makes sibling of parent
             */
            moveLeft: function () {

                let payload = Payload.factory( {
                    objNode: this.node,
                    parentNode: this.parent
                } );

                window.console.log( 'card-movement-control', 'moveLeft', 72, payload );

                this.$store.commit( 'promote', payload )

            },
            /**
             * Makes into child of its immediate sibling
             */
            moveRight: function () {
                let payload = Payload.factory( { objNode: this.node, parentNode: this.parent } );
                window.console.log( 'card-movement-control', 'moveRight', 75, payload );

                this.$store.commit( 'demote', payload )

            },

            remove: function () {
                window.console.log( 'card-movement-control', 'remove', 151, this.item );
                this.$store.dispatch( aTypes.removeItem, { obj: this.item } );

            }
        },

    }
</script>