<template>
    <div class="kumi-tabs tabs is-boxed">

        <show-all-kumi-control type="tab"
                               :is-active="isActive(-1)"
                               :is-visible="isAllTabVisible"
        ></show-all-kumi-control>


        <a v-for="kumi in kumis"
           v-bind:key="kumi.serialNumber"
           v-on:click="handleKumiSelection(kumi)"
           v-bind:class="[isActive(kumi) ? 'is-active' : '' ]"
        >
            <span v-if="isEditable">
                    <kumi-name :serialNumber="kumi.serialNumber"></kumi-name>
            </span>

            <span v-else >{{ kumi.name }}</span>
        </a>

        <new-kumi-control type="tab"></new-kumi-control>

        <edit-kumi-control type="tab"
                           :is-editable="isEditable"
                           v-on:toggle-kumi-editable="toggleEditable"
        ></edit-kumi-control>

    </div>
</template>

<style lang="scss">

</style>

<script>
    import KumiNameField from '../../input/kumi-name-field.vue';
    import Payload from "../../../../models/Payload";
    import Kumi from "../../../../models/Kumi";
    import EditKumiControl from "./edit-kumi-control.vue";
    import NewKumiControl from "./new-kumi-control.vue";
    import ShowAllKumiControl from "./show-all-kumi-control.vue";


    export default {

        props: [],

        components: {
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
            kumis: function () {
                return this.$store.getters.getKumis;
            },
        },


        computed: {

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