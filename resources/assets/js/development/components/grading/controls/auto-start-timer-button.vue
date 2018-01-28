<template>

    <a class="button "
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
                buttonId: 'autoStartTimerControl',

                preferenceName: 'shouldTimerAutomaticallyStart',
                updateMutationName: ngmTypes.updateGradingPreference,
                toggleStateGetterName: nggTypes.shouldTimerAutomaticallyStart,

                styling: ' is-primary is-outlined ',
                icons: {
                    off: 'fa fa-pause-circle-o',
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

                title: 'Control whether the grading timer automatically starts',

                defaults: {}
            }
        },

    }
</script>