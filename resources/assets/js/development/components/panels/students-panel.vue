<template>
    <div class="add-students-panel panel">
        <p class="panel-heading">
            <span class="mainHeading">Manage roster</span>
            <br/>
            <span class="smallHeading">Add students, manage classes and groups, see individual grades</span>
        </p>

        <div id="student-search-area"
             class="panel-block"
             v-if="showSearch"
        >
            <p class="control has-icons-left">
                <input class="input is-small" type="text" placeholder="Search">
                <span class="icon is-small is-left">
                        <i class="fa fa-search"></i>
                </span>
            </p>
        </div>

        <div class="panel-tabs">
            <span class="is-pulled-left">Groups</span>
            <kumi-tabs></kumi-tabs>
        </div>


        <div id="student-table-area"
             class="panel-block"
        >
            <student-table :students="students"></student-table>
        </div>

        <div id="addition-buttons-area"
             class="panel-block"
             v-show="additionButtonsVisible"
        >
            <button id="new-student-button"
                    class="button is-primary is-outlined is-fullwidth"
                    v-on:click="addStudent"
            >Add student
            </button>

            <button id="add-students-button"
                    class="button is-primary is-outlined is-fullwidth"
                    v-on:click="toggleFileButtonVisibility">
                Import students
            </button>
        </div>

        <div id="file-input-area"
             class="panel-block"
             v-show="fileButtonVisible"
        >
            <p class="control">
                <input id="file-input"
                       class="input is-primary is-fullwidth"
                       type="file"
                       v-on:change.prevent="processFile"
                />
            </p>

        </div>

        <kumi-selector
                injectable-class="panel-block"
        >
            <label class="label" slot="label"> {{ kumiSelectorLabel }}</label>
        </kumi-selector>

        <div id="student-editing-controls-area">
            <student-action-buttons
                    injectable-classes="panel-block"
                    v-on:update-select-label="updateSelectLabel"
            ></student-action-buttons>
        </div>

    </div>



</template>

<style lang="scss">

    .add-students-panel {

        .mainHeading {

        }

        .smallHeading {
            font-size: small;
        }

    }

</style>

<script>
    import Comment from '../../../models/Comment';
    import Payload from '../../../models/Payload';
    import Exam from '../../../models/Exam';
    import Student from '../../../models/Student';
    import Kumi from '../../../models/Kumi';
    import * as mTypes from '../../../store/mutation-types';
    import * as aTypes from '../../../store/action-types';
    import * as gTypes from '../../../store/getter-types';

    //components
    import StudentRow from './student-row.vue'
    import KumiNameField from '../input/kumi-name-field.vue';
    import KumiSelector from './kumi/kumi-selector.vue';
    import KumiTabs from './kumi/kumi-tabs.vue';

    import StudentTable from '../panels/student/student-table.vue';
    import StudentActionButtons from './student/student-action-buttons.vue';
    //File importing stuff
    import FileImporter from '../../../store/modules/roster/studentFileImporter';

    //ajax stuff
    //    import { loadExamKumi } from '../../../api/requests/kumiRequests';
    //    import { loadAllStudents } from '../../../api/requests/studentRequests';


    export default {

        props: [],

        components: {
            'kumi-name': KumiNameField,
            'kumi-selector': KumiSelector,
            'student-table': StudentTable,
            'student-action-buttons': StudentActionButtons,
            'kumi-tabs': KumiTabs
        },

        data: function () {
            return {

                fileButtonVisible: false,

                showSearch: false,

                /** whether to show the add and import buttons */
                additionButtonsVisible: true,

                kumiSelectorLabel: '',


                defaults: {}
            }
        },

        computed: {
            exam: function () {
                return this.$store.getters.currentExam;
            },

            examId: function () {
                return this.exam ? this.exam.id : null;
            },

            item: function () {
                return this.$store.getters.getItemBySerialNumber( this.serialNumber );
            },

            //Doing this via computed property so don't have to pass in on route
            isExam: function () {
                if ( this.item instanceof Exam ) return true;
                return false;
            },

            students: function () {
                let s = this.$store.getters.getStudentsFromRoster;
                return s;
            },

            selectedStudents: function () {
                return this.$store.getters.getSelectedStudents;
            },

            selectedKumis: function () {
                return this.$store.getters.getSelectedKumis;
            }


        },

        watch: {},

        methods: {

            updateSelectLabel: function ( evt ) {
                this.kumiSelectorLabel = evt;
            },

// ----------------------- Operations on students or kumis
            addStudent: function () {
                window.console.log( 'students-panel', 'addStudent', 190, );
                //create a new student, which will add an empty row
                let s = new Student();
                //Push the student into local storage and create
                //a new student on the server.
                //This also will associate with the currently selected
                //kumi
                let pl = Payload.factory( { obj: s, student: s } );
                this.$store.dispatch( aTypes.handleNewStudentStorageAndAssociation, pl );
            },

            processFile: function ( evt ) {
                let f = document.getElementById( 'file-input' );
                let file = f.files[ 0 ];

                //processFile gets called once
                //as indicated by this line only printing once
                window.console.log( 'students-panel', 'processFile', 112, evt, f, file );

                //but then it seems this line gets called twice....
                //since all the messages for importStudentsFromFile
                //display twice
                this.$store.dispatch( 'importStudentsFromFile', file );

                window.console.log( 'students-panel', 'processFile', 332, 'after the dispatch has weirdly fired twice' );
                //finally, reset the attached file
                f.value = '';
                this.toggleFileButtonVisibility();
            },

            toggleFileButtonVisibility: function () {
                this.fileButtonVisible = !this.fileButtonVisible;
                this.operationsButtonsVisible = !this.operationsButtonsVisible;
            },

            /** Creates the id of the element */
            getInputId: function ( name ) {
                return _.kebabCase( name ) + '-' + this.serialNumber;
            }

//            newKumi: function ( evt ) {
//                //should open a pane for creating or editing kumi
//                let kumi = new Kumi(); //completely empty
//                this.$store.commit( 'addKumi', Payload.factory( { obj: kumi } ) );
//                //toggle open the edit fields if not already displayed
//                if ( !this.isEditable ) this.isEditable = true;
//
//            },
//
//            toggleEditable: function () {
//                this.isEditable = !this.isEditable;
//            },

// ------------------------ Control display of tools
            //BUTTONS
            //when these get clicked
            //the rows get told to display a checkbox for being
            //selected for the operation
//            toggleDeleteControls: function () {
//                window.console.log( 'student-row', 'deleteStudent', 187, this );
//                this.$emit( 'toggle-checkbox-delete' );
//                //clear everything and reset display
//                this.closeAllOperationAreas();
//                //if delete was already showing, then clicking delete is effectively
//                //the same as clicking cancel. So we can just stop.
//                if ( this.showDeleteOperationArea ) return true;
//                //If no operation was selected or another operation  was open,
//                //we show the delete area
//                this.showDeleteOperationArea = !this.showDeleteOperationArea;
//                this.showConfirmationButtons = !this.showConfirmationbuttons;
//                this.pendingOperation = 'delete';
//                //get the addition buttons out of the way
//                this.additionButtonsVisible = !this.additionButtonsVisible;
//            },

//            toggleKumiList: function () {
//            },

            /**
             * @deprecated
             */
//            toggleRemoveControls: function () {
//                window.console.log( 'student-row', 'toggleRemoveControls', 191 );
//                this.$emit( 'toggle-checkbox-remove' );
//                //clear everything and reset display
//                this.closeAllOperationAreas();
//                //if remove was already showing, then clicking remove is effectively
//                //the same as clicking cancel. So we can just stop.
//                if ( this.showRemoveOperationArea ) return true;
//                //If no operation was selected or another operation  was open,
//                //we show the remove area
//                this.showRemoveOperationArea = !this.showRemoveOperationArea;
//                this.showConfirmationButtons = !this.showConfirmationbuttons;
//                this.pendingOperation = 'remove';
//                //get the addition buttons out of the way
//                this.additionButtonsVisible = !this.additionButtonsVisible;
//            },

            /**
             * @deprecated
             */
//            toggleMoveControls: function () {
//                window.console.log( 'student-row', 'toggleMoveControls', 195 );
//                this.$emit( 'toggle-checkbox-move' );
//                //clear everything and reset display
//                this.closeAllOperationAreas();
//                //if move was already showing, then clicking move is effectively
//                //the same as clicking cancel. So we can just stop.
//                if ( this.showMoveOperationArea ) return true;
//                //If no operation was selected or another operation  was open,
//                //we show the move area
//                this.showMoveOperationArea = !this.showMoveOperationArea;
//                this.showConfirmationButtons = !this.showConfirmationbuttons;
//                //show kumi selector
//                this.kumiSelectorVisible = !this.kumiSelectorVisible;
//                this.pendingOperation = 'move';
//                //get the addition buttons out of the way
//                this.additionButtonsVisible = !this.additionButtonsVisible;
//            },


//            /**
//             * @deprecated
//             * Clears and closes all operations areas.
//             * Reopens any areas that are open by default
//             */
//            closeAllOperationAreas: function () {
//                //clear previous selections
//                this.selectedStudents = [];
//                //close all operations areas
//                this.showMoveOperationArea = false;
//                this.showRemoveOperationArea = false;
//                this.showDeleteOperationArea = false;
//                this.showConfirmationButtons = false;
//                this.pendingOperation = false;
//                this.kumiSelectorVisible = false;
//                //open stuff that is visible by default
//                this.additionButtonsVisible = true;
//                this.operationsButtonsVisible = true;
//            },
//

// ----------------------------------- Events

//            /**
//             * Called when confirm is clicked
//             */
//            handleConfirmation: function () {
//                window.console.log( 'students-panel', 'handleConfirmation', 340, this.pendingOperation, this.selectedStudents );
//                //display any warnings
//
//                _.forEach( this.selectedStudents, ( student ) => {
//                    //dispatch action
//                    switch ( this.pendingOperation ) {
//                        case 'move':
//                            var me = this;
//                            let ksn = this.displayedKumis[ 0 ];
//                            let kumi = me.$store.getters.getSelectedKumi;
//
////                            _.forEach( this.displayedKumis, ( ksn ) => {
////                                let kumi = me.$store.getters.getKumiBySerialNumber( ksn );
//                            window.console.log( 'students-panel', 'kumi', 401, kumi, this.selectedKumi );
//                            if ( _.isUndefined( kumi ) ) return false;
//                            let pl = Payload.factory( { kumi: kumi, student: student } );
//                            window.console.log( 'students-panel', 'pl', 403, pl );
//                            me.$store.commit( mTypes.associateStudentWithKumi, pl );
////                            } );
//                            break;
//                        case 'remove':
//                            this.$store.commit( 'removeStudentFromRoster', Payload.factory( { obj: student } ) );
//                            break;
//                        case 'delete':
//                            this.$store.commit( 'deleteStudent', Payload.factory( { obj: student } ) );
//
//                            break;
//                    }
//                } );

//                //if successful clear and
//                //close up everything
//                this.closeAllOperationAreas();
//            },
//
//            /**
//             * Called when cancel is clicked
//             */
//            handleCancellation: function () {
//                //close up everything
//                this.closeAllOperationAreas();
//            },

//            handleKumiSelectionEvent: function ( payload ) {
//                window.console.log( 'students-panel', 'caught: kumi-selected', 433, payload );
//
//                this.displayedKumis.push( payload.serialNumber );
//                window.console.log( 'students-panel', 'handleKumiSelectionEvent', 427, this.displayedKumis );
//            },

// ----------------------------------- Styling and attributes


        },

        events: {
//            'please-close-student-operations': function () {
//                this.closeAllOperationAreas();
//            },
//

//            'kumi-selected': function ( payload ) {
//                window.console.log( 'students-panel', 'caught: kumi-selected', 433, payload );
//            }
        }

    }
</script>