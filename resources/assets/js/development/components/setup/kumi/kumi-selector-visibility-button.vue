<template>
    <a class="kumi-selector-visibility-button button is-outlined  is-primary"
       v-on:click="toggleSelectorVisibility"
    >
        <slot name="label"></slot>
    </a>

</template>

<style lang="scss">

</style>

<script>
    export default {

        props: [],

        components: {},

        data: function () {
            return {
                defaults: {}
            }
        },

        computed: {},

        methods: {
            toggleSelectorVisibility: function () {
                this.$store.commit( 'toggleKumiSelectVisibility' );
                this.$emit( 'toggled' );
            }
        },

        directives: {},

        events: {},

        mounted: function () {
        }
    }
</script>