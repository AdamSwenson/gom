<template>

</template>

<script>
    import buttonBase from '../../input/button-base';

    export default {
        name: "revoke-student-access-button",
        extends: buttonBase,


        data: function () {
            return {
                local: {
                    buttonText: '',
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
                window.console.log( 'revoke-student-access-button', pl );
                //send the request to remove access
                this.$store.dispatch( aTypes.revokeExamAccess, pl );

            }
        }

    }
</script>

<style scoped>

</style>