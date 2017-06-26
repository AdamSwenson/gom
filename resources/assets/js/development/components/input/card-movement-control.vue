<template>
    <div class="card-movement-control tabs ">
        <ul>
            <li>
                <a v-on:click="moveLeft">
                    <span class="icon"><i class="fa fa-angle-left"></i></span>
                    <span>Left</span>
                </a>
            </li>

            <li>
                <a v-on:click="moveUp">
                    <span class="icon"><i class="fa fa-angle-up"></i></span>
                    <span>Up</span>
                </a>
            </li>

            <li>
                <h5>Move</h5>
            </li>

            <li>
                <a v-on:click="moveDown">
                    <span class="icon"><i class="fa fa-angle-down"></i></span>
                    <span>Down</span>
                </a>
            </li>

            <li>
                <a v-on:click="moveRight">
                    <span>Right</span>
                    <span class="icon"><i class="fa fa-angle-right"></i></span>
                </a>
            </li>

        </ul>
    </div>

</template>

<style lang="scss">

</style>

<script>
    import Item from '../../../models/Item'
    import Payload from '../../../models/Payload'
    export default{

        props: [ 'serialNumber' ],

        components: {},

        data: function () {
            return {
                defaults: {}
            }
        },

        computed: {
            item: function () {
                return this.$store.getters.getItemBySerialNumber( this.serialNumber );
            },
            node: function () {
                return this.$store.getters.getItemNodeFromOrder( this.serialNumber );
            },
            parent: function () {
                return this.$store.getters.getItemNodeFromOrder( this.node.parent );
            }
        },

        methods: {
            //increases position relative to siblings
            moveUp: function () {
                window.console.log( 'card-movement-control', 'moveUp', 65, );
                let payload = Payload.factory( { objNode: this.node, parentNode: this.parent } );
                this.$store.commit('increasePosition', payload)
            },

            /**
             * Decreases position relative to siblings
             */
            moveDown: function () {
                window.console.log( 'card-movement-control', 'moveDown', 69, );
                let payload = Payload.factory( { objNode: this.node, parentNode: this.parent } );
                this.$store.commit('decreasePosition', payload)
            },

            /**
             * Makes sibling of parent
             */
            moveLeft: function () {
                window.console.log( 'card-movement-control', 'moveLeft', 72, );
                let payload = Payload.factory( { objNode: this.node, parentNode: this.parent } );
                this.$store.commit('promote', payload)

            },
            /**
             * Makes into child of its immediate sibling
             */
            moveRight: function () {
                window.console.log( 'card-movement-control', 'moveRight', 75, );
                let payload = Payload.factory( { objNode: this.node, parentNode: this.parent } );
                this.$store.commit('demote', payload)

            }
        },

        directives: {},

        events: {},

        mounted: function () {
        }
    }
</script>