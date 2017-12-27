/**
 * Created by adam on 10/7/16.
 */
import Vue from 'vue';
import * as ngmTypes from './new-grading-mutation-types';
import * as ngaTypes from './new-grading-action-types';
import * as nggTypes from './new-grading-getter-types';
import * as gTypes from '../../getter-types';
import * as mTypes from '../../mutation-types';

import Payload from '../../../models/Payload';
import PayloadTime from '../../../models/PayloadTime';
import timeRequests from "../../../api/requests/timeRequests";
import * as lmTypes from "../../legacy-mutation-types";
import * as laTypes from "../../legacy-action-types";




const mutations = {

    /**
     * Sets the value in payload as the new grading time for the student
     * @param state
     * @param payload
     */
    [ ngmTypes.updateStudentGradingTime ]: ( state, payload ) => {
        Vue.set( payload.student, 'gradingTime', payload.time );
    }
};

const actions = {


    /**
     * Increases the stored time for a student by the specified
     * amount.
     * Original: data.this.examGradingTimes[ Roster.activeStudent ];
     * state.examGradingTimes[ state.activeStudentIndex ] += payload.timeToAdd;
     */
    [ ngaTypes.incrementGradingTime ]: ( { state, dispatch, commit, getters }, amount ) => {
        let student = getters[ nggTypes.getActiveStudent ];
        let exam = getters[ nggTypes.getActiveExam ];

        let newTime = amount + student.gradingTime;

        commit( ngmTypes.updateStudentGradingTime, PayloadTime.factory( {
            student: student,
            exam: exam,
            time: newTime
        } ) );
    },

    [ ngaTypes.loadTimesFromServer ]: ( { state, dispatch, commit, getters }, exam ) => {
        let me = this;
        return new Promise( function ( resolve, reject ) {
            // window.console.log( 'itemscores', '', 193, exam, item, student);
            let p = timeRequests.getAllGradingTimes( exam );

            p.then( function ( data ) {
                _.forEach( data, function ( d ) {
                    let student = getters.getStudentFromRosterById( d.student_id );
                    let time = parseFloat( d.seconds );

                    //record the score (this will initialize the object too)
                    commit( mTypes.updateStudentInRoster, Payload.factory( {
                        obj: student,
                        exam: exam,
                        updateProp: 'gradingTime',
                        updateVal: time,
                        mutateSilently: true
                    } ) );

                } );

                resolve();
            } );
        } )
    }
};

const getters = {
    /**
     * Returns the total amount of time spent grading in seconds
     * @returns {number}
     */
    [ nggTypes.getTotalGradingTime ]: ( state, getters, rootState ) => {
        let total = 0;
        let students = getters[ gTypes.getStudentsFromRoster ];
        if ( _.isUndefined( students ) ) return total;
        _.forEach( students, function ( s ) {
            total += s.gradingTime;
        } );
        return total;
    },

    /**
     * Returns the average number of seconds spent grading a student's
     * work
     *
     * @param state
     * @param getters
     * @param rootState
     * @returns {number}
     */
    [ nggTypes.getAverageGradingTime ]: ( state, getters, rootState ) => {
        let storedNum = getters[ nggTypes.getNumberGraded ];
        let totalTime = getters[ nggTypes.getTotalGradingTime ];
        //avoid dividing by 0
        let numGraded = storedNum == 0 ? 1 : storedNum;
        var avgTime = totalTime / numGraded;
        return avgTime;
    },

    /**
     * Returns the estimated number of seconds remaining
     * for grading the whole exam.
     * This is computed from the average time and the number
     * of exams remaining.
     * @param state
     * @param getters
     * @param rootState
     * @returns {number}
     */
    [ nggTypes.getRemainingGradingTime ]: ( state, getters, rootState ) => {
        let remainingExams = getters[ nggTypes.getNumberExamsRemaining ];
        let avgTime = getters[ nggTypes.getAverageGradingTime ];
        let estTime = avgTime * remainingExams;
        return estTime;
    },


};


export default {
    getters,
    actions,
    mutations
}

