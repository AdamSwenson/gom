<template>
    <div id="examNameArea" class="exam-main-component row">
        <div class="col-lg-2">
            <h4>{{headingName}}</h4>
        </div>

        <div class="col-lg-6">
            <input type="text"
                   class="form-control input-lg"
                   id="privateName"
                   name="privateName"
                   aria-describedby="basic-addon1"
                   v-bind:placeholder="placeHolders.privateName"
                   v-model="privateName"/>
        </div>

        <div class="col-lg-2 text-right">
            <settings-button :index="0"></settings-button>
        </div>

    </div>


    <!--<div id="examNameArea" class="exam-main-component">-->
    <!--<div class="input-group input-group-lg">-->

    <!--<div class="input-group-addon"-->
    <!--id="basic-addon1"-->
    <!--&gt;-->
    <!--{{headingName}}-->


    <!--</div>-->

    <!--<input type="text"-->
    <!--class="form-control input-lg"-->
    <!--id="privateName"-->
    <!--name="privateName"-->
    <!--aria-describedby="basic-addon1"-->
    <!--v-bind:placeholder="placeHolders.privateName"-->
    <!--v-model="privateName"-->
    <!--/>-->

    <!--<div class="input-group-btn">-->
    <!--<settings-button :index="0"></settings-button>-->

    <!--&lt;!&ndash;<button class="btn btn-primary"&ndash;&gt;-->
    <!--&lt;!&ndash;v-on:click="toggleExamProperties"&ndash;&gt;-->
    <!--&lt;!&ndash;&gt;<span class="glyphicon glyphicon-cog"></span></button>&ndash;&gt;-->
    <!--</div>-->

    <!--</div>-->
    <!--</div>-->
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
                headingName: "future dropdown!",
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
                    if ( exam && typeof exam.name !== 'undefined' ) {
                        return exam.name;
                    }
                },
                set: function ( v ) {
                    //store the name in the data object
                    this.$store.commit(mTypes.updateItem, Payload.factory({
                        index: 0,
                        updateProp: 'name',
                        updateVal: v
                    }));
                }
            }
        },


        methods: {

            getExam: function () {
                return this.$store.getters.getItemByIndex(0);
//                return this.$store.getters[ gTypes.getActiveExamObj ];
            },

            /**
             * Requests that the exam properties area display or hide
             */
            toggleExamProperties: function () {
                this.$store.commit(mTypes.toggleExamSettings);
                console.log('toggleExamProperties clicked');
            }
        },

        directives: {},

        events: {},

        mounted: function () {

//            console.log( 'exam-main ready' );
        },
    }

</script>
