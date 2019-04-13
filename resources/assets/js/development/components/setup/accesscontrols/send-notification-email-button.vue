<script>
    import buttonBase from '../../input/button-base';
    import Payload from '../../../../models/Payload';
    import * as aTypes from '../../../../store/action-types'

    export default {
        name: "send-notification-email-button",

        extends: buttonBase,

        data: function () {
            return {
                local: {
                    buttonText: 'Email access codes to students',
                    icon: "",
                    identifyingClass: '',
                    linkClass: '',
                    linkTitle: '',
                    screenReaderText: '',
                }
            }
        },

        methods: {
            handleClick: function () {
                let pl = Payload.factory( { obj: this.exam } );
                window.console.log( this.name, pl );

            }
        }

    }

</script>

<style scoped>

</style>