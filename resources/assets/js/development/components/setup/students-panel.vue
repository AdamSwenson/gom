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

            <kumi-tabs></kumi-tabs>

        </div>

        <div id="student-table-area"
             class="panel-block"
        >

            <student-table :students="students"></student-table>

        </div>


        <div class="addition-buttons-area panel-block"
             v-show="additionButtonsVisible"
        >
            <div class="buttons">

                <add-student-control></add-student-control>

                <button id="import-students-button"
                        class="button is-primary is-outlined "
                        v-on:click="toggleFileButtonVisibility"
                >Import students
                </button>

                <new-kumi-control type="button"></new-kumi-control>

                <!--This requires the kumi editing modal to also be included on the page-->
                <edit-kumi-control type="button"></edit-kumi-control>

            </div>

            <!--This goes with the edit kumi control-->
            <kumi-editing-modal></kumi-editing-modal>
        </div>

        <div class="panel-block"
             id="file-input-area"
             v-if="fileButtonVisible"
        >
            <import-students-control
                    v-on:student-import-complete="handleImportComplete"
            ></import-students-control>

        </div>

        <div class="panel-block"
             v-if="isKumiSelectorVisible"
        >
            <kumi-selector>
                <label class="label" slot="label"> {{ kumiSelectorLabel }}</label>
            </kumi-selector>
        </div>

        <div class="panel-block">
            <student-action-button-parent></student-action-button-parent>
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
    import StudentRow from '../old/student-row.vue'
    import KumiNameField from './kumi/kumi-name-field.vue';
    import KumiSelector from './kumi/kumi-selector.vue';
    import KumiTabs from './kumi/kumi-tabs.vue';

    import StudentTable from './/student/student-table.vue';
    import StudentActionButtons from './student/student-action-buttons.vue';
    //File importing stuff
    import FileImporter from '../../../store/modules/roster/studentFileImporter';
    import ImportStudentsControl from "./student/import-students-control.vue";
    import AddStudentControl from "./student/action-buttons/add-student-button.vue";

    import { loadAllStudents } from '../../../api/requests/studentRequests';
    import NewKumiControl from "./kumi/new-kumi-control";
    import EditKumiControl from "./kumi/edit-kumi-control";
    import KumiEditingModal from "./kumi/kumi-editing-modal";
    import StudentActionButtonParent from "./student/action-buttons/student-action-button-parent";


    export default {

        props: [],

        components: {
            StudentActionButtonParent,
            KumiEditingModal,
            EditKumiControl,
            NewKumiControl,
            AddStudentControl,
            ImportStudentsControl,
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
                return this.$store.getters[ gTypes.getActiveExam ];
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

            /**
             * Whether the kumi selector is shown or visible.
             * It will use the value stored
             * in roster.display.kumiSelectVisible
             */
            isKumiSelectorVisible: function () {
                return this.$store.getters.isKumiSelectVisible;
            },

            students: function () {
                return this.$store.getters.getStudentsFromRoster;
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

            //
            // handleAddStudentComplete: function () {
            //     // window.console.log( 'students-panel', 'handleAddStudentComplete', 223, );
            // },
            //
            /**
             * Handler for the event emitted by the import button
             */
            handleImportComplete: function () {
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


        },

        mounted: function () {
            let me = this;
            let p = this.$store.dispatch( 'loadKumisForExamFromServer', this.exam );
            p.then( function () {
                me.$store.dispatch( 'loadStudentsFromServer', me.exam );
            } );
        }

    }
</script>