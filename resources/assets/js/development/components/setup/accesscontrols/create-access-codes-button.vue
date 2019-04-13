
<script>
    import buttonBase from '../../input/button-base';
    import Payload from '../../../../models/Payload';
    import * as aTypes from '../../../../store/action-types'

    export default {
        name: "create-access-codes-button",
        extends: buttonBase,

        props: [ 'exam' ],

        data: function () {
            return {
                isWorking: false,
                vars: {
                    buttonText: {
                        default: 'Create student access codes',
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
                    icon: "",
                    identifyingClass: '',
                    linkClass: '',
                    linkTitle: '',
                    screenReaderText: '',
                }
            }
        }
        ,

        methods: {
            handleClick: function () {
                let me = this;
                this.isWorking = true;
                let pl = Payload.factory( { obj: this.exam } );
                window.console.log( this.name, pl );
                //the request is to create access
                let p = this.$store.dispatch( aTypes.grantExamAccess, pl );
                p.then(function () {
                    me.isWorking = false;
                })
            }
        }

    }
</script>

<style scoped>

</style>