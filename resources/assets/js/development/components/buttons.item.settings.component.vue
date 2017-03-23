<template>
    <button
            class="btn settings-button"
            v-on:click="openItemSettings"
    >
        <span class="glyphicon glyphicon-cog"></span>
    </button>

</template>
<style>

</style>

<script>
    /**
     * Created by adam on 2/18/17.
     */
    export default {

        props: [],

        data: function () {
            return {};
        },

        computed: {},

        methods: {
            /**
             * Requests that the item properties area
             * be displayed
             */
            openItemSettings: function () {
                console.log( 'CALLED', 'openItemSettings' );
                this.requestSettingsDisplay();
            },

            /**
             * Emits an event caught by the parent.
             * The catching object will handle the opening.
             * Thus there is no need for this button to know
             * who it belongs to
             */
            requestSettingsDisplay: function(){
                this.$store.dispatch('display-settings');
            }
        },

        directives: {},

        events: {},

        mounted: function () {
        },
    };
</script>
