<script>
    import ActionButtonBase from './action-button-base';
    import mixin from './action-buttons.mixin';

    export default {
        extends: ActionButtonBase,

        mixins: [ mixin ],

        data: function () {
            return {
                actionName: 'removeStudentsFromRoster',

                button: {
                    class: ' is-outlined is-danger ',
                    label: 'Remove',
                    id: 'remove-students-from-roster-button'
                },

                errorModalText: "Please select 1 or more students ",

                confirmationModalText: "This will delete the selected students entirely. All data related to the students will be lost permanently. Are you absolutely sure that's what you want to do? ",

                operation: 'delete',

                requiresConfirmation: true,
            }
        },

        computed: {
            payload: function () {
                //we only need the array, not a payload object
                return this.selectedStudents;
            },

            /**
             * Whether or not the conditions for using this
             * button are correct
             * @param testKumis
             */
            isOperationValid: function () {
                if ( this.selectedStudents.length === 0 ) return false;
                return true;
            },
        }

    }
</script>