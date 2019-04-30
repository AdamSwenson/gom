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
                // icons: {
                //     off: '',
                //     on: 'fa fa-list-alt"'
                // },

                text: {
                    on: "Update default comments on graded exams",
                    off: "Update default comments on graded exams",
                },
                srText: {
                    on: 'Overwrite default comments on graded exams with the new text',
                    off: ''
                },

                title: "",

                //
                // vars: {
                //     buttonText: {
                //         default: 'Update default comments on graded exams',
                //         working: '------'
                //     },
                //     icon: {
                //         default: "fa fa-list-alt",
                //         working: "fa fa-hourglass",
                //     }
                // },
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
        //     local: function () {
        //         let cls = this.isRunning ? 'is-warning ' : 'is-primary is-outlined';
        //         let icn = this.isRunning ? this.vars.icon.working : this.vars.icon.default;
        //
        //         if ( this.showError ) cls = 'is-danger';
        //
        //         return {
        //             buttonText:
        //                 this.isWorking ? this.vars.buttonText.working : this.vars.buttonText.default,
        //             icon: icn,
        //             identifyingClass: '',
        //             linkClass: cls,
        //             linkTitle: '',
        //             screenReaderText: 'Overwrite default comments on graded exams with the new text',
        //         }
        //     }
        // },

        methods: {
            toggle: function () {
                this.$emit( 'toggled' );
            }
            //     let me = this;
            //     this.isWorking = true;
            //     // let pl = Payload.factory( { obj: this.exam } );
            //     window.console.log( this.name , 'j');
            //     //the request is to create access
            //     // let p = this.$store.dispatch( aTypes.grantExamAccess, pl );
            //     // updateComment( this.item, true, this.exam ).then( function () {
            //     //     me.isWorking = false;
            //     // } )
            // }
        }

    }
</script>