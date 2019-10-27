<template>
    <div class="grade-input">
        <h4 class="title is-4">Grading input preferences</h4>
        <br>

        <div class="box">
            <preference-toggle
                    :available="nameVisibility.available"
                    :selected="areStudentNamesVisible"
                    v-on:toggled="handleToggle('areStudentNamesVisible')"
            >
                <span slot="labelText"> {{ nameVisibility.label }} </span>
                <span slot="helpText">{{ nameVisibility.help }} </span>
            </preference-toggle>


            <preference-toggle
                    :available="letterGradeButton.available"
                    :selected="isLetterGradeButtonUsed"
                    v-on:toggled="handleToggle('isLetterGradeButtonUsed')"
            >
                <span slot="labelText">{{ letterGradeButton.label }}</span>
                <span slot="helpText">{{ letterGradeButton.help }}</span>
            </preference-toggle>

            <preference-toggle
                    :available="collapseCommentArea.available"
                    :selected="shouldDynamicallyCollapseCommentAreas"
                    v-on:toggled="handleToggle('shouldDynamicallyCollapseCommentAreas')"
            >
                <span slot="labelText">{{ collapseCommentArea.label }}</span>
                <span slot="helpText">{{ collapseCommentArea.help }}</span>

            </preference-toggle>

            <preference-toggle
                    :available="gradeSliders.available"
                    :selected="isSliderUsed"
                    v-on:toggled="handleToggle('isSliderUsed')"
            >
                <span slot="labelText">{{ gradeSliders.label}}</span>
                <span slot="helpText">{{ gradeSliders.help }}</span>

            </preference-toggle>

            <preference-toggle
                    :available="showScores.available"
                    :selected="isScoreDisplayed"
                    v-on:toggled="handleToggle('isScoreDisplayed')"
            >
                <span slot="labelText">{{ showScore.label}}</span>
                <span slot="helpText">{{ showScore.help }}</span>

            </preference-toggle>

        </div>
    </div>
</template>

<style lang="scss">

</style>

<script>
    import PreferenceToggle from "../preference-toggle";
    import Payload from '../../../../models/Payload';

    import * as nggTypes from '../../../../store/new-grading-getter-types';
    import * as ngmTypes from '../../../../store/new-grading-mutation-types';

    import inputMixin from '../preferencesInput.mixin';
    export default {
        mixins: [inputMixin],

        props: [],

        components: {
            PreferenceToggle,
        },

        data: function () {
            return {
                updateMutationName : ngmTypes.updateGradingPreference,

                nameVisibility: {
                    available: true,
                    label: "Display student names while grading ",
                    help: "Selecting this option obscures student names on the grading page. Grading without knowing the identities of the student is often helpful for ensuring fairness and accuracy. Of course, this requires students to write their id number or some other unique identifier on the exam.  "
                },

                letterGradeButton: {
                    available : false,
                    label: "Assign scores via letter grade button ",
                    help: "Grade each constituent item on the exam by assigning it a letter grade. The letter grade will be translated into a score for the item based on a fixed percentage of the item's maximum score. The overall grade for the assignment will be calculated from these item scores."
                },

                collapseCommentArea: {
                    available : false,
                    label: "Collapse comment areas when not being edited",
                    help: ""
                },

                gradeSliders: {
                    available : false,
                    label: "Record scores using sliders ",
                    help: ""
                },

                showScore: {
                    available : false,
                    label: "View numeric scores while grading",
                    help: "Sometimes, trying to assign a precise scores overly complicates the grading process. Selecting this option hides the numerical value of the score assigned. Used in conjunction with the slider, allows you to grade with something like a visual analog scale. "
                },

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
            // handleToggle: function ( fieldName ) {
            //     let newVal = !this[ fieldName ];
            //     let pl = Payload.factory( { updateProp: fieldName, updateVal: newVal } );
            //     this.$store.commit( 'updateGradingPreference', pl );
            // }
        },

        directives: {},

        events: {},

        mounted: function () {
        }
    }
</script>