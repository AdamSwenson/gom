<template>
    <p class="kumi-tabs is-boxed">
        <a v-if="isAllTabVisible"
           v-on:click="showAllKumi"
           v-bind:class="[isActive(-1) ? 'is-active' : '' ]"
        >All</a>

        <a v-for="kumi in kumis"
           v-bind:key="kumi.serialNumber"
           v-on:click="handleKumiSelection(kumi)"
           v-bind:class="[isActive(kumi) ? 'is-active' : '' ]"
        >
            <span v-if="isEditable">
                    <kumi-name :serialNumber="kumi.serialNumber"></kumi-name>
            </span>

            <span v-else
            class="is-small">
                    {{ kumi.name }}
            </span>
        </a>


        <a class="button-tab">
            <button id="new-kumi-button"
                    class="button is-outlined is-small"
                    v-on:click="newKumi"
            >
                <span class="icon is-small"><i class="fa fa-plus" aria-hidden="true"></i></span>
                <span class="is-small">New</span>
                <span class="sr-only">New group button</span>
            </button>
        </a>

        <a class="button-tab">
            <button id="edit-kumi-button"
                    class="button is-outlined is-small"
                    v-on:click="toggleEditable"
            >
                <span v-if="isEditable">
                    <span class="icon is-small"><i class="fa fa-check-circle-o " aria-hidden="true"></i></span>
                    <span class="is-small">Edit</span>
                    <span class="sr-only">Edit button in selected state</span>
                </span>

                <span v-else>
                    <span class="icon"><i class="fa fa-pencil" aria-hidden="true"></i></span>
                    <span class="is-small">Edit</span>
                    <span class="sr-only">Edit button in unselected state</span>
                </span>

            </button>
        </a>
    </p>
</template>

<style lang="scss">

</style>

<script>
    import KumiNameField from '../../input/kumi-name-field.vue';
    import Payload from "../../../../models/Payload";
    import Kumi from "../../../../models/Kumi";


    export default {

        props: [],

        components: {
            'kumi-name': KumiNameField,
        },

        data: function () {
            return {
                defaults: {},

                isAllTabVisible: false,

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
                window.console.log( 'kumi-tabs', 'handleKumiSelection', 151, kumi );
                //This could be accidentally called when the area
                //is open for editing.
                //Thus we filter any such calls out
                if ( this.isEditable ) return true;

                this.$store.commit( 'toggleKumi', Payload.factory( { obj: kumi } ) );

            },

            isActive: function ( kumi ) {
                window.console.log( 'kumi-tabs', 'isActive', 118, kumi, this.displayedKumis);
//                return this.$store.getters.isKumiDisplayed(kumi);
                return this.displayedKumis.indexOf( kumi ) !== -1;
            },


            newKumi: function ( evt ) {
                //should open a pane for creating or editing kumi
                let kumi = new Kumi(); //completely empty
                this.$store.commit( 'addKumi', Payload.factory( { obj: kumi } ) );
                //toggle open the edit fields if not already displayed
                if ( !this.isEditable ) this.isEditable = true;

            },

            toggleEditable: function () {
                this.isEditable = !this.isEditable;
            },


        },

        directives: {},

        events: {},

        mounted: function () {
        }
    }
</script>