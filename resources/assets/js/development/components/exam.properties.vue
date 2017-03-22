<template>
    <!--This is the hideable area via which we edit the exam's properties-->

    <div class="row"
         v-show="isHidden">
        <div class="col-lg-10">
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
                >
                <span class="glyphicon glyphicon-question-sign"></span>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-5">
                <h3>Update the properties for the overall exam here.</h3>
                <!-- term selector -->
                <input v-model="term"
                       name="examTerm"
                       type="hidden"
                       id="hiddenTerm"
                />

                <div class="btn-group btn-group">
                    <button
                            class="btn btn-primary dropdown-toggle"
                            id="term"
                            title="Choose Term"
                            data-toggle="dropdown"
                    >{{ term }} <span class="glyphicon glyphicon-menu-down"></span></button>

                    <ul class="dropdown-menu" id="termList" role="menu" style="cursor:pointer;">
                        <li v-for="term in terms">
                            <a class="termItem">{{ term }}</a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="col-lg-5">
                <!-- year selector -->
                <input name="examYear"
                       type="hidden"
                       id="hiddenYear"
                       v-model="year"
                />

                <div class="btn-group btn-group">
                    <button class="btn btn-primary dropdown-toggle"
                            id="year"
                            title="Choose Year"
                            data-toggle="dropdown">{{ year }}
                        <span class="glyphicon glyphicon-menu-down"></span>
                    </button>

                    <ul class="dropdown-menu"
                        id="yearList"
                        role="menu"
                        style="cursor:pointer;">
                        <li v-for="year in years">
                            <a class="yearItem">{{ year }}</a>
                        </li>
                    </ul>
                </div>
                <span class="glyphicon glyphicon-question-sign"></span>
            </div>
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

        props: [ 'exam-id' ],

        data: function () {
            return {
                isHidden: true
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
                    return this.$store.getters[ gTypes.getExam ]( Payload.factory( {examId: this.examId} ) );
                },
                set: function () {
                }
            },
            terms: [ 'fall', 'winter', 'spring', 'summer' ],

            term: {
                get: function () {
                },
                set: function () {
                }
            },
            year: {
                get: function () {
                },
                set: function () {
                }
            },
            years: {
                get: function () {
                },
                set: function () {
                }
            },
        },

        methods: {
            openPropsArea: function () {
                //make visible
                this.isHidden = false;
            },

            closePropsArea: function () {
                //hide
                this.isHidden = true;
            },


            togglePropsArea: function () {
                //hide
                this.isHidden = !this.isHidden;
            }
        },

        directives: {},

        events: {
            /**
             * If properties are showing, hide them; or vice-versa
             */
            'toggle-exam-properties': function () {
                this.togglePropsArea();
            },
            /**
             * Display exam properties area
             */
            'open-exam-properties': function () {
                this.openPropsArea();
            },
            /**
             * Close exam properties area
             */
            'close-exam-properties': function () {
                this.closePropsArea();
            },
        },

        ready: function () {

            //check if exam id was provided,
            // if not, create a new exam object and set it
            // as active.
            if(typeof this.examId == 'undefined'){

            }
            //Also get ready to request an exam id from the server
            //as soon as the user does something which alters the store
            console.log( 'exam-properties ready' );
            console.log( 'exam-properties ready' );
        },
    };
</script>
