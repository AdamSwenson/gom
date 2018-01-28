
<script>

    import ActionButtonBase from './action-button-base';
    import mixin from './action-buttons.mixin';

    export default {
        extends: ActionButtonBase,
        mixins: [mixin],

        data: function () {
            return {
                actionName: 'removeStudentsFromRoster',

                button: {
                    class: ' is-outlined is-danger ',
                    label: 'Remove from group',
                    id: 'remove-students-from-group-button'
                },

                errorModalText: "Please select 1 or more students ",

                confirmationModalText: "Are you sure you want to remove the student from this group? This will not remove them from the exam",

                operation: 'delete',

                requiresConfirmation : true,

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
                if ( this.selectedStudents.length === 0 || this.selectedKumis.length === 0) return false;
                return true;
            },
        }

    }
</script>