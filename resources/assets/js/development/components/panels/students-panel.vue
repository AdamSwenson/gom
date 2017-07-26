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

        <p class="panel-tabs kumi-tabs">

            <a v-if="isAllTabVisible"
               class="is-active"
            >All</a>

            <a v-if="isEditable"
               v-for="kumi in kumis"
               v-bind:key="kumi.serialNumber"
            >
                <kumi-name :serialNumber="kumi.serialNumber"></kumi-name>
            </a>

            <a v-else
               v-for="kumi in kumis"
               v-bind:key="kumi.serialNumber"
               v-on:click="filterByKumi(kumi.serialNumber)"
            >
                {{ kumi.name }}
            </a>

            <a>
                <button id="new-kumi-button"
                        class="button is-outlined is-small"
                        v-on:click="newKumi"
                >
                    <i class="fa fa-users" aria-hidden="true"></i> New
                </button>

                <button id="edit-kumi-button"
                        class="button is-outlined is-small"
                        v-on:click="editKumi"
                >
                    <span v-if="isEditable">
                        <i class="fa fa-check-circle-o " aria-hidden="true"></i> Done
                    </span>

                    <span v-else>
                        <i class="fa fa-pencil" aria-hidden="true"></i> Edit
                    </span>

                </button>
            </a>
        </p>

        <!--<p class="panel-tabs kumi-tabs"-->
        <!--v-else-->
        <!--&gt;-->
        <!--<a class="is-active">All</a>-->
        <!--<a v-for="kumi in kumis"-->
        <!--v-bind:key="kumi.serialNumber"-->
        <!--v-on:click="filterByKumi(kumi.serialNumber)"> {{ kumi.name }}-->
        <!--</a>-->

        <!--<a class="control">-->
        <!--<button id="new-kumi-button"-->
        <!--class="button is-outlined is-small"-->
        <!--v-on:click="newKumi"-->
        <!--&gt;-->
        <!--<i class="fa fa-users"-->
        <!--aria-hidden="true"></i> New-->
        <!--</button>-->
        <!--</a>-->
        <!--<a class="control">-->
        <!--<button id="edit-kumi-button"-->
        <!--class="button is-outlined is-small"-->
        <!--v-on:click="editKumi"-->
        <!--&gt;-->
        <!--<i class="fa fa-pencil"-->
        <!--aria-hidden="true"></i> Edit-->
        <!--</button>-->
        <!--</a>-->

        <!--</p>-->


        <student-row v-for="student in students"
                     :key="student.serialNumber"
                     :serialNumber="student.serialNumber"
        ></student-row>


        <div class="panel-block">
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


        <div class="panel-block"
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

        <div class="panel-block">
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


        <div class="panel-block"
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
                showKumi: -1, //i.e, all
                isEditable: false,
                fileButtonVisible: false,
                kumiSelectorVisible: false,
                showDeleteOperationArea: false,
                showMoveOperationArea: false,
                showRemoveOperationArea: false,
                showConfirmationButtons: false,
                selectedStudents: [],
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

            isAllTabVisible: function () {
                if ( _.isUndefined( this.kumis ) || _.isNull(this.kumis) ) return false;
                if ( this.kumis.length > 1 ) return true;
                return false;
            },

            students: function () {
                let s = this.$store.getters.getStudentsFromRoster;
                //if no kumi filter, return them all
                if ( this.showKumi === -1 ) return s;

                //otherwise filter the results
                return this.$store.getters.getStudentsForKumi( this.showKumi );

            },

        },

        asyncComputed: {
            kumis: function () {
                return this.$store.getters.getKumis;
            },


        },

        methods: {
            addStudent: function () {
                window.console.log( 'students-panel', 'addStudent', 190, );
                //create a new student, which will add an empty row
                let s = new Student();
                this.$store.commit( 'addStudentToRoster', Payload.factory( { obj: s } ) );
            },

            filterByKumi: function ( serialNumber ) {
                window.console.log( 'students-panel', 'filterByKumi', 151, serialNumber );
                let kumi = this.$store.getters.getKumiBySerialNumber( serialNumber );
//                this.$store.commit( 'updateSelectedKumi', Payload.factory( { obj: kumi } ) );
            },

            toggleFileButtonVisibility: function () {
                this.fileButtonVisible = !this.fileButtonVisible;
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
            },

            toggleRemoveControls: function () {
                window.console.log( 'student-row', 'toggleRemoveControls', 191 );
                this.$emit( 'toggle-checkbox-remove' );
                this.closeAllOperationAreas();
                this.showRemoveOperationArea = !this.showRemoveOperationArea;
                this.showConfirmationButtons = !this.showConfirmationbuttons;
                this.pendingOperation = 'remove';
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
            },

            /**
             * Clears and closes all operations areas
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
            },

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


            //Creates the id of the element
            getInputId: function ( name ) {
                return _.kebabCase( name ) + '-' + this.serialNumber;
            }
        },

        events: {
            'please-close-student-operations': function () {
                this.closeAllOperationAreas();
            }
        }

    }
</script>