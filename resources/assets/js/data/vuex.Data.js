/**
 * Created by adam on 10/7/16.
 */
import Vue from 'vue'
import Vuex from 'vuex'

Vue.use( Vuex );

// (function () {

    const store = new Vuex.Store( {

        modules: {
            activeStudent: require( './vuex.active' ),
            comments: require( './vuex.comments' ),
            elementScores: require( './vuex.escores' ),
            grades: require( './vuex.grades' ),
            questionScores: require( './vuex.qscores' ),
            questions: require( './vuex.questions' ),
            students: require( './vuex.students' ),
            times: require( './vuex.times' )
        },

        state: {
            examId: null,

            /**
             * Boolean of whether the student names are hidden.
             * true means that student names are hidden.
             */
            isBlind: false,

            standardScoring: false,

            /** Standard valences */
            valences: [ 0, 1, 2, 3 ],

        },
        mutations: {
            setExamId( state, examIdToSet ) {
                state.examId = examIdToSet;
                window.console.log( 'setExamId', state );
            }

        },
//     store.commit({
//     type: 'increment',
//     amount: 10
// })
        getters: {

            getExamId( state ) {
                return state.examId;
            },


            /**
             * Returns true if some student is set as active.
             * Saves the trouble of other methods having to figure out whether a student
             * is set as active student (which can run into trouble if, for example, the
             * active student has index 0 and the consuming method interprets this as false).
             */
            isActive( state ) {
                if ( typeof state.activeStudentIndex == 'undefined' ) return false;
                if ( state.activeStudentIndex === null ) return false;
                if ( state.activeStudentIndex >= 0 ) {
                    return true;
                }
                return false;
            },

            /**
             * Returns true if at least one question has received
             * a score for the student.
             */
            isGraded( state, studentIndex ) {
                state.updateExamGrade( studentIndex )
                if ( state.examGrades[ studentIndex ] != "Letter grade" && state.examGrades[ studentIndex ] >= 0 ) {
                    return true;
                }
                return false;
            },


            /**
             * Returns the number of exams that have been graded.
             * NB, before counting them it first goes through and makes
             * sure that each examGrade is set to the sum of graded questions
             * for that exam.
             */
            getNumberGraded( state ) {
                var graded = 0;

                if ( Object.keys( state.examGrades ).length > 0 ) {
                    //Loop through each exam (via studentIndex as key)
                    for ( var i = 0; i < Object.keys( state.examGrades ).length; i ++ ) {
                        //Make sure the stored exam total score is up to date
                        state.updateExamGrade( i );
                        //this will be the string 'letter grade' if
                        //no grade has been entered. Thus we check
                        //whether it is a number 0 or greater
                        //if it is graded, increment the number graded
                        if ( state.examGrades[ i ] >= 0 ) graded ++;
                    }
                }
                return graded;
            },


            /**
             * Returns the total number of exams
             *
             * TODO Store this value after first run
             *
             * @returns {number|Number}
             */
            getTotalExams( state ) {
                //memoize
                // if(this.getTotalExams.total && this.getTotalExams.total >= 0) return this.getTotalExams.total;

                //initialize
                let total = 0;
                if ( Object.keys( state.examGrades ).length > 0 ) {
                    total = Object.keys( state.examGrades ).length;
                }

                return total;
            },


            /* ------------ Utilities --------------*/

            /**
             * Checks to make sure that a property has had its
             * values loaded before trying to do stuff with it
             *
             * @param propertyName
             */
            checkValid( state, propertyName ) {
                if ( typeof state[ propertyName ] != 'undefined' ) {
                    throw propertyName + " is undefined";
                }
                if ( state[ propertyName ] == null ) {
                    throw propertyName + " is null";
                }
                if ( state[ propertyName ] == {} ) {
                    throw propertyName + " was empty. Probably because it wasn't initialized";
                }

                return true;
            },


        }
    } );

    document.body.Data = store;

    window.console.log( 'jjjjj' );

    (function () {
        window.console.log( 'kkkkkk' );
        //window.console.log( Data );
    })();

    const app = new Vue({
        el: '#app',
        // provide the store using the "store" option.
        // this will inject the store instance to all child components.
        store,

        template: `<div class="app">jip</div>`,
        onload: function ( )  {
            window.console.log('jj fffff');
            window.console.log(app);

        }
    });

// })();