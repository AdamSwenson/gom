<template>
    <a class="button grade-exam-button is-success is-outlined"
       v-on:click="handleClick"
    >
        <span class="icon is-small">
            <i class="fa fa-check" aria-hidden="true"></i>
        </span>
        <span>{{ label }}</span>
    </a>
</template>

<style lang="scss">

</style>

<script>
    import { Routes } from '../../../api/apiSettings';

    export default {

        props: [ 'exam' ],

        components: {},

        data: function () {
            return {
                label : 'Grade',
                defaults: {}
            }
        },

        computed: {
            route: function () {
                return window.routeRoot + '/' + Routes.gradeExam( this.exam.id );
            }
        },

        methods: {
            handleClick: function () {
                //handle redirection
//                return this.$router.go( route );
                return window.open( this.route, "_self" );

                this.$emit( 'grade-currently-selected-exam' );

            }
        },

        directives: {},

        events: {},

        mounted: function () {
        }
    }
</script>