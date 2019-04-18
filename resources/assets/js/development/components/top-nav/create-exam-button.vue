<template>
    <a class="button create-exam-button "
       v-bind:class="styling"
       v-on:click="handleClick"
    >
        <span class="icon is-small">
            <i class="fa fa-plus" aria-hidden="true"></i>
        </span>
        <span>{{label}}</span>
    </a>
</template>

<style lang="scss">

</style>

<script>
    import { Routes } from '../../../api/apiSettings';

    export default {

        props: [ 'stylingOverride' ],

        components: {},

        data: function () {
            return {
                label : 'New',
                defaults: {}
            }
        },

        computed: {
            route: function () {
                return window.routeRoot + '/' + Routes.commonBaseRoute;
                },

            styling: function(){
                if(!_.isUndefined(this.stylingOverride) && !_.isNull(this.stylingOverride)){
                    return this.stylingOverride;
                }
                return ' is-primary is-outlined '
            }
        },

        methods: {
            handleClick: function () {
                    //handle redirection
//                return this.$router.go( route );
                    return window.open( this.route, "_self" );
            }
        },

        directives: {},

        events: {},

        mounted: function () {
        }
    }
</script>