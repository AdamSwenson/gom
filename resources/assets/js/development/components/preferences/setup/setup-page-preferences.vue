<template>

    <div class="setup-page-preferences">
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
    import preferencesPageMixin from '../preferencesPage.mixin';

    export default {
        mixins : [preferencesPageMixin],
        props: [],

        components: { PreferencesBase },

        data: function () {
            return {
                routeGroup: 'setup',
                loadAction : ngaTypes.loadSetupPreferencesFromServer,
                // defaultRoute: 'prefs-labels',
                defaults: {}
            }
        },

    }
</script>