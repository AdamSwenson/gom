<template>
    <div id="examNameArea" class="exam-main-component">
        <div class="input-group input-group-lg">

        <span class="input-group-addon"
              id="basic-addon1"
        >
            Assignment Name
        </span>

            <input type="text"
                   class="form-control input-lg"
                   id="privateName"
                   name="privateName"
                   aria-describedby="basic-addon1"
                   v-bind:placeholder="placeHolders.privateName"
                   v-model="privateName"
            />

            <span class="input-group-btn">
                <button class="btn btn-primary"
                        v-on:click="toggleExamProperties"
                ><span class="glyphicon glyphicon-cog"></span></button>
        </span>

        </div>
    </div>
</template>

<style>

</style>

<script>
    import Exam from '../../models/Exam'
    import Item from '../../models/Item'
    import Payload from '../../models/Payload'

    import * as aTypes from '../../store/action-types'
    import * as mTypes from '../../store/mutation-types'
    import * as gTypes from '../../store/getter-types'

    export default{
        props: [
            //optionally the name of the exam to examine
            'exam-id'
            //ability to set type which gets displayed
        ],

        data: function () {
            return {
                placeHolders: {
                    privateName: "Enter a descriptive name for this assignment (e.g., English 101 Exam #1)",
                    publicName: ""
                },

                types: [ 'Assignment', 'Essay', 'Exam' ],

                defaults: {
                    type: 'Assignment'
                },
            };
        },

        computed: {
            /**
             * The name which only the user can see
             */
            privateName: {
                get: function () {
                    let exam = this.getExam();
                    if ( exam ) {
                        return exam.name;
                    }
                }
            },
            set: function ( v ) {
                //store the name in the data object
                this.$store.commit( mTypes.updateActiveExamProp, Payload.factory( {
                    updateProp: 'name',
                    updateVal: v
                } ) );
            },
        },


        methods: {

            getExam: function () {
                return this.$store.getters[ gTypes.getActiveExamObj ];
            },

            /**
             * Requests that the exam properties area display or hide
             */
            toggleExamProperties: function () {
                this.$store.commit( mTypes.toggleExamSettings );
                console.log( 'toggleExamProperties clicked' );
            }
        },

        directives: {},

        events: {},

        mounted: function () {
            //create an exam object if one isn't set
            //however don't ask the server to create an id just yet
//            if ( !this.getExam() ) {
//                //create an exam object with index 0
//                let exam = Exam.factory( {index: 0} );
//                console.log( 'no exam set, creating one', exam );
//                this.$store.dispatch( aTypes.setActiveExam, Payload.factory( {obj: exam} ) );
//                //push into stack as root item
//                //todo
//            }
            console.log( 'exam-main ready' );
        },
    }

</script>
