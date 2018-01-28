<template>
    <div class="box account-area">

        <h4 class="title is-4">Manage permissions</h4>

        <p>
            Add TA's and other graders
        </p>
        <p>
            Add non-grading observers
        </p>

    </div>
</template>

<style lang="scss">

</style>

<script>
    import PreferenceInput from "../preference-input";
    import Payload from '../../../../models/Payload';

    import * as nggTypes from '../../../../store/new-grading-getter-types';
    import * as ngmTypes from '../../../../store/new-grading-mutation-types';

    import inputMixin from '../preferencesInput.mixin';
    export default {
        mixins: [inputMixin],

        props: [],

        components: {
            preferences: function () {
                return this.$store.getters.getUserPreferences;
            },

            userNameShownToStudents: function () {

            },

            userEmailSignature: function () {

            }
        },

        data: function () {
            return {
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