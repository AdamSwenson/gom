<template>
    <div class="add-students-panel panel">
        <p class="panel-heading">
            Add students, remove students from class, create classes, see individual grades
        </p>

        <div class="panel-block">
            <p class="control has-icons-left">
                <input class="input is-small" type="text" placeholder="Search">
                <span class="icon is-small is-left">
                        <i class="fa fa-search"></i>
                    </span>
            </p>
        </div>


        <p class="panel-tabs">
            <a class="is-active">All</a>
            <a>Section 1</a>
            <a>Section 2</a>
            <a>Section 3</a>
        </p>

        <student-row v-for="student in students"
                     :key="student.serialNumber"
                     :serialNumber="student.serialNumber"
        ></student-row>


        <div class="panel-block">
            <button id="add-students-button"
                    class="button is-primary is-outlined is-fullwidth"
                    v-on:click="toggleFileButtonVisibility">
                Add students
            </button>
        </div>


        <div class="panel-block"
             v-show="fileButtonVisible"

        >
            <!--<p class="control">-->
            <!--<button class="button is-primary is-outlined is-fullwidth"  >Upload</button>-->
            <!--</p>-->
            <p class="control">
                <input id="file-input"
                       v-on:change="processFile"
                       class="input"
                       type="file"/>
            </p>

        </div>
    </div>

</template>

<style lang="scss">

    .add-students-panel {

    }

</style>

<script>
    import Comment from '../../../models/Comment'
    import Payload from '../../../models/Payload'
    import Exam from '../../../models/Exam'
    import * as mTypes from '../../../store/mutation-types';
    import * as aTypes from '../../../store/action-types';
    import * as gTypes from '../../../store/getter-types';

    import FileImporter from '../../../store/utlities/studentFileImporter';
    import StudentRow from './student-row.vue'

    export default{

        props: [],

        components: {
            'student-row': StudentRow
        },

        data: function () {
            return {
                fileButtonVisible: false,
                defaults: {}
            }
        },

        computed: {

            item: function () {
                return this.$store.getters.getItemBySerialNumber( this.serialNumber );
            },

            //Doing this via computed property so don't have to pass in on route
            isExam: function () {
                if ( this.item instanceof Exam ) return true;
                return false;
            },

            students: function () {
                return this.$store.getters.getStudentsFromRoster;

            }
        },

        methods: {
            toggleFileButtonVisibility: function () {
                this.fileButtonVisible = !this.fileButtonVisible;
            },

            processFile: function ( evt ) {
                let f = document.getElementById( 'file-input' );
                let file = f.files[ 0 ];
                window.console.log( 'students-panel', 'processFile', 112, f, file );
                this.$store.dispatch( 'importStudentsFromFile', file );

//                let students = FileImporter.handleRead(file);
//                window.console.log( 'students-panel', 'processFile', 116, students);

            }
        },

        directives: {},

        events: {},

        mounted: function () {
        }
    }
</script>