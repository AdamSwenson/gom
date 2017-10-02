<template>
    <a class="button is-primary is-outlined item-import-button"
       v-on:click="handleClick"
    >
        <span class="icon is-small">
            <i class="fa fa-mail-forward" aria-hidden="true"></i>
        </span>
        <span>Import item</span>
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
            handleClick: function () {

            }
        },

        directives: {},

        events: {},

        mounted: function () {
        }
    }
</script>