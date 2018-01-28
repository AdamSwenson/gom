<template>
    <div class="kumi-tabs tabs is-boxed">

        <ul>
            <li v-bind:class="[isAllTabActive ? 'is-active' : '' ]">
                <show-all-kumi-control type="tab"
                                       :is-active="isAllTabActive"
                                       :is-visible="isAllTabVisible"
                ></show-all-kumi-control>
            </li>


            <kumi-tab v-if="kumiCount > 0"
                      v-for="kumi in kumis"
                      :kumi="kumi"
                      v-bind:key="kumi.serialNumber"
            ></kumi-tab>

        </ul>
    </div>
</template>

<style lang="scss">

</style>

<script>
    import KumiNameField from './kumi-name-field.vue';
    import Payload from "../../../../models/Payload";
    import Kumi from "../../../../models/Kumi";
    import EditKumiControl from "./edit-kumi-control.vue";
    import NewKumiControl from "./new-kumi-control.vue";
    import ShowAllKumiControl from "./show-all-kumi-control.vue";
    import * as mTypes from '../../../../store/mutation-types';
    import * as aTypes from '../../../../store/action-types';
    import * as gTypes from '../../../../store/getter-types';
    import KumiTab from "./kumi-tab";


    export default {

        props: [],

        components: {
            KumiTab,
            ShowAllKumiControl,
            NewKumiControl,
            EditKumiControl,
            'kumi-name': KumiNameField,
        },

        data: function () {
            return {
                defaults: {},

                isAllTabVisible: true,

                //Whether the kumi properties are editable
                isEditable: false,
            }
        },

        asyncComputed: {
            // kumis: function () {
            //     let k = this.$store.getters[ gTypes.getKumisForExam ]( this.exam );
            //     if ( !_.isUndefined( k ) && !_.isNull( k ) ) return k;
            //     return null;
            // },
            //
            // kumiCount: function () {
            //     if ( _.isNull( this.kumis ) || _.isUndefined( this.kumis ) ) return 0;
            //     return this.kumis.length;
            // },

        },


        computed: {
            /**
             * All kumis associated with the exam
             */
            kumis: function () {
                let k = this.$store.getters[ gTypes.getKumisForExam ]( this.exam );
                if ( !_.isUndefined( k ) && !_.isNull( k ) ) return k;
                return null;
            },

            /**
             * Returns the number of kumis
             * This is mainly used to prevent the component from
             * trying to render non-existent kumis.
             */
            kumiCount: function () {
                if ( _.isNull( this.kumis ) || _.isUndefined( this.kumis ) ) return 0;
                return this.kumis.length;
            },

            exam: function () {
                return this.$store.getters[ gTypes.getActiveExam ];
            },

            /**
             * List of kumis to filter the displayed students by
             */
            displayedKumis: function () {
                return this.$store.getters.getKumisToFilterStudentsBy;
            },

            /**
             * Whether the 'all' tab is selected
             * @returns {boolean}
             */
            isAllTabActive: function () {
                return this.displayedKumis.length === 0;
            }

        },

        methods: {

            toggleEditable: function () {
                this.isEditable = !this.isEditable;
            },

        },

    }
</script>