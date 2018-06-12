/**
 *
 * This handles getting calculated information
 * about how many students or completed exams
 * need to be graded and how many have been graded
 *
 * Created by adam on 11/30/17.

 */

import * as mTypes from '../../mutation-types'

import * as ngmTypes from '../../new-grading-mutation-types';
import * as ngaTypes from '../../new-grading-action-types';
import * as nggTypes from '../../new-grading-getter-types';
import * as gTypes from '../../getter-types';

import progressRequests from '../../../api/requests/progressRequests';

import Payload from '../../../models/Payload';

/*
NB
The exam counts component  used in the grading page calculates everything from
loaded data (e.g., roster).

The component which contains this on the setup page loads it via a request to the server.
Thus the getters and actions are not currently for the same components. It may be
a good idea to combine them in the future.
 */

const getters = {

    [ nggTypes.getTotalExams ]: ( state, getters, rootState ) => {
        let s = getters[ gTypes.getStudentsFromRoster ];
        if ( !_.isUndefined( s ) ) return s.length;
//        return getters[ gTypes.getStudentCount ];
    },

    [ nggTypes.getNumberGraded ]: ( state, getters, rootState ) => {
        let allScores = getters[ nggTypes.getAllItemScores ];
        let validScores = [];
        _.forEach( allScores, function ( score ) {
            //if the score is defined and non null
            if ( !_.isUndefined( score.score ) && !_.isNull( score.score ) ) validScores.push( score );
        } );
        //we consider an exam graded if there is at least one score
        let uniqueStudents = _.uniqBy( validScores, 'studentId' );
        return uniqueStudents.length;
    },

    /**
     * Number of exams remaining to be graded
     */
    [ nggTypes.getNumberExamsRemaining ]: ( state, getters, rootState ) => {
        //try{
        let totalExams = getters[ nggTypes.getTotalExams ];
        let gradedExams = getters[ nggTypes.getNumberGraded ];
        let remaining = totalExams - gradedExams;
        return remaining;
        // } catch (err) {
        //     return '';
        // }
    },

};

/**
 *
 * @type {{}}
 */
const actions = {

    /**
     * This gets the number of exams that have been graded and the number needing grading
     * from the server. It then stores those values on the exam object.
     * @param state
     * @param dispatch
     * @param commit
     * @param getters
     * @param exam
     * @returns {Promise<any>}
     */
    [ngaTypes.loadGradingProgress] : ( { state, dispatch, commit, getters }, exam  ) => {
        return new Promise( function ( resolve, reject ) {
            window.console.log( 'grading-progress', 'jjj', 83, );

            //request the data from the server
            let p = progressRequests.getGradingProgressForExam( exam );

            p.then( function ( data ) {

                window.console.log( 'number-graded', 'res', 113, data );
                let pl = Payload.factory( {
                    mutateSilently: true,
                    obj: exam,
                    updateProp: 'numberStudents',
                    updateVal: _.toInteger( data.numStudents )
                } );

                //store the number of students on the exam
                commit( mTypes.updateItem, pl );

                //store the number of graded exams on the exam
                pl.updateProp = 'numberGraded';
                pl.updateVal = _.toInteger( data.numGraded );
                commit( mTypes.updateItem, pl );

                resolve();
            } );
        } );

    }
};


export default {
    getters, actions
}