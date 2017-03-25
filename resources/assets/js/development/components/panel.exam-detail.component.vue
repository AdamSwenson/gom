<template>
    <!--This is the hideable area via which we edit the exam's properties-->
    <div class="panel-exam-detail  ">
        <div class="row">
            <div class="col-md-6">

                <!-- name input -->
                <div class="input-group">
                    <span class="input-group-addon"
                          id="basic-addon1">Public Assignment Name</span>
                    <input type="text"
                           class="form-control input-lg"
                           id="publicName"
                           name="publicName"
                           aria-describedby="basic-addon1"
                           v-model="publicName"
                           v-bind:placeholder="placeholders.publicName"
                    >
                </div>
            </div>
            <div class="col-md-1">
                <span class="glyphicon glyphicon-question-sign"></span>
            </div>

        </div>

        <div class="row">
            <div class="col-md-6">
                <b-dropdown v-bind:text="term"
                            variant="primary"
                            split class=""
                >
                    <b-dropdown-item href="#">Winter</b-dropdown-item>
                    <b-dropdown-item href="#">Spring</b-dropdown-item>
                    <b-dropdown-item href="#">Summer</b-dropdown-item>
                    <b-dropdown-item href="#">Fall</b-dropdown-item>
                </b-dropdown>
            </div>

            <div class="col-md-1">
                <span class="glyphicon glyphicon-question-sign"></span>
            </div>
            <!--<list-dropdown type="term"></list-dropdown>-->

        </div>
    </div>

</template>

<style>

</style>

<script>

    import * as aTypes from '../../store/action-types';
    import * as mTypes from '../../store/mutation-types';
    import * as gTypes from '../../store/getter-types';

    import Payload from '../../models/Payload'


    export default{

        props: ['exam-id'],

        data: function () {
            return {
            placeholders :{
                publicName : "If you would like students to see a different name for the exam, enter the name you would like them to see here"},

                //0 index always has an exam
                index: 0,

                terms: ['fall', 'winter', 'spring', 'summer'],
            };
        },

        computed: {

            /**
             * Name which will be visible to students when they see the exam.
             * Otherwise it will just be referred to as 'Your exam' or
             * 'Your assignment'
             */
            publicName: {
                get: function () {
                    let exam = this.getExam();
                    return exam.name;
//                    return this.$store.getters[ gTypes.getExam ]( Payload.factory( {examId: this.examId} ) );
                },
                set: function (v) {
                    this.$store.commit(mTypes.updateActiveExamProp, Payload.factory({
                        updateProp: 'publicName',
                        updateVal: v
                    }));
                }
            },

            term: {
                get: function () {
                    let exam = this.getExam(); //this.$store.getters[ gTypes.getActiveExamObj];
                    return exam.term;
                },
                set: function () {
                    this.$store.commit(mTypes.updateActiveExamProp, Payload.factory({
                        updateProp: 'term',
                        updateVal: v
                    }));
                }
            },
            year: {
                get: function () {
                    let exam = this.getExam() //                    let exam = this.$store.getters[ gTypes.getActiveExamObj ];
                    return exam.year;
                },
                set: function (v) {
                    this.$store.commit(mTypes.updateActiveExamProp, Payload.factory({
                        updateProp: 'year',
                        updateVal: v
                    }));

                }
            },
            years: function () {
                return [2017, 2018];
            },

        },

        methods: {
            getExam: function () {
                return this.$store.getters[gTypes.getActiveExamObj];
            },

            updateExam: function () {

            }

        },

        directives: {},

        events: {},

        mounted: function () {

            //check if exam id was provided,
            // if not, create a new exam object and set it
            // as active.
            if (typeof this.examId == 'undefined') {

            }
            //Also get ready to request an exam id from the server
            //as soon as the user does something which alters the store


            console.log('exam-edit-pane ready');
        },
    };
</script>
