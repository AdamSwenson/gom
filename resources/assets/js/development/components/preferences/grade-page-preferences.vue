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
    import PreferencesBase from "./preferences-base";

    export default {

        props: [],

        components: { PreferencesBase },

        data: function () {
            return {
                defaultRoute:  '/preferences/grade/input',
                tabs: [
                    { route: '/preferences/grade/input', text: 'Inputs' },
                    { route: '/preferences/grade/dash', text: 'Dash' },
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