<template>

    <a class="button "
       v-bind:id="buttonId"
       title="Control whether the grading timer automatically starts"
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
                buttonId: 'autoStartTimerControl',

                preferenceName: 'autoStartTimer',
                updateMutationName: ngmTypes.updateGradingPreference,
                toggleMutationName: ngmTypes.toggleGradedStudentRowVisibility,
                toggleStateGetterName: nggTypes.areGradedStudentRowsVisible,

                styling: ' is-info is-outlined ',
                icons: {
                    off: 'fa pause-circle-o',
                    on: 'fa fa-tachometer'
                },

                text: {
                    off: "Automatically start timer",
                    on: "Manually start timer"
                },

                srText: {
                    on: 'Click to make the timer automatically start ',
                    off: 'Click to prevent the timer from automatically starting ',
                },

                defaults: {}
            }
        },

    }
</script>