<template>

    <div class="user-preferences">
        <preferences-base
                :tabs="tabs"
                default-route="defaultRoute"
        ></preferences-base>
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
                defaultRoute: 'account',
                tabs: [
                    { route: 'account', text: 'Manage account' },
                    { route: 'connections', text: 'Manage connections' },
                    { text: 'Pay yo bills', route: 'bills' }
                ],
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