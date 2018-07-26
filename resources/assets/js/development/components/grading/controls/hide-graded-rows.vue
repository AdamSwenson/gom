
<script>

    import * as ngmTypes from '../../../../store/new-grading-mutation-types';
    import * as ngaTypes from '../../../../store/new-grading-action-types';
    import * as nggTypes from '../../../../store/new-grading-getter-types';

    import gradingControlMixin from './gradingControl.mixin';
    import toggleButtonBase from '../../input/toggle-button-base';

    export default {
        extends: toggleButtonBase,

        mixins: [ gradingControlMixin ],

        data: function () {
            return {
                buttonId: 'gradedRowVisibilityControl',

                preferenceName : 'areGradedStudentRowsVisible',
                updateMutationName : ngmTypes.updateGradingPreference,
                toggleMutationName: ngmTypes.toggleGradedStudentRowVisibility,
                toggleStateGetterName: nggTypes.areGradedStudentRowsVisible,

                styling: 'hide-graded-rows is-primary is-outlined ',

                icons: {
                    off: 'fa fa-eye',
                    on: 'fa fa-eye-slash'
                },

                text: {
                    off: "Show graded rows",
                    on: "Hide graded rows"
                },

                srText: {
                    on: 'Click to view all students ',
                    off: 'Click to hide rows of students who have been graded  '
                },

                title : "Click to hide or show rows for students whose exams have been graded",

                defaults: {}
            }
        },

    }
</script>