<!--<template>-->
    <!--<p class="logout-button field">-->
        <!--<a class="button logout-button is-info is-outlined"-->
           <!--v-on:click="handleClick"-->
           <!--title="Logout"-->
        <!--&gt;-->
            <!--<span class="icon ">-->
                <!--<i class="fa fa-power-off" aria-hidden="true">-->
                    <!--<span class="sr-only">Click to logout</span>-->
                <!--</i>-->
            <!--</span>-->
        <!--</a>-->
    <!--</p>-->

<!--</template>-->

<style lang="scss">

</style>

<script>
    import NavbarButtonBase from './navbar-button-base';

    export default {
        extends: NavbarButtonBase,

        props: [],

        components: {},

        data: function () {
            return {
                buttonText: '',
                screenReaderText: 'Click to logout',
                icon : "fa fa-power-off",
                linkTitle: 'Logout',
                linkClass: 'logout-button is-info is-outlined',
                identifyingClass: 'logout-button',

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