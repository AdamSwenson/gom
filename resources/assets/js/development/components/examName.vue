<template>
    <div id="examNameArea">

        <div class="input-group">
            <span class="input-group-addon" id="basic-addon1">{{ displayType }} Name</span>
            <input type="text"
                   class="form-control input-lg"
                   id="privateName"
                   name="privateName"
                   aria-describedby="basic-addon1"
                   placeholder="{{ placeHolders.privateName }}"
                   v-model="privateName"
            >
            <span class="input-group-addon"
                  id="basic-addon2">
                <span
                        v-on:click="openExamProperties"
                        class="glyphicon glyphicon-cog"
                ></span>
            </span>
        </div>


    </div>
</template>

<style>
    body {
        background-color: #ff0000;
    }

</style>

<script>

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
                    this.$store.getters.getActiveExamObj().name;
                    //if not set return placeholder
                    // return this.placeHolders.privateName;
                },
                set: function () {
                    let exam = this.$store.getters.getActiveExamObj();
                    //store the name in the data object

                    this.$store.dispatch(aTypes.updateExam, Payload({ obj: exam } ));


                },
            },

            /**
             * The kind of thing being graded. This is the
             * name that display at the top before the word 'Name'
             */
            displayType: function () {
                //todo check prop and then use the following as default
                return this.defaults.type;
            }
        },

        methods: {
            /**
             * Requests that the exam properties area display
             */
            openExamProperties: function () {
                this.$store.dispatch('toggle-exam-properties')
                //Todo add event broadcast
                console.log( 'openExamProperties clicked' );
            }
        },

        directives: {},

        events: {},

        ready: function () {
            console.log( 'exam-name ready' );
        },
    }

</script>
