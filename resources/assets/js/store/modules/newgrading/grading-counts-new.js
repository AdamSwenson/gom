/**
 * Created by adam on 11/30/17.
 */

/**
 * This handles getting calculated information
 * about how many students or completed exams
 * need to be graded and how many have been graded
 */

import * as ngmTypes from './new-grading-mutation-types'
import * as ngaTypes from './new-grading-action-types'
import * as nggTypes from './new-grading-getter-types';
import * as gTypes from '../../getter-types';

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


export default {
    getters
}