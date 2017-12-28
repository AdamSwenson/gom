<template>

    <div class="setup-preferences">
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
    import PreferencesBase from "./preferences-base";

    export default {

        props: [],

        components: { PreferencesBase },

        data: function () {
            return {
                defaultRoute: '/preferences/setup/labels',
                tabs: [
                    { route: '/preferences/setup/labels', text: 'What things are called' },
                    { route: '/preferences/setup/structure', text: 'Assignment structure options' },
                  ],
                defaults: {}
            }
        },

        computed: {},

        methods: {},

        directives: {},

        events: {},

        mounted: function () {
        }
    }
</script>