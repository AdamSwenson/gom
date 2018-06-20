<template>
    <p class="logout-button field">
        <a class="button logout-button is-info is-outlined"
           v-on:click="handleClick"
        ><span class="icon "><i class="fa fa-power-off" aria-hidden="true"></i></span></a></p>

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

        computed: {
            route: function () {
                return window.routeRoot + '/' + 'logout';
            }
        },

        methods: {
            handleClick: function () {
                window.axios.post( this.route );
                return window.open( this.route, "_self" );
            }
        },

        directives: {},

        events: {},

        mounted: function () {
        }
    }
</script>