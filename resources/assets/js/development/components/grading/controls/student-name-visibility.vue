<template>

    <a class="student-name-visibility button "
       v-bind:id="buttonId"
       v-bind:title="title"
       v-bind:class="styling"
       v-on:click="toggle"
    >
        <span class="sr-only">{{ srTextDisplay }}</span>

        <span class="icon is-small">
              <i v-bind:class="icon" aria-hidden="true"></i>
        </span> <span class="button-text"> {{ buttonText }} </span>

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
                buttonId : "nameVisibilityControl",
                preferenceName : 'areStudentNamesVisible',
                updateMutationName : ngmTypes.updateGradingPreference,
                // toggleMutationName: ngmTypes.toggleStudentNameVisibility,
                toggleStateGetterName: nggTypes.areStudentNamesVisible,

                styling: ' is-primary is-outlined',
                icons: {
                    off: 'fa fa-user',
                    on: 'fa fa-user-secret'
                },

                text: {
                    on: "Hide names",
                    off: "Show names",
                },
                srText: {
                    on: 'Click to hide student names and grade blind',
                    off: 'Click to view student names while grading '
                },

                title : "Click to hide or show student names",

                defaults: {}
            }
        },

    }
</script>