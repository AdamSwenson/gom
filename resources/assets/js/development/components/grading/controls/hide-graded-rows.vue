<template>

    <a class="button "
       v-bind:id="buttonId"
       title="Click to hide or show rows for students whose exams have been graded"
       v-bind:class="styling"
       v-on:click="toggle"
    >
        <span class="sr-only">{{ srText.button }}</span>

        <span class="icon is-small">
              <i v-bind:class="icon" aria-hidden="true"></i>
        </span> <span class="button-text"> {{ buttonText }}</span>
    </a>

</template>

<style lang="scss">

</style>

<script>


    import * as ngmTypes from '../../../../store/modules/newgrading/new-grading-mutation-types';
    import * as ngaTypes from '../../../../store/modules/newgrading/new-grading-action-types';
    import * as nggTypes from '../../../../store/modules/newgrading/new-grading-getter-types';

    import gradingControlMixin from './gradingControl.mixin';

    export default {
        mixins: [ gradingControlMixin ],

        props: [],

        components: {},

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

                // on: 'fa fa-user',
                //     off: 'fa fa-user-secret'
                },

                text: {
                    off: "Show graded rows",
                    on: "Hide graded rows"
                },

                srText: {
                    button: 'Click to hide student names and grade blind',
                },
                defaults: {}
            }
        },

    }
</script>