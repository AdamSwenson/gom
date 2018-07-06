<template>

    <div id="active-student-area" class="active-student-area">

        <span class="has-text-primary">
            <span class="active-student-name">{{ studentName }}</span>  <span class="active-student-id"> {{studentIdentifier }}</span>
        </span>
    </div>

</template>

<style>

</style>
<script>


    import * as nggTypes from '../../../../store/new-grading-getter-types';
    import Student from '../../../../models/Student';
    import PayloadTime from '../../../../models/PayloadTime';

    // //TODO figure out which typeahead to use
    //    var Typeahead = require( 'typeahead' );

    // var typeahead = require( '../libraries/bootstrap3-typeahead.min.js' );
    // var typeahead = require( '../libraries/typeahead.bundle.js' );
    //TODO needs typeahead stuff
    module.exports = {

        props: [],

        data: function () {
            return {
                icons: {},
                srText: {}
            };
        },

        computed: {
            activeStudent: function () {
                return this.$store.getters[ nggTypes.getActiveStudent ];
            },

            /**
             * The name of the student currently being graded
             */
            studentName: function () {
                if ( _.isNull( this.activeStudent ) ) return '';
                if ( !this.isStudentNameVisible ) return '';

                return this.activeStudent.nameFirstLast;
            },

            /**
             * The identifier of the student currently being graded
             */
            studentIdentifier: function () {
                if ( _.isUndefined( this.activeStudent ) ) return '';

                return !_.isNull( this.activeStudent ) ? this.activeStudent.studentIdentifier : '';
            },


            /**
             * Whether to show student names
             * false is blind grading.
             */
            isStudentNameVisible: function () {
                return this.$store.getters[ nggTypes.areStudentNamesVisible ];
            },
        },
    };
</script>