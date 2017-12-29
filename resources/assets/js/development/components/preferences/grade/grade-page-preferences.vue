<template>

    <div class="grade-preferences">
        <preferences-base
                :tabs="tabs"
                default-route="defaultRoute"
        >
            <div slot="prefsContent">
                <router-view name="prefsContentArea"></router-view>
            </div>
        </preferences-base>
    </div>
</template>

<style lang="scss">

</style>

<script>
    import PreferencesBase from "../preferences-base";
    import Routes from '../../../routes.preferences';

    export default {

        props: [],

        components: { PreferencesBase },

        data: function () {
            return {
                routeGroup: 'grade',
                defaultRoute: 'prefs-grade-input',
                defaults: {}
            }
        },

        computed: {
            tabs: function () {
                return _.filter( Routes, { group: this.routeGroup } );
            }
        },

        methods: {},

        directives: {},

        events: {},

        mounted: function () {
        }
    }
</script>