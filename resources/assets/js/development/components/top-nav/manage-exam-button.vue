<template>
    <p class="manage-exam-button field">
        <a class="button  is-success is-outlined"
           v-on:click="handleClick"
        >
        <span class="icon is-small">
            <i class="fa fa-arrow-left" aria-hidden="true"></i>
        </span>
            <span>{{ label }}</span>
        </a>
    </p>
</template>

<style lang="scss">

</style>

<script>
    /**
     * This is the button which takes the user
     * back to the setup / management page
     */
    import { Routes } from '../../../api/apiSettings';

    export default {

        props: [ 'exam' ],

        components: {},

        data: function () {
            return {
                label: 'Manage exam',
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