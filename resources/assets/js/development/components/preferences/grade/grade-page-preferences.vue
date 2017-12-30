<template>

    <div class="grade-preferences">
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
    import * as ngaTypes from '../../../../store/modules/newgrading/new-grading-action-types';
    import preferencesPageMixin from '../preferencesPage.mixin';

    export default {
        mixins : [preferencesPageMixin],
        props: [],

        components: { PreferencesBase },

        data: function () {
            return {
                routeGroup: 'grade',
                loadAction : ngaTypes.loadGradePreferencesFromServer,
                defaults: {}
            }
        },

    }
</script>