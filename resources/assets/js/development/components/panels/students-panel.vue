<template>
    <div class="add-students-panel panel">
        <p class="panel-heading">
            <span class="mainHeading">Manage roster</span>
            <br/>
            <span class="smallHeading">Add students, remove students from class, create classes, see individual grades</span>
        </p>

        <div class="panel-block">
            <p class="control has-icons-left">
                <input class="input is-small" type="text" placeholder="Search">
                <span class="icon is-small is-left">
                        <i class="fa fa-search"></i>
                    </span>
            </p>
        </div>

        <p class="panel-tabs kumi-tabs is-boxed">

            <a v-if="isAllTabVisible"
               v-on:click="showAllKumi"
               v-bind:class="[isActive(-1) ? 'is-active' : '' ]"
            >All</a>

            <a v-for="kumi in kumis"
               v-bind:key="kumi.serialNumber"
               v-on:click="handleKumiFilterSelection(kumi.serialNumber)"
               v-bind:class="[isActive(kumi.serialNumber) ? 'is-active' : '' ]"
            >
                <span v-if="isEditable">
                    <kumi-name :serialNumber="kumi.serialNumber"></kumi-name>
                </span>

                <span v-else>
                    {{ kumi.name }}
                </span>
            </a>


            <a class="button-tab">
                <button id="new-kumi-button"
                        class="button is-outlined is-small"
                        v-on:click="newKumi"
                ><span class="icon"><i class="fa fa-plus" aria-hidden="true"></i></span> <span
                        class="sr-only">New</span>
                </button>
            </a>
            <a class="button-tab">
                <button id="edit-kumi-button"
                        class="button is-outlined is-small"
                        v-on:click="editKumi"
                >
                    <span v-if="isEditable">
                    <span class="icon"><i class="fa fa-check-circle-o " aria-hidden="true"></i></span><span
                            class="sr-only">Done</span></span>


                    <span v-else>
                          <span class="icon"><i class="fa fa-pencil" aria-hidden="true"></i></span><span
                            class="sr-only">Edit</span>
                    </span>

                </button>
            </a>
        </p>


        <student-row v-for="student in students"
                     :key="student.serialNumber"
                     :serialNumber="student.serialNumber"
        ></student-row>


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


        <div id="kumi-selection-area"
             class="panel-block"
             v-show="kumiSelectorVisible"
        >
            <kumi-selector></kumi-selector>
        </div>

        <div id="confirmationButtonsArea"
             class="panel-block"
             v-show="showConfirmationButtons"
        >
            <p class="control">
                <button id="cancel-student-operation-button"
                        class="button is-primary is-fullwidth"
                        v-on:click="handleCancellation"
                >Cancel
                </button>
            </p>

            <p class="control">
                <button id="confirm-student-operation-button"
                        class="button is-danger is-fullwidth"
                        v-on:click="handleConfirmation"
                >Confirm
                </button>
            </p>
        </div>

        <div id="student-editing-controls-area"
             class="panel-block"
        >
            <p class="control">
                <button id="student-move-button"
                        class="button student-move-button is-outlined is-primary is-fullwidth"
                        v-on:click="toggleMoveControls"
                >Move
                </button>
            </p>
            <p class="control">
                <button id="student-remove-button"
                        class="button student-remove-button is-outlined is-warning is-fullwidth"
                        v-on:click="toggleRemoveControls"
                >Remove
                </button>
            </p>
            <p class="control">
                <button id="student-delete-button"
                        class="button student-delete-button is-outlined is-danger is-fullwidth"
                        v-on:click="toggleDeleteControls"
                >Delete
                </button>
            </p>

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
    import KumiSelector from '../input/kumi-selector.vue';

    //File importing stuff
    import FileImporter from '../../../store/modules/roster/studentFileImporter';

    //ajax stuff
    //    import { loadExamKumi } from '../../../api/requests/kumiRequests';
    //    import { loadAllStudents } from '../../../api/requests/studentRequests';


    export default {

        props: [],

        components: {
            'student-row': StudentRow,
            'kumi-name': KumiNameField,
            'kumi-selector': KumiSelector
        },

        data: function () {
            return {
                /** Which kumi, if any to filter the displayed rows by*/
                showKumi: -1, //i.e, all
                isEditable: false,
                fileButtonVisible: false,
                kumiSelectorVisible: false,
                showDeleteOperationArea: false,
                showMoveOperationArea: false,
                showRemoveOperationArea: false,
                showConfirmationButtons: false,
                /** whether to show the add and import buttons */
                additionButtonsVisible: true,
                /** This gets populated with objects by the student operation checkboxes */
                selectedStudents: [],
                //holds kumis serial numbers from selector
                //NB, the selector could be easily altered to
                //allow multiple selection. However, the central
                //store only holds one selected kumi.
                //So when we update the central store, we will
                //only add the most recently pushed kumi from this list.
                selectedKumis: [],
                pendingOperation: false, //what operation we are to perform
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
//
//            isActive: function ( ksn ) {
//                return ((ksn, showKumi)=>{
//                    return ksn === showKumi;
//                })(ksn, this.showKumi);
//            },
//

            isAllTabVisible: function () {
                if ( _.isUndefined( this.kumis ) || _.isNull( this.kumis ) ) return false;
                if ( this.kumis.length > 1 ) return true;
                return false;
            },

            students: function () {
                let s = this.$store.getters.getStudentsFromRoster;
                return s;
                //for now, the rows handle their visibility
//                //if no kumi filter, return them all
//                if ( this.showKumi === -1 ) return s;
//
//                //otherwise filter the results
//                return this.$store.getters.getStudentsForKumi( this.showKumi );

            },

        },

        asyncComputed: {
            kumis: function () {
                return this.$store.getters.getKumis;
            },
        },

        watch: {
            //The child selector will set the selected Kumis here
            // Thus we will watch for that and then
            // update the central store
            selectedKumis: function () {
                window.console.log( 'students-panel', 'watch---selectedKumis', 294, this.selectedKumis );
                let pl = Payload.factory( { obj: this.selectedKumis[ this.selectedKumis.length - 1 ] } );
                this.$store.commit( mTypes.updateSelectedKumi, pl );
            }
        },

        methods: {
// ---------------------------- Control which student rows display
            showAllKumi: function () {
                this.showKumi = -1;
            },

            handleKumiFilterSelection: function ( serialNumber ) {
                window.console.log( 'students-panel', 'handleKumiFilterSelection', 151, serialNumber );
                //This could be accidentally called when the area
                //is open for editing.
                //Thus we filter any such calls out
                if ( this.isEditable ) return true;

                this.showKumi = serialNumber;
            },

            isActive: function ( ksn ) {
                    return ksn === this.showKumi;
            },


// ----------------------- Operations on students or kumis
            addStudent: function () {
                window.console.log( 'students-panel', 'addStudent', 190, );
                //create a new student, which will add an empty row
                let s = new Student();
                this.$store.commit( mTypes.addStudentToRoster, Payload.factory( { obj: s } ) );
                //That just added the student to the list of those who exist.
                // Now we need to associate the student with a class/group
                // window.console.log( 'studentRequests', 'associateStudent', 28, response );
                this.$store.commit( mTypes.associateStudentWithKumi, Payload.factory( {
                    student: student
                } ) );
            },

            processFile: function ( evt ) {
                let f = document.getElementById( 'file-input' );
                let file = f.files[ 0 ];
                window.console.log( 'students-panel', 'processFile', 112, evt, f, file );
                //processFile gets called once
                //but it seems the dispatch gets called twice....
                this.$store.dispatch( 'importStudentsFromFile', file );
                //finally, reset the attached file
                f.value = '';
                this.toggleFileButtonVisibility();
            },

            newKumi: function ( evt ) {
                //should open a pane for creating or editing kumi
                let kumi = new Kumi(); //completely empty
                this.$store.commit( 'addKumi', Payload.factory( { obj: kumi } ) );
                //toggle open the edit fields if not already displayed
                if ( !this.isEditable ) this.isEditable = true;

            },

            editKumi: function () {
                this.isEditable = !this.isEditable;
            },

// ------------------------ Control display of tools
            //BUTTONS
            //when these get clicked
            //the rows get told to display a checkbox for being
            //selected for the operation
            toggleDeleteControls: function () {
                window.console.log( 'student-row', 'deleteStudent', 187, this );
                this.$emit( 'toggle-checkbox-delete' );
                this.closeAllOperationAreas();
                this.showDeleteOperationArea = !this.showDeleteOperationArea;
                this.showConfirmationButtons = !this.showConfirmationbuttons;
                this.pendingOperation = 'delete';
                //get the addition buttons out of the way
                this.additionButtonsVisible = !this.additionButtonsVisible;
            },

            toggleRemoveControls: function () {
                window.console.log( 'student-row', 'toggleRemoveControls', 191 );
                this.$emit( 'toggle-checkbox-remove' );
                this.closeAllOperationAreas();
                this.showRemoveOperationArea = !this.showRemoveOperationArea;
                this.showConfirmationButtons = !this.showConfirmationbuttons;
                this.pendingOperation = 'remove';
                //get the addition buttons out of the way
                this.additionButtonsVisible = !this.additionButtonsVisible;
            },

            toggleMoveControls: function () {
                window.console.log( 'student-row', 'toggleMoveControls', 195 );
                this.$emit( 'toggle-checkbox-move' );
                this.closeAllOperationAreas();
                this.showMoveOperationArea = !this.showMoveOperationArea;
                this.showConfirmationButtons = !this.showConfirmationbuttons;
                //show kumi selector
                this.kumiSelectorVisible = !this.kumiSelectorVisible;
                this.pendingOperation = 'move';
                //get the addition buttons out of the way
                this.additionButtonsVisible = !this.additionButtonsVisible;
            },
            toggleFileButtonVisibility: function () {
                this.fileButtonVisible = !this.fileButtonVisible;
            },

            /**
             * Clears and closes all operations areas.
             * Reopens any areas that are open by default
             */
            closeAllOperationAreas: function () {
                //clear previous selections
                this.selectedStudents = [];
                //close all operations areas
                this.showMoveOperationArea = false;
                this.showRemoveOperationArea = false;
                this.showDeleteOperationArea = false;
                this.showConfirmationButtons = false;
                this.pendingOperation = false;
                this.kumiSelectorVisible = false;
                //open stuff that is visible by default
                this.additionButtonsVisible = true;
            },


// ----------------------------------- Events

            /**
             * Called when confirm is clicked
             */
            handleConfirmation: function () {
                window.console.log( 'students-panel', 'handleConfirmation', 340, this.pendingOperation, this.selectedStudents );
                //display any warnings

                _.forEach( this.selectedStudents, ( student ) => {
                    //dispatch action
                    switch ( this.pendingOperation ) {
                        case 'move':
                            var me = this;
                            let ksn = this.selectedKumis[ 0 ];
                            let kumi = me.$store.getters.getSelectedKumi;

//                            _.forEach( this.selectedKumis, ( ksn ) => {
//                                let kumi = me.$store.getters.getKumiBySerialNumber( ksn );
                            window.console.log( 'students-panel', 'kumi', 401, kumi, this.selectedKumi );
                            if ( _.isUndefined( kumi ) ) return false;
                            let pl = Payload.factory( { kumi: kumi, student: student } );
                            window.console.log( 'students-panel', 'pl', 403, pl );
                            me.$store.commit( mTypes.associateStudentWithKumi, pl );
//                            } );
                            break;
                        case 'remove':
                            this.$store.commit( 'removeStudentFromRoster', Payload.factory( { obj: student } ) );
                            break;
                        case 'delete':
                            this.$store.commit( 'deleteStudent', Payload.factory( { obj: student } ) );

                            break;
                    }
                } );

                //if successful clear and
                //close up everything
                this.closeAllOperationAreas();
            },

            /**
             * Called when cancel is clicked
             */
            handleCancellation: function () {
                //close up everything
                this.closeAllOperationAreas();
            },


            handleKumiSelectionEvent: function ( payload ) {
                window.console.log( 'students-panel', 'caught: kumi-selected', 433, payload );

                this.selectedKumis.push( payload.serialNumber );
                window.console.log( 'students-panel', 'handleKumiSelectionEvent', 427, this.selectedKumis );
            },

// ----------------------------------- Styling

            /** Creates the id of the element */
            getInputId: function ( name ) {
                return _.kebabCase( name ) + '-' + this.serialNumber;
            }
        },

        events: {
            'please-close-student-operations': function () {
                this.closeAllOperationAreas();
            },


            'kumi-selected': function ( payload ) {
                window.console.log( 'students-panel', 'caught: kumi-selected', 433, payload );
            }
        }

    }
</script>