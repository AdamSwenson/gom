<template>
    <a class="new-kumi-control button "
       v-bind:class="styling"
       v-on:click="newKumi"
    >
        <span class="icon"><i class="fa fa-plus" aria-hidden="true"></i></span>
        <span class="">New group</span>
        <span class="sr-only">Create new group button</span>
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

        props: ['type', 'isVisible'],

        components: {},

        data: function () {
            return {
                buttonColor : 'is-info',
                defaults: {}
            }
        },

        computed: {
            styling: function () {
                    let out = '';
                    switch ( this.type ) {
                        case  'tab':
                            out += ' tab ';
                            break;
                        case 'button':
                            out += ' button ';
                            out += 'is-outlined ';
                            out += this.buttonColor;
                            break;
                    }

                    return out;

            },

            isKumiEditModalVisible : function (  ) {
                return this.$store.getters.isKumiEditModalVisible;
            },

        },

        methods: {

            newKumi: function ( evt ) {
                //Create a new kumi object
                this.$store.dispatch( 'createKumi');

                //If the edit modal is not already visible, then toggle it open
                //so we can edit the new kumi
                if(! this.isKumiEditModalVisible) this.$store.commit('toggleEditKumiModal');
            },

        },

    }
</script>