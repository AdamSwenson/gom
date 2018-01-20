<template>
    <div class="kumi-tabs tabs is-boxed">

        <ul>
            <show-all-kumi-control type="tab"
                                   :is-active="isActive(-1)"
                                   :is-visible="isAllTabVisible"
            ></show-all-kumi-control>


            <kumi-tab v-if="kumiCount > 0"
                      v-for="kumi in kumis"
                      :kumi="kumi"
                      v-bind:key="kumi.serialNumber"
            ></kumi-tab>


            <!--<new-kumi-control type="tab"></new-kumi-control>-->

            <!--<edit-kumi-control type="tab"-->
                               <!--:is-editable="isEditable"-->
                               <!--v-on:toggle-kumi-editable="toggleEditable"-->
            <!--&gt;</edit-kumi-control>-->

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
            kumis: function () {
                let k = this.$store.getters[ gTypes.getKumisForExam ]( this.exam );
                if ( !_.isUndefined( k ) && !_.isNull( k ) ) return k;
                return null;
            },
            // kumis: function () {
            //     return this.$store.getters[ gTypes.getKumisForExam ]( this.exam );;
            //     return this.$store.getters[ gTypes.getAllKumis ];
            // },

            kumiCount: function () {
                if ( _.isNull( this.kumis ) || _.isUndefined( this.kumis ) ) return 0;
                return this.kumis.length;
            },
            exam: function () {
                return this.$store.getters[ gTypes.getActiveExam ];
            },

            displayedKumis: function () {
                return this.$store.getters.getDisplayedKumis;
            }

        },

        methods: {
            showAllKumi: function () {
                this.$store.commit( 'clearDisplayedKumis' );
            },

            handleKumiSelection: function ( kumi ) {
                // window.console.log( 'kumi-tabs', 'handleKumiSelection', 151, kumi );
                //This could be accidentally called when the area
                //is open for editing.
                //Thus we filter any such calls out
                if ( this.isEditable ) return true;

                this.$store.commit( 'toggleKumi', Payload.factory( { obj: kumi } ) );

            },

            isActive: function ( kumi ) {
//                return this.$store.getters.isKumiDisplayed(kumi);
                return this.displayedKumis.indexOf( kumi ) !== -1;
            },


            toggleEditable: function () {
                this.isEditable = !this.isEditable;
            },


        },

    }
</script>