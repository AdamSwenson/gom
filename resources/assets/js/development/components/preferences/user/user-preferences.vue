<template>

    <div class="user-preferences">
        <preferences-base
                :tabs="routes"
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
    import * as ngaTypes from '../../../../store/new-grading-action-types';
    import * as nggTypes from '../../../../store/new-grading-getter-types';
    import * as ngmTypes from '../../../../store/new-grading-mutation-types';

    import preferencesPageMixin from '../preferencesPage.mixin';

    export default {
        mixins: [ preferencesPageMixin ],
        props: [],

        components: { PreferencesBase },

        data: function () {
            return {
                routeGroup: 'user',
                loadAction: ngaTypes.loadUserPreferencesFromServer
                // defaultRoute: 'prefs-account',
            }
        },

    }
</script>