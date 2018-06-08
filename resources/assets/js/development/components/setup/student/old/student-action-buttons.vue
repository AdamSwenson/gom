<!--<template>-->
    <!--<div id="student-action-buttons"-->
         <!--v-bind:class="styling"-->
    <!--&gt;-->

        <!--<div id="confirmationButtonsArea"-->
             <!--class="field is-grouped is-fullwidth"-->
             <!--v-if="showConfirmationButtons"-->
        <!--&gt;-->
            <!--<p class="control">-->
                <!--<button id="cancel-student-operation-button"-->
                        <!--class="button is-primary"-->
                        <!--v-on:click="handleCancellation"-->
                <!--&gt;Cancel</button>-->
            <!--</p>-->

            <!--<p class="control">-->
                <!--<button id="confirm-student-operation-button"-->
                        <!--class="button is-danger"-->
                        <!--v-on:click="handleConfirmation"-->
                <!--&gt;Confirm</button>-->
            <!--</p>-->
        <!--</div>-->

        <!--<div id="action-buttons-area"-->
             <!--class="field is-grouped is-fullwidth"-->
             <!--v-else-->
        <!--&gt;-->
            <!--<p class="control">-->
                <!--<a id="student-move-button"-->
                   <!--class="button student-move-button is-outlined  is-primary"-->
                   <!--v-on:click="handleAddClick"-->
                <!--&gt;{{ addButtonLabel }}</a>-->
            <!--</p>-->

            <!--<p class="control">-->
                <!--<a id="student-remove-button"-->
                   <!--class="button student-remove-button is-outlined is-warning"-->
                   <!--v-on:click="handleRemoveClick"-->
                <!--&gt;Remove from group</a>-->
            <!--</p>-->

            <!--<p class="control">-->
                <!--<a id="student-delete-button"-->
                   <!--class="button student-delete-button is-outlined is-danger"-->
                   <!--v-on:click="handleDeleteClick"-->
                <!--&gt;Remove from roster</a>-->
            <!--</p>-->

            <!--<remove-students-from-roster-button-->
                    <!--v-on:done="resetDisplay"-->
            <!--&gt;</remove-students-from-roster-button>-->

        <!--</div>-->

        <!--<auto-close-modal-->
                <!--:content="messages.noRowsSelected"-->
                <!--:show="isErrorModalVisible"-->
                <!--type="error"-->
        <!--&gt;-->
            <!--<p slot="modalBody">{{errorModalText }}</p>-->

        <!--</auto-close-modal>-->

        <!--<confirmation-modal-->
                <!--:is-visible="isConfirmationModalVisible"-->
                <!--v-on:confirm-selected="handleConfirmation"-->
                <!--v-on:cancel-selected="handleCancellation"-->
        <!--&gt;-->
            <!--<p slot="modalBody">{{ confirmationModalText }}</p>-->
        <!--</confirmation-modal>-->

    <!--</div>-->

<!--</template>-->

<!--<style lang="scss">-->

<!--</style>-->

<!--<script>-->
    <!--/**-->
     <!--* These controls consult the roster.display store for-->
     <!--* the selected students and kumis, and then performs-->
     <!--* the relevant action upon them-->
     <!--*/-->

    <!--import autoCloseModal from '../../../modals/auto-closing-modal.vue';-->
    <!--import confirmationModal from '../../../modals/confirmation-modal.vue';-->

    <!--import Payload from '../../../../../models/Payload';-->
    <!--import Student from '../../../../../models/Student';-->
    <!--import Kumi from '../../../../../models/Kumi';-->
    <!--import * as mTypes from '../../../../../store/mutation-types';-->
    <!--import * as aTypes from '../../../../../store/action-types';-->
    <!--import * as gTypes from '../../../../../store/getter-types';-->
    <!--import RemoveStudentsFromRosterButton from "../action-buttons/remove-students-from-roster-button";-->

    <!--export default {-->


        <!--props: [ 'injectableClasses' ],-->

        <!--components: {-->
            <!--RemoveStudentsFromRosterButton,-->
            <!--'auto-close-modal': autoCloseModal,-->
            <!--'confirmation-modal': confirmationModal-->
        <!--},-->

        <!--data: function () {-->
            <!--return {-->
                <!--defaults: {-->
                    <!--componentClass: ''-->
                <!--},-->

                <!--/** The text displayed in the body of the error modal **/-->
                <!--errorModalText: '',-->

                <!--/** Values to use as errorModalText */-->
                <!--errorModalTextOptions: {-->
                    <!--noSelectedStudents: "Please select 1 or more students ",-->
                    <!--noSelectedGroups: "Please select 1 or more groups"-->
                <!--},-->


                <!--//what operation we are to perform-->
                <!--pendingOperation: false,-->

                <!--messages: {-->
                    <!--noRowsSelected: "Please select at least one row by clicking outside of the input areas."-->
                <!--},-->

                <!--modalBodyText: {-->
                    <!--remove: "Are you sure you want to remove the student from this group? The student will no longer appear on the exam if they are not part of another group. However, the student's data will not be affected -&#45;&#45;you could add the student back",-->
                    <!--delete: "This will delete the student entirely. All data related to the student will be lost permanently. Are you absolutely sure that's what you want to do? "-->
                <!--},-->

                <!--selectorLabels: {-->
                    <!--add: "Select groups for the selected students to join",-->
                    <!--remove: "Select groups to remove the selected students from"-->
                <!--},-->

                <!--isErrorModalVisible: false,-->

                <!--/** Whether the confirmation dialog is displayed*/-->
                <!--isConfirmationModalVisible: false-->
            <!--}-->
        <!--},-->

        <!--computed: {-->
            <!--addButtonLabel: function () {-->
                <!--if ( this.kumiSelectorVisible ) return "Hide group list";-->
                <!--return "Add to group"-->
            <!--},-->

            <!--/**-->
             <!--* When the action button is clicked, the-->
             <!--* confirmation modal displays with this text-->
             <!--* in the body.-->
             <!--*/-->
            <!--confirmationModalText: function () {-->
                <!--switch ( this.pendingOperation ) {-->
                    <!--case 'add':-->
                        <!--return '';-->
                        <!--break;-->
                    <!--case 'remove':-->
                        <!--return this.modalBodyText.remove;-->
                        <!--break;-->
                    <!--case 'delete':-->
                        <!--return this.modalBodyText.delete;-->
                        <!--break;-->
                    <!--default :-->
                        <!--return "Are you sure you want to do this?"-->
                <!--}-->
            <!--},-->
            <!--/** Includes kumiSelectorVisible so that anything in the label-->
             <!--* can change with the list state-->
             <!--*/-->
            <!--kumiSelectorVisible: function () {-->
                <!--return this.$store.getters.isKumiSelectVisible;-->
            <!--},-->

            <!--/**-->
             <!--* The object which all operations will dispatch-->
             <!--* with the actions-->
             <!--*/-->
            <!--payload: function () {-->
                <!--return {-->
                    <!--students: this.selectedStudents,-->
                    <!--kumis: this.selectedKumis-->
                <!--};-->
            <!--},-->

            <!--styling: function () {-->
                <!--return this.defaults.componentClass + this.injectableClasses;-->
            <!--},-->

            <!--/**-->
             <!--* Array of currently selected groups. When-->
             <!--* an operation button is clicked, these will be part of the-->
             <!--* payload.-->
             <!--*/-->
            <!--selectedKumis: function () {-->
                <!--return this.$store.getters.getSelectedKumis;-->
            <!--},-->

            <!--/**-->
             <!--* Array of currently selected students. When-->
             <!--* an operation button is clicked, these will be part of the-->
             <!--* payload.-->
             <!--*/-->
            <!--selectedStudents: function () {-->
                <!--return this.$store.getters.getSelectedStudents;-->
            <!--},-->

            <!--showConfirmationButtons: function () {-->
                <!--//only show if something is selected-->
                <!--//and the group list is visible-->
                <!--return this.kumiSelectorVisible; // && this.selectedKumis.length > 0;-->
            <!--},-->

        <!--},-->

        <!--methods: {-->

            <!--/**-->
             <!--* Determines whether the operation may be performed.-->
             <!--* If not, it displays the warning modal-->
             <!--* By default it only checks whether students are selected-->
             <!--* If testKumis is true, it checks kumis too-->
             <!--*/-->
            <!--isOperationValid: function ( testKumis = false ) {-->
                <!--if ( this.selectedStudents.length === 0 ) {-->
                    <!--//Set which error message displays-->
                    <!--this.errorModalText = this.errorModalTextOptions.noSelectedStudents;-->
                    <!--//Display the warning message-->
                    <!--this.isErrorModalVisible = true;-->
                    <!--return false;-->
                <!--}-->

                <!--if ( testKumis && this.selectedKumis.length === 0 ) {-->
                    <!--//Set which error message displays-->
                    <!--this.errorModalText = this.errorModalTextOptions.noSelectedGroups;-->
                    <!--//Display the warning message-->
                    <!--this.isErrorModalVisible = true;-->
                    <!--//Return the result of the test-->
                    <!--return false;-->
                <!--}-->

                <!--return true;-->
            <!--},-->

            <!--/**-->
             <!--* Toggle the display of the list of groups-->
             <!--*/-->
            <!--handleAddClick: function () {-->
                <!--this.$store.commit( 'toggleKumiSelectVisibility' );-->
                <!--this.pendingOperation = 'add';-->
                <!--this.$emit( 'toggle-kumi-list-visibility' );-->

                <!--this.$emit( 'update-select-label', this.selectorLabels.add );-->
            <!--},-->

            <!--/**-->
             <!--* Deletes all selected students-->
             <!--*/-->
            <!--handleDeleteClick: function () {-->
                <!--window.console.log( 'student-action-buttons', 'handleDeleteClick', 136, );-->
                <!--this.pendingOperation = 'delete';-->
                <!--this.isConfirmationModalVisible = true;-->
                <!--//todo confirmation dialog-->
            <!--},-->


            <!--/**-->
             <!--* Removes all selected student from the-->
             <!--* currently displayed group-->
             <!--*-->
             <!--*/-->
            <!--handleRemoveClick: function () {-->
                <!--window.console.log( 'student-action-buttons', 'handleRemoveClick', 172, );-->
                <!--this.pendingOperation = 'remove';-->
                <!--this.isConfirmationModalVisible = true;-->
            <!--},-->


            <!--/**-->
             <!--* Called when confirm is clicked-->
             <!--*/-->
            <!--handleConfirmation: function () {-->
                <!--window.console.log( 'students-action-buttons', 'handleConfirmation', 340, this.selectedStudents );-->

                <!--//close modal-->
                <!--this.isConfirmationModalVisible = false;-->

                <!--switch ( this.pendingOperation ) {-->
                    <!--case 'add':-->
                        <!--this.addStudentsToGroups();-->
                        <!--break;-->
                    <!--case 'remove':-->
                        <!--this.removeStudentsFromGroups();-->
                        <!--break;-->
                    <!--case 'delete':-->
                        <!--this.removeStudentsFromRoster();-->
                        <!--break;-->

                <!--}-->

                <!--//if successful clear and-->
                <!--//close up everything-->
                <!--this.resetDisplay();-->
            <!--},-->

            <!--/**-->
             <!--* Called when cancel is clicked-->
             <!--*/-->
            <!--handleCancellation: function () {-->
                <!--//close up everything-->
                <!--this.resetDisplay();-->
            <!--},-->


            <!--/**-->
             <!--* Adds all selected students to all selected groups-->
             <!--*/-->
            <!--addStudentsToGroups: function () {-->
                <!--window.console.log( 'student-action-buttons', 'addStudentToGroup', 151, );-->
                <!--if ( !this.isOperationValid() ) return;-->
                <!--this.$store.dispatch( 'addStudentsToKumis', this.payload );-->
                <!--// let me = this;-->
                <!--//-->
                <!--// _.forEach( me.selectedKumis, function ( kumi ) {-->
                <!--//     _.forEach( me.selectedStudents, function ( student ) {-->
                <!--//         me.$store.commit( 'associateStudentWithKumi', Payload.factory( {-->
                <!--//             student: student,-->
                <!--//             kumi: kumi-->
                <!--//         } ) );-->
                <!--//     } )-->
                <!--// } )-->

            <!--},-->


            <!--removeStudentsFromGroups: function () {-->

                <!--if ( !this.isOperationValid() ) return;-->
                <!--this.$store.dispatch( 'removeStudentsFromKumis', this.payload );-->

                <!--//-->
                <!--// //remove the selected students-->
                <!--// let me = this;-->
                <!--//-->
                <!--// //NB we use the displayed kumi's since it makes no sense-->
                <!--// //to have to select them separately. We just work with-->
                <!--// //what's on the screen-->
                <!--// _.forEach( me.displayedKumis, function ( kumi ) {-->
                <!--//     _.forEach( me.selectedStudents, function ( student ) {-->
                <!--//         me.$store.commit( 'disassociateStudentFromKumi', Payload.factory( {-->
                <!--//             student: student,-->
                <!--//             kumi: kumi-->
                <!--//         } ) );-->
                <!--//     } )-->
                <!--//-->
                <!--// } )-->

                <!--// }-->
            <!--},-->


            <!--removeStudentsFromRoster: function () {-->

                <!--if ( !this.isOperationValid() ) return;-->

                <!--this.$store.dispatch( 'removeStudentsFromRoster', this.selectedStudents );-->

                <!--//-->
                <!--// //delete the selected students-->
                <!--// let me = this;-->
                <!--//-->
                <!--// _.forEach( this.selectedStudents, function ( student ) {-->
                <!--//     me.$store.commit( mTypes.removeStudentFromRoster, Payload.factory( { obj: student } ) );-->
                <!--// } );-->

            <!--},-->

            <!--/**-->
             <!--* Resets the selected students and kumis to-->
             <!--* default state. Also hides any displayed menus-->
             <!--* and clears the pending operation-->
             <!--*/-->
            <!--resetDisplay: function () {-->
                <!--//hide the displayed kumi selector-->
                <!--if ( this.kumiSelectorVisible ) this.$store.commit( 'toggleKumiSelectVisibility' );-->

                <!--//clear previous selections-->
                <!--this.$store.commit( 'clearSelectedStudents' );-->
                <!--this.$store.commit( 'clearSelectedKumis' );-->

                <!--//make sure the modals are closed-->
                <!--this.isConfirmationModalVisible = false;-->
                <!--this.isErrorModalVisible = false;-->

                <!--//reset the pending operation-->
                <!--this.pendingOperation = false;-->
            <!--},-->


        <!--}-->
    <!--}-->
<!--</script>-->