<template>

    <a class="hide-graded-rows button "
       v-bind:id="buttonId"
       v-bind:title="title"
       v-bind:class="styling"
       v-on:click="toggle"
    >
        <span class="sr-only">{{ srTextDisplay }}</span>

        <span class="icon is-small">
              <i v-bind:class="icon" aria-hidden="true"></i>
        </span> <span class="button-text"> {{ buttonText }}</span>
    </a>

</template>

<style lang="scss">

</style>

<script>

    import * as ngmTypes from '../../../../store/new-grading-mutation-types';
    import * as ngaTypes from '../../../../store/new-grading-action-types';
    import * as nggTypes from '../../../../store/new-grading-getter-types';

    import gradingControlMixin from './gradingControl.mixin';

    export default {
        mixins: [ gradingControlMixin ],


        data: function () {
            return {
                buttonId: 'gradedRowVisibilityControl',

                preferenceName : 'areGradedStudentRowsVisible',
                updateMutationName : ngmTypes.updateGradingPreference,
                toggleMutationName: ngmTypes.toggleGradedStudentRowVisibility,
                toggleStateGetterName: nggTypes.areGradedStudentRowsVisible,

                styling: ' is-primary is-outlined ',

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