<template>

    <a class="add-student-button button "
       v-bind:class="styling"
       v-on:click="addStudent"
    >
        {{buttonLabel}}
    </a>


</template>

<style lang="scss">

</style>

<script>
    import Payload from '../../../../../models/Payload';
    import Student from '../../../../../models/Student';
    import Kumi from '../../../../../models/Kumi';
    import * as mTypes from '../../../../../store/mutation-types';
    import * as aTypes from '../../../../../store/action-types';
    import * as gTypes from '../../../../../store/getter-types';


    export default {

        data: function () {
            return {
                buttonLabel: 'New student',

                buttonStyles: "is-primary is-outlined ",

                helpText: '',

                events: {
                    addStudentCalled: 'addStudentCalled',
                    addStudentComplete: 'addStudentComplete'
                },


                defaults: {}
            }
        },

        computed: {
            styling: function () {
                return this.buttonStyles;
            }
        },

        methods: {


            addStudent: function () {
                let me = this;
                me.notifyStart();
                let p = new Promise( function ( resolve, reject ) {
                    window.console.log( 'students-panel', 'addStudent', 190, );
                    //create a new student, which will add an empty row
                    let s = new Student();
                    //Push the student into local storage and create
                    //a new student on the server.
                    //This also will associate with the currently selected
                    //kumi
                    let pl = Payload.factory( { obj: s, student: s } );
                    me.$store.dispatch( aTypes.handleNewStudentStorageAndAssociation, pl )
                        .then( function () {
                        resolve();
                    } );

                } );

                //Handle tasks once all the above is done
                p.then( function () {
                    me.notifyComplete();
                } );

                //Handle any errors
                p.catch( function () {
                    //todo
                } );
            },

            notifyComplete: function () {
                return this.$emit( this.events.addStudentComplete );
            },

            notifyStart: function () {
                return this.$emit( this.events.addStudentCalled );
            }

        },

    }
</script>