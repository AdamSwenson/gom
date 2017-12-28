<template>

    <div class="user-preferences">
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
                defaultRoute: 'account',
                tabs: [
                    { route: '/preferences/user/account', text: 'Manage account' },
                    { route: '/preferences/user/connections', text: 'Manage connections' },
                    { text: 'Pay yo bills', route: '/preferences/user/bills' }
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