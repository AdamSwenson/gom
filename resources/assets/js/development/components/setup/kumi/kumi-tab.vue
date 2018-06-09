<template>
    <li class="kumi-tab"
        v-bind:class="[isActive ? 'is-active' : '' ]"
    >
        <a v-on:click="handleKumiSelection">
            {{ kumi.name }}
        </a>
    </li>
</template>

<style lang="scss">

</style>

<script>
    import Payload from "../../../../models/Payload";
    import Kumi from "../../../../models/Kumi";
    import * as mTypes from '../../../../store/mutation-types';
    import * as aTypes from '../../../../store/action-types';
    import * as gTypes from '../../../../store/getter-types';


    export default {

        props: [ 'kumi' ],

        components: {},

        data: function () {
            return {
                defaults: {}
            }
        },

        computed: {
            displayedKumis: function () {
                return this.$store.getters.getKumisToFilterStudentsBy;
            },

            isActive: function () {
                if (_.isUndefined(this.displayedKumis)) return false;

                return _.indexOf(this.displayedKumis, this.kumi ) !== -1;
            }
        },

        methods: {
            handleKumiSelection: function () {
                this.$store.commit( 'toggleKumi', Payload.factory( { obj: this.kumi } ) );
            },

        },

    }
</script>