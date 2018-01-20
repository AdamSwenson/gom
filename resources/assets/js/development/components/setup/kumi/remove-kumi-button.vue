<template>
    <a class="button remove-kumi-control"
       v-bind:class="styling"
       v-on:click="removeKumi"
    >
        <span class="icon is-small"><i class="fa fa-recycle" aria-hidden="true"></i></span>
        <span class="is-small">Remove</span>
        <span class="sr-only">Remove group button</span>
    </a>
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

        props: ['kumi'],

        data: function () {
            return {
                styling:'is-outlined is-danger',

                defaults: {}
            }
        },

        computed : {
            exam : function (  ) {
          return this.$store.getters[gTypes.getActiveExam];
            }
        },

        methods: {

            removeKumi: function (  ) {
                this.$store.dispatch( 'removeKumi', Payload.factory( { kumi: this.kumi, exam : this.exam } ) );
            },
        },

    }
</script>