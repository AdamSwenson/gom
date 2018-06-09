<template>
    <a class="remove-kumi-button button "
       v-bind:class="styling"
       v-on:click="removeKumi"
    >
        <span class="icon is-small"><i class="fa fa-recycle" aria-hidden="true"></i></span>
        <span class="is-small">Remove from this exam</span>
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

        props: [ 'kumi' ],

        data: function () {
            return {
                styles: {
                    active: 'is-outlined is-danger',
                    disabled: 'is-disabled'
                },

                defaults: {}
            }
        },

        computed: {
            exam: function () {
                return this.$store.getters[ gTypes.getActiveExam ];
            },

            styling: function () {
                return this.isAssociatedWithActiveExam ? this.styles.active : this.styles.disabled;
            },

            isAssociatedWithActiveExam: function () {
                return this.$store.getters.areKumiAndExamAssociated( { kumi: this.kumi, exam: this.exam } );
            },

        },

        methods: {

            removeKumi: function () {
                this.$store.dispatch( 'removeKumi', Payload.factory( { kumi: this.kumi, exam: this.exam } ) );
            },
        },

    }
</script>