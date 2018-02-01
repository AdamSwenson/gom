<template>
    <a class="button is-primary is-outlined item-clone-button"
       v-on:click="handleClick"
    >
        <span class="icon is-small">
            <i class="fa fa-clone" aria-hidden="true"></i>
        </span>
        <span>Clone</span>
    </a>
</template>

<style lang="scss">

</style>

<script>

    import * as aTypes from '../../../store/action-types';

    import mixin from './item-buttons.mixin';
    export default {
        mixins: [mixin],

        props: ['item'],


        components: {},

        data: function () {
            return {
                defaults: {}
            }
        },

        computed: {
            // item: function () {
            //     return this.$store.getters.getItemBySerialNumber( this.serialNumber );
            // },
            //
            // node: function () {
            //     return this.$store.getters.getItemNodeFromOrder( this.serialNumber );
            // },
            //
            // parentSerialNumber: function () {
            //     return this.node.parent;
            // },

        },

        methods: {
            handleClick: function () {
                let payload = { parent: this.parentSerialNumber, toClone: this.item };
                this.$store.dispatch( aTypes.cloneItem,  payload);
            }
        },

        directives: {},

        events: {},

        mounted: function () {
        }
    }
</script>