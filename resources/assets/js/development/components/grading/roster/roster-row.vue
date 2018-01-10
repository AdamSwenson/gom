<template>
    <a class="panel-block student-row"
       v-bind:class="rowStyling"
       v-on:click="handleRowSelection"
       v-if="isRowVisible"
    >
        <span class="panel-icon" >
            <i v-if="! isGraded" class="fa fa-user"></i>
            <i v-if="isGraded" class="fa fa-check-circle"></i>
        </span> {{ studentName }}
    </a>
</template>

<style lang="scss">
.student-row{
    .gradedStudentRow{
        /*background: #1b6d85;*/
    }
}
</style>

<script>


    import * as ngmTypes from '../../../../store/modules/newgrading/new-grading-mutation-types';
    import * as ngaTypes from '../../../../store/modules/newgrading/new-grading-action-types';
    import * as nggTypes from '../../../../store/modules/newgrading/new-grading-getter-types';

    import * as gTypes from '../../../../store/getter-types';

    import Payload from '../../../../models/Payload';

    export default {

        props: [ 'student' ],

        components: {},

        data: function () {
            return {

                rowStylings: {
                    activeStudent: 'is-active',
                    gradedStudent: 'gradedStudentRow',
                    unalteredStudent: 'unalteredStudentRow'
                },

                defaults: {}
            }
        },

        computed: {
            /**
             * The student who is presently being graded
             */
            activeStudent: function () {
                return this.$store.getters[ nggTypes.getActiveStudent ];
            },

            areGradedStudentRowsVisible : function (  ) {
              return this.$store.getters[ nggTypes.areGradedStudentRowsVisible];
            },

            /**
             * Returns boolean of whether this is the student
             * who is currently being graded
             * @returns {boolean}
             */
            isActiveStudent: function () {
                if ( this.activeStudent && this.activeStudent.id === this.student.id ) return true;

                return false;
            },

            /**
             * Whether to show student name
             * false is blind grading.
             */
            isStudentNameVisible: function () {
                return this.$store.getters[ nggTypes.areStudentNamesVisible ];
            },


            /**
             * Whether the student has been graded
             * and is not the currently selected student
             */
            isGraded: function () {
                let graded = this.$store.getters[nggTypes.getGradedStudentIds];
                return graded.indexOf(this.student.id) > -1;

            },

            isRowVisible : function (  ) {
                //if we are to be hiding graded rows and the row is graded, hide it
                if( this.isGraded && ! this.areGradedStudentRowsVisible ) return false;
                return true;
            },

            /**
             * Gets the appropriate classes for the student
             */
            rowStyling: function () {
                // return '';

                if ( this.isActiveStudent ) return this.rowStylings.activeStudent;


                // if ( this.isGraded ) return this.rowStylings.gradedStudent;

                //  if(this.isUnaltered(student)) return this.rowStylings.isUnaltered;
                // return this.rowStylings.isUnaltered;

            },

            studentName: function () {
                if ( this.isStudentNameVisible ) {
                    return this.student.nameLastFirst + '             ' + this.student.identifier;
                }
                return this.student.identifier;
            }


        },

        methods: {

            handleRowSelection: function (  ) {
                this.$store.dispatch( ngaTypes.setStudentAsActive, this.student );
            },


        },

    }
</script>