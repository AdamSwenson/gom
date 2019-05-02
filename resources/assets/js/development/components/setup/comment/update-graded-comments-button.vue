<script>
    import buttonBase from '../../input/toggle-button-base';
    // import toggleMixin from '../../input/toggleButtonMixin';

    export default {
        name: "update-graded-comments-button",
        extends: buttonBase,

        props: [ 'isActive' ],

        data: function () {
            return {
                buttonId: "",
                styling: {
                    off: 'is-primary is-outlined',
                    on: 'is-primary'
                },

                icon: 'fa fa-list-alt',

                text: {
                    on: "Update default comments on graded exams",
                    off: "Update default comments on graded exams",
                },
                srText: {
                    on: 'Overwrite default comments on graded exams with the new text',
                    off: ''
                },

                title: "",
            }
        },

        computed: {
            buttonText: function () {
                return this.text.on;
            },
            srTextDisplay: function () {
                return this.srText.on;
            },
            computedStyling: function () {
                return this.isActive ? this.styling.on : this.styling.off;
            }
        },


        methods: {
            toggle: function () {
                this.$emit( 'toggled' );
            }
         }

    }
</script>