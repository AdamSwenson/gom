<template>
    <div id="student-action-buttons"
         v-bind:class="styling"
    >

        <div id="confirmationButtonsArea"
             class="field is-grouped is-fullwidth"
             v-if="showConfirmationButtons"
        >
            <p class="control">
                <button id="cancel-student-operation-button"
                        class="button is-primary"
                        v-on:click="handleCancellation"
                >Cancel
                </button>
            </p>

            <p class="control">
                <button id="confirm-student-operation-button"
                        class="button is-danger"
                        v-on:click="handleConfirmation"
                >Confirm
                </button>
            </p>
        </div>

        <div id="action-buttons-area"
             class="field is-grouped is-fullwidth"
             v-else
        >
            <p class="control">
                <a id="student-move-button"
                   class="button student-move-button is-outlined  is-primary"
                   v-on:click="handleAddClick"
                >{{ addButtonLabel }}</a>
            </p>

            <p class="control">
                <a id="student-remove-button"
                   class="button student-remove-button is-outlined is-warning"
                   v-on:click="handleRemoveClick"
                >Remove from group</a>
            </p>

            <p class="control">
                <a id="student-delete-button"
                   class="button student-delete-button is-outlined is-danger"
                   v-on:click="handleDeleteClick"
                >Delete</a>
            </p>


        </div>
        <auto-close-modal
                :content="messages.noRowsSelected"
                :show="isModalVisible"
                type="error"
        ></auto-close-modal>

        <confirmation-modal
                :is-visible="isConfirmationModalVisible"
                v-on:confirm-selected="handleConfirmation"
                v-on:cancel-selected="handleCancellation"
        >
            <p slot="modalBody">Are you super duper sure?</p>
        </confirmation-modal>

    </div>

</template>

<style lang="scss">

</style>

<script>
    /**
     * These controls consult the roster.display store for
     * the selected students and kumis, and then performs
     * the relevant action upon them
     */

    import autoCloseModal from '../../helpers/auto-closing-modal.vue';

    import confirmationModal from '../../helpers/confirmation-modal.vue';

    import Payload from '../../../../models/Payload';

    export default {


        props: [ 'injectableClasses' ],

        components: {
            'auto-close-modal': autoCloseModal,
            'confirmation-modal': confirmationModal
        },

        data: function () {
            return {
                defaults: {
                    componentClass: ''
                },
                pendingOperation: false, //what operation we are to perform

                messages: {
                    noRowsSelected: "Please select at least one row by clicking outside of the input areas."
                },

                selectorLabels: {
                    add: "Select groups for the selected students to join",
                    remove: "Select groups to remove the selected students from"
                },

                isModalVisible: false,

                /** Whether the confirmation dialog is displayed*/
                isConfirmationModalVisible: false
            }
        },

        computed: {
            addButtonLabel: function () {
                if ( this.kumiSelectorVisible ) return "Hide group list";
                return "Add to group"
            },

            styling: function () {
                return this.defaults.componentClass + this.injectableClasses;
            },

            selectedKumis: function () {
                return this.$store.getters.getSelectedKumis;
            },

            selectedStudents: function () {
                return this.$store.getters.getSelectedStudents;
            },

            /** Includes kumiSelectorVisible so that anything in the label
             * can change with the list state
             */
            kumiSelectorVisible: function () {
                return this.$store.getters.isKumiSelectVisible;
            },

            showConfirmationButtons: function () {
                //only show if something is selected
                //and the group list is visible
                return this.kumiSelectorVisible; // && this.selectedKumis.length > 0;
            },

        },

        methods: {

            testOperationValidity: function () {
                if ( this.selectedStudents === 0 ) {
                    this.isModalVisible = true;
                    return false;
                }
                return true;
            },

            /**
             * Toggle the display of the list of groups
             */
            handleAddClick: function () {
                this.$store.commit( 'toggleKumiSelectVisibility' );
                this.pendingOperation = 'add';
                this.$emit( 'toggle-kumi-list-visibility' );

                this.$emit( 'update-select-label', this.selectorLabels.add );
            },

            /**
             * Deletes all selected students
             */
            handleDeleteClick: function () {
                window.console.log( 'student-action-buttons', 'handleDeleteClick', 136, );
                this.pendingOperation = 'delete';

                //todo confirmation dialog
            },


            /**
             * Removes all selected student from the
             * currently displayed group
             *
             */
            handleRemoveClick: function () {
                window.console.log( 'student-action-buttons', 'handleRemoveClick', 172, );
                this.pendingOperation = 'remove';
                this.isConfirmationModalVisible = true;
            },


            /**
             * Called when confirm is clicked
             */
            handleConfirmation: function () {
                window.console.log( 'students-action-buttons', 'handleConfirmation', 340, this.selectedStudents );

                //close modal
                this.isConfirmationModalVisible = false;

                switch ( this.pendingOperation ) {
                    case 'add':
                        this.addStudentsToGroups();
                        break;
                    case 'remove':
                        this.removeStudentsFromGroups();
                        break;
                    case 'delete':
                        this.removeStudentsFromRoster();
                        break;

                }

                //if successful clear and
                //close up everything
                this.resetDisplay();
            },

            /**
             * Called when cancel is clicked
             */
            handleCancellation: function () {
                //close up everything
                this.resetDisplay();
            },


            /**
             * Adds all selected students to all selected groups
             */
            addStudentsToGroups: function () {
                window.console.log( 'student-action-buttons', 'addStudentToGroup', 151, );
                if ( this.testOperationValidity() ) {
                    let me = this;

                    _.forEach( me.selectedKumis, function ( kumi ) {
                        _.forEach( me.selectedStudents, function ( student ) {
                            me.$store.commit( 'associateStudentWithKumi', Payload.factory( {
                                student: student,
                                kumi: kumi
                            } ) );
                        } )
                    } )
                }
            },


            removeStudentsFromGroups: function () {
                //todo make sure this throws an error if no groups are displyed
                if ( this.testOperationValidity() ) {
                    //remove the selected students
                    let me = this;

                    //NB we use the displayed kumi's since it makes no sense
                    //to have to select them separately. We just work with
                    //what's on the screen
                    _.forEach( me.displayedKumis, function ( kumi ) {
                        _.forEach( me.selectedStudents, function ( student ) {
                            me.$store.commit( 'disassociateStudentFromKumi', Payload.factory( {
                                student: student,
                                kumi: kumi
                            } ) );
                        } )

                    } )

                }
            },


            removeStudentsFromRoster: function () {
                if ( this.testOperationValidity() ) {
                    //delete the selected students
                    let me = this;

                    _.forEach( this.selectedStudents, function ( student ) {
                        me.$store.commit( 'removeStudentFromRoster', Payload.factory( { obj: student } ) );
                    } );
                }
            },

            resetDisplay: function () {
                //hide the displayed kumi selector
                if(this.kumiSelectorVisible) this.$store.commit( 'toggleKumiSelectVisibility' );

                //clear previous selections
                this.$store.commit( 'clearSelectedStudents' );
                this.$store.commit( 'clearSelectedKumis' );

                //reset the pending operation
                this.pendingOperation = false;
            },


        }
    }
</script>