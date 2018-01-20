<template>
    <div class="modal"
         v-bind:class="[isVisible ? 'is-active' : '' ]"
    >
        <div class="modal-background"></div>
        <div class="modal-card">

            <header class="modal-card-head">
                <p class="modal-card-title">
                    <slot name="modalTitle">
                        <h3 class="title is-3">Edit groups</h3>
                    </slot>
                </p>
                <a class="button is-primary" aria-label="close" v-on:click="toggleModal">Done</a>
            </header>

            <section class="modal-card-body">

                <div v-if="kumiCount > 0"
                     v-for="kumi in kumis"
                     v-bind:key="kumi.serialNumber"
                >
                    <div class="field has-addons has-addons-centered">
                        <p class="control is-fullwidth">
                            <kumi-name-field :kumi="kumi"></kumi-name-field>
                        </p>
                        <p class="control">
                            <remove-kumi-control :kumi="kumi"></remove-kumi-control>
                        </p>
                    </div>
                </div>

                <p class="">Highlighted groups have students related to this exam</p>

            </section>

            <footer class="modal-card-foot">
                <new-kumi-control></new-kumi-control>
                <button class="button" v-on:click="toggleModal">Done</button>
            </footer>
        </div>
    </div>
</template>

<style lang="scss">

</style>

<script>
    import * as mTypes from '../../../../store/mutation-types';
    import * as aTypes from '../../../../store/action-types';
    import * as gTypes from '../../../../store/getter-types';
    import KumiNameField from "./kumi-name-field";
    import RemoveKumiControl from "./remove-kumi-button";
    import NewKumiControl from "./new-kumi-control";

    export default {

        props: [
            //whether the modal is currently visible
        ],

        components: {
            NewKumiControl,
            RemoveKumiControl,
            KumiNameField
        },

        data: function () {
            return {
                defaults: {}
            }
        },


        computed: {
            isVisible: function () {
                return this.$store.getters.isKumiEditModalVisible;
            },

            kumis: function () {
                return this.$store.getters[ gTypes.getAllKumis ];
            },

            kumiCount: function () {
                if ( _.isNull( this.kumis ) || _.isUndefined( this.kumis ) ) return 0;
                return this.kumis.length;
            }
        },

        methods: {
            toggleModal: function () {
                this.$store.commit( 'toggleEditKumiModal' );
            }
        },

    }
</script>