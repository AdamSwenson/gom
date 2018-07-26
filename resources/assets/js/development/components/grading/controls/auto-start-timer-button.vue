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
                buttonId: 'autoStartTimerControl',

                preferenceName: 'shouldTimerAutomaticallyStart',
                updateMutationName: ngmTypes.updateGradingPreference,
                toggleStateGetterName: nggTypes.shouldTimerAutomaticallyStart,

                styling: 'auto-start-timer-button is-primary is-outlined ',
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