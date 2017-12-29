<template>
    <div class="grade-input">
        <h4 class="title is-4">Grading input preferences</h4>
        <br>

        <div class="box">
            <preference-toggle
                    :selected="areStudentNamesVisible"
                    v-on:toggled="handleToggle('areStudentNamesVisible')"
            >
                <span slot="labelText">Display student names while grading </span>
            </preference-toggle>


            <preference-toggle
                    :selected="isLetterGradeButtonUsed"
                    v-on:toggled="handleToggle('isLetterGradeButtonUsed')">
                <span slot="labelText">Assign scores via letter grade button </span>
            </preference-toggle>

            <preference-toggle
                    :selected="shouldDynamicallyCollapseCommentAreas"
                    v-on:toggled="handleToggle('shouldDynamicallyCollapseCommentAreas')">
                <span slot="labelText">Collapse comment areas when not being edited</span>
            </preference-toggle>

            <preference-toggle
                    :selected="isSliderUsed"
                    v-on:toggled="handleToggle('isSliderUsed')">
                <span slot="labelText">Record scores using sliders </span>
            </preference-toggle>

            <preference-toggle
                    :selected="isScoreDisplayed"
                    v-on:toggled="handleToggle('isScoreDisplayed')">
                <span slot="labelText">View numeric scores while grading </span>
            </preference-toggle>
        </div>
    </div>
</template>

<style lang="scss">

</style>

<script>
    import PreferenceToggle from "../preference-toggle";
    import Payload from '../../../../models/Payload';

    import * as nggTypes from '../../../../store/modules/newgrading/new-grading-getter-types';

    export default {

        props: [],

        components: {
            PreferenceToggle,
        },

        data: function () {
            return {
                defaults: {}
            }
        },

        computed: {
            areStudentNamesVisible: function () {
                return this.$store.getters[ nggTypes.areStudentNamesVisible ];
            },

            isLetterGradeButtonUsed: function () {
                return this.$store.getters[ nggTypes.isLetterGradeButtonUsed ];
            },

            shouldDynamicallyCollapseCommentAreas: function () {
                return this.$store.getters[ nggTypes.shouldDynamicallyCollapseCommentAreas ];
            },

            isSliderUsed: function () {
                return this.$store.getters[ nggTypes.isSliderUsed ];
            },

            isScoreDisplayed: function () {
                return this.$store.getters[ nggTypes.isScoreDisplayed ];
            }

        },

        methods: {
            handleToggle: function ( fieldName ) {
                let newVal = !this[ fieldName ];
                let pl = Payload.factory( { updateProp: fieldName, updateVal: newVal } );
                this.$store.commit( 'updateGradingPreference', pl );
            }
        },

        directives: {},

        events: {},

        mounted: function () {
        }
    }
</script>