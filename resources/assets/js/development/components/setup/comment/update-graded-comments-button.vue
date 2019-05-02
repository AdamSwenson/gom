<script>
    import buttonBase from '../../input/button-base';

    const { updateComment } = require( "../../../../api/requests/commentRequests" );

    export default {
        name: "update-graded-comments-button",
        extends: buttonBase,

        props: [ 'item', 'exam' ],

        data: function () {
            return {
                isWorking: false,
                vars: {
                    buttonText: {
                        default: 'Update comments',
                        working: '------'
                    },
                    icon: {
                        default: "",
                        working: "",
                    }
                },
            }
        },

        computed: {
            local: function () {
                return {
                    buttonText:
                        this.isWorking ? this.vars.buttonText.working : this.vars.buttonText.default,
                    helpText: "help",
                    icon: 'fa fa-list-alt',
                    identifyingClass: this.name,
                    linkClass: 'is-warning is-outlined',
                    linkTitle: '',
                    labelText: "Update comments on graded exams",
                    screenReaderText: 'Overwrite default comments on graded exams with the new text',
                }
            }
        },

        methods: {


            handleClick: function () {
                let me = this;
                me.isWorking = true;
                updateComment( this.item, true, this.exam.id ).then( function () {
                    me.isWorking = false;
                } );
            }
        }

    }
</script>

<style scoped>

</style>
