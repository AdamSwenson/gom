/**
 * Root getters for the vuex instance
 *
 * Methods which make use of multiple modules should generally be kept here
 */
import * as gTypes from './getter-types'

module.exports = {

    /**
     * Helper function used by getters which tests for an index value and then
     * handles undefined and  null inputs when they were expecting
     * a numeric index.
     */
    validateIndex: ( index ) => {
        let handleInvalid = () => {
            return '';
        };

        if ( typeof index == 'undefined' ) return handleInvalid();
        if ( index === null ) return handleInvalid();

        return true;
    },

    /**
     * Returns true if some student is set as active.
     * Saves the trouble of other methods having to figure out whether a student
     * is set as active student (which can run into trouble if, for example, the
     * active student has index 0 and the consuming method interprets this as false).
     */
    isActive: ( state ) => {
        if ( typeof state.activeStudent == 'undefined' ) return false;
        if ( state.activeStudent === null ) return false;
        if ( state.activeStudent.index >= 0 ) {
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
    getNumberGraded: ( state ) => {
        let graded = 0;
        if ( typeof state.examGrades != 'undefined' ) {
            if ( Object.keys( state.examGrades ).length > 0 ) {
                //Loop through each exam (via studentIndex as key)
                for (let i = 0; i < Object.keys( state.examGrades ).length; i++) {
                    //Make sure the stored exam total score is up to date
                    state.updateExamGrade( i );
                    //this will be the string 'letter grade' if
                    //no grade has been entered. Thus we check
                    //whether it is a number 0 or greater
                    //if it is graded, increment the number graded
                    if ( state.examGrades[ i ] >= 0 ) graded++;
                }
            }
        }
        return graded;
    },


    /**
     * Returns the total number of exams
     *
     * @returns {number|Number}
     */
    getTotalExams: ( state ) => {
        let total = 0;

        if ( typeof state.examGrades != 'undefined' ) {
            if ( Object.keys( state.examGrades ).length > 0 ) {
                total = Object.keys( state.examGrades ).length;
            }
        }
        return total;
    },

//------------ from qscores

    /**
     * Convenience function for getting the current student's score for question
     * Old way: data.this.questionScores[ Roster.activeStudent ][ index ];
     *  if ( state.activeStudentIndex == null ) return '';
     *  return state.getQuestionScore( this.activeStudentIndex, questionIndex );
     * @param questionIndex
     */
    getQuestionScoreForActiveStudent: ( state, getters, rootState, questionIndex ) => {
        if ( typeof state.activeStudent == 'undefined' ) return false;

        let idx = getters.getActiveStudentIndex( state, getters, rootState );
        if ( idx == null ) return '';
        return getters.getQuestionScore( state, getters, rootState, idx, questionIndex );
        // if ( ! this.isActive() ) throw "ERROR: getQuestionScoreForActiveStudent | No active student set ";
    },
// --------------- from times

    /**
     * Convenience method for getting the grading time of the student presently
     * being graded
     * if ( state.activeStudentIndex == null ) return '';
     * return state.examGradingTimes[ state.activeStudentIndex ];
     * return getters.getStudentGradingTime( state, getters, state.activeStudentIndex );
     * @returns {*}
     */
    getActiveStudentGradingTime: ( state, getters, rootState ) => {
        if ( typeof state.activeStudent == 'undefined' ) return false;

        let idx = getters.getActiveStudentIndex( state, getters, rootState );
        if ( idx == null ) return '';
        return getters.getStudentGradingTime( state, getters, idx );
        // if ( ! this.isActive() ) throw "ERROR: getActiveStudentGradingTime | No active student set ";
    },

//--------------- comments

    /**
     * Gets the comment text for the student
     * @param state
     * @param getters
     * @param rootState
     * @param elementIndex
     * @param valence
     * @returns {*}
     */
    getCommentTextForActiveStudent: ( state, getters, rootState, elementIndex, valence ) => {
        if ( typeof state.activeStudent == 'undefined' ) return false;

        //If no student is set, the comment field should be blank
        let idx = getters.getActiveStudentIndex( state, getters, rootState );
        validateIndex( idx );
//    if ( idx == null ) return '';

        return getters.getCommentText( state, getters, rootState, idx, elementIndex, valence );
    },

//------------------ grades
    /**
     * Retrieves exam grade for current student
     * if ( state.activeStudentIndex == null ) return '';
     * return state.examGrades[ state.activeStudent ];
     * @param state
     * @param getters
     * @param rootState
     * @returns {*}
     */
    getExamGradeForActiveStudent: ( state, getters, rootState ) => {
        if ( typeof state.activeStudent == 'undefined' ) return false;

        let idx = getters.getActiveStudentIndex( state, getters, rootState );
        validateIndex( idx );
        // if ( idx == null ) return '';
        return getters.getExamGrade( state, getters, rootState, idx );
    },

//------------ escores
    getElementScoreForActiveStudent: ( state, getters, rootState, elementIndex ) => {
        if ( typeof state.activeStudent == 'undefined' ) return false;

        let idx = getters.getActiveStudentIndex( state, getters, rootState );
        validateIndex( idx );
        // if ( idx == null ) return '';
        return getters.getElementScore( state, getters, rootState, idx, elementIndex );//state.elementScores[state.activeStudentIndex][elementIndex];
    }


};
