<script>
    import * as ngmTypes from '../../../../store/new-grading-mutation-types';
    import * as ngaTypes from '../../../../store/new-grading-action-types';
    import * as nggTypes from '../../../../store/new-grading-getter-types';

    import toggleButtonBase from '../../input/toggle-button-base';
    import toggleButtonMixin from '../../input/toggleButtonMixin';

    export default {
        extends: toggleButtonBase,

        props: ['exam'],

        mixins: [ toggleButtonMixin ],

        data: function () {
            return {
                buttonId: 'exam-release-button',


                styles: {
                    public: 'is-warning',
                    private: 'is-primary'
                },

                icons: {
                    on: 'fa fa-eye',
                    off: 'fa fa-eye-slash'
                },

                styling: 'exam-release-button is-primary is-outlined ',

                text: {
                    off: "Release to students",
                    on: "Remove student access"
                },

                srText: {
                    on: 'Click to release the exam feedback and grades to students',
                    off: 'Click to revoke the release of feedback and grades to students',
                },

                title: 'Control whether students may view feedback and grades',

                defaults: {}
            }
        },

        computed: {
            isActive: function () {
                if(!_.isUndefined(this.exam)) return this.exam.released;

                return true;
            }
        },

        methods: {
            toggle: function () {
                this.$store.commit( 'toggleConfirmationModal' );
            }
        }

    }
</script>