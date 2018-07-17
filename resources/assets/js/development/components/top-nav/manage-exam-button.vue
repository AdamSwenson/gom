<!--<template>-->
    <!--<p class="manage-exam-button field">-->
        <!--<a class="button  is-success is-outlined"-->
           <!--v-on:click="handleClick"-->
        <!--&gt;-->
        <!--<span class="icon is-small">-->
            <!--<i class="fa fa-arrow-left" aria-hidden="true"></i>-->
        <!--</span>-->
            <!--<span>{{ label }}</span>-->
        <!--</a>-->
    <!--</p>-->
<!--</template>-->

<style lang="scss">

</style>

<script>
    /**
     * This is the button which takes the user
     * back to the setup / management page
     */
    import { Routes } from '../../../api/apiSettings';

    import NavbarButtonBase from './navbar-button-base';

    export default {
        extends: NavbarButtonBase,

        props: [ 'exam' ],

        components: {},

        data: function () {
            return {
                screenReaderText: 'Click to display modal for selecting a different exam',
                icon: "fa fa-arrow-left",
                linkTitle: 'Change exams',
                linkClass: ' is-success is-outlined',
                identifyingClass: 'manage-exam-button ',
                buttonText: 'Manage exam',

                // label: 'Manage exam',
                defaults: {}
            }
        },

        computed: {
            route: function () {
                return window.routeRoot + '/' + Routes.setupExam( this.exam );
            }
        },

        methods: {
            handleClick: function () {
                //handle redirection
//                return this.$router.go( route );
                return window.open( this.route, "_self" );
            }
        },

    }
</script>