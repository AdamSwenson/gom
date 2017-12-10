/**
 * Created by adam on 10/7/16.
 */
import * as mTypes from './new-grading-mutation-types';
import * as aTypes from './new-grading-action-types';
import Payload from '../../models/Payload'


const state = {
    /**
     * Key-value store of grading times .
     *
     * Each record has the studentIndex as the key and
     * the gradingTime as the value.
     * That is:
     *     { studentIndex : gradingTime, }
     * Or, if you prefer
     *      examGradingTimes[ studentIndex] = gradingTime
     */
    examGradingTimes: {},
};


const mutations = {
    /**
     * Set stored time for student.
     * Overwrites any existing stored time.
     * @param examGradingTimes JSON object
     */
    [mTypes.setGradingTime]: ( state, payload ) => {
        Payload.checkIfPayload( payload );
        state.examGradingTimes[ payload.index ] = payload.num;
    },

    /**
     * Increases the stored time for the student by the specified amount
     * @param state
     * @param payload.studentIndex
     * @param payload.timeToAdd
     */
    [mTypes.incrementGradingTime]: ( state, payload ) => {
        Payload.checkIfPayload( payload );
        state.examGradingTimes[ payload.index ] += payload.num;
    },

    /**
     * Removes a grading time data object
     *
     * @param examGradingTimes JSON object
     */
    [ mTypes.removeGradingTime ]: ( state, payload ) => {
        Payload.checkIfPayload( payload );

        let idx = -1;
        if ( payload instanceof Payload ) {
            idx = payload.index;
        }

        if ( idx > -1 ) {
            delete state.examGradingTimes[ idx ];
            // state.examGradingTimes.splice( idx, 1 );
        }
    },

    /**
     * Sets the grading time for a student index to 0
     */
    [ mTypes.resetGradingTime ]: ( state, payload ) => {
        Payload.checkIfPayload( payload );
        state.examGradingTimes[ payload.index ] = 0;
    }
};

const actions = {

    /**
     * Sets the grading time data from the server
     * @param examGradingTimes JSON object
     */
    [aTypes.loadGradingTimes]: ( {state, commit}, payload ) => {
        if ( payload.length > 1 ) {
            for ( let i = 0; i < payload.length; i++ ) {
                actions[ aTypes.storeGradingTime ]( state, commit, payload );
            }
        }
    },


    /**
     * Todo Add ability to look up by student index or student id
     * TODO Add handling for an unset index
     * Stores a new time for the student.
     * Overwrites any existing value.
     * Original: data.this.examGradingTimes[ Roster.activeStudent ];
     */
    [aTypes.storeGradingTime]: ( {state, commit}, payload ) => {
        //type checking
        if ( typeof(payload.studentIndex) != 'undefined' && typeof(payload.timeToAdd) != 'undefined' ) {

            //todo add sanitation and checks
            let studentIndex = payload.studentIndex;
            let timeToAdd = payload.timeToAdd;

            //add processing from other allowed input configs


            let pl = Payload.factory( {index: studentIndex, num: timeToAdd} );
            commit( mTypes.setGradingTime, pl );
        }
    },


    /**
     * Increases the stored time for a student by the specified
     * amount.
     * Original: data.this.examGradingTimes[ Roster.activeStudent ];
     * state.examGradingTimes[ state.activeStudentIndex ] += payload.timeToAdd;
     */
    [aTypes.incrementGradingTime]: ( {state, commit}, payload ) => {

        let pl = Payload.factory(
            {
                index: payload.studentIndex,
                num: payload.timeToAdd
            } );

        commit( mTypes.incrementGradingTime, pl );
    },

};

const getters = {
    /**
     * Returns the total amount of time spent grading in seconds
     * @returns {number}
     */
    getTotalGradingTime: ( state, getters ) => {
        var totalTime = 0;
        for ( var i = 0; i < Object.keys( state.examGradingTimes ).length; i++ ) {
            totalTime += state.examGradingTimes[ i ];
        }
        return totalTime;
    },

    /**
     * Original: data.this.examGradingTimes[ Roster.activeStudent ]
     * @param activeStudent
     * @returns {*}
     */
    getStudentGradingTime: ( state, getters, studentIndex ) => {
        return state.examGradingTimes[ studentIndex ];
    },

};


export default {
    state,
    getters,
    actions,
    mutations
}

