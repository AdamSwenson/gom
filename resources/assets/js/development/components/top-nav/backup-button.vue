<template>
    <p class="field">
        <a class="button backup-button is-info is-outlined"
           v-on:click="handleClick"
        ><span class="icon "><i class="fa fa-power-off" aria-hidden="true"></i></span></a></p>

</template>

<style lang="scss">

</style>

<script>
    export default {

        props: ["exam"],

        components: {},

        data: function () {
            return {
                defaults: {}
            }
        },

        computed: {
            route: function () {
                return window.routeRoot +  '/backup/' + this.exam.id;
            }
        },

        methods: {
            handleClick: function () {
                window.axios.get( this.route );
              }
        },

        directives: {},

        events: {},

        mounted: function () {
        }
    }
</script>