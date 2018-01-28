<script>
    import ActionButtonBase from './action-button-base';
    import mixin from './action-buttons.mixin';

    export default {
        extends: ActionButtonBase,

        mixins: [ mixin ],

        data: function () {
            return {
                actionName: 'addStudentsToKumis',

                button: {
                    class: ' student-move-button is-outlined  is-primary',
                    label: 'Add to group',
                    id: 'student-move-button'
                },

                errorModalText: "Please select 1 or more students ",

                confirmationModalText: " ",

                requiresConfirmation: false,

                requiresKumiSelector: true,

            }
        },

        computed: {
            payload: function () {
                return {
                    students: this.selectedStudents,
                    kumis: this.selectedKumis
                };
            },

            /**
             * Whether or not the conditions for using this
             * button are correct
             * @param testKumis
             */
            isOperationValid: function () {
                if ( this.selectedStudents.length === 0 || this.selectedKumis.length === 0 ) return false;
                return true;
            },
        }

    }
</script>