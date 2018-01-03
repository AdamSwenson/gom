/**
 * This is for storing data used in displaying statistics
 * It may or may not end up also being used in actual grading....
 *
 * Created by adam on 7/16/17.
 */

import Vue from 'vue'
import * as mTypes from '../../mutation-types'
import * as aTypes from '../../action-types'
import * as gTypes from '../../getter-types';

import Payload from '../../../models/Payload'
import Kumi from '../../../models/Kumi';
import ItemStat from '../../../models/ItemStat';

/**
 * An item score without student info
 */
class Stat {
    constructor( exam, item, score, kumiIds = [] ) {
        this.exam = exam;
        this.examId = exam.id;

        this.item = item;
        this.itemId = item.id;
        this.id = item.id; //alias

        this.kumiIds = [];

        this.score = score;

        this.mean;
        this.standardDeviation;
        this.minScore;
        this.maxScore;
        this.median;

    }
}


const state = {
    stats: [],
    summaryStats: []
};

const mutations = {

    /**
     * Replaces the stored stats array with the payload
     * @param state
     * @param payload
     */
    overwriteStats: ( state, payload ) => {
        state.stats = payload.obj;
    }
};

const actions = {

    processScoreForStatsResponse: ( { state, dispatch, commit, getters }, axiosResponse ) => {
        // window.console.log( 'scoresForStats', 'processAxiosResponse', 48, axiosResponse );
        return new Promise( function ( resolve ) {
            let stats = [];
            if ( !_.isUndefined( axiosResponse.data ) && axiosResponse.data.length > 0 ) {
                _.forEach( axiosResponse.data, function ( r ) {
                    let kumiIds = r.kumis.forEach( function ( k ) {
                        return k.id;
                    } );
                    //Lets get the actual objects
                    //to make it easier to display labels and data
                    // window.console.log( 'scoresForStats', 'getters', 65, getters);
                    let exam = getters.getExam( r ); //looks up by examId
                    let item = getters.getItemById( r.itemId );

                    let s = new Stat( exam, item, r.score, kumiIds );
                    stats.push( s );
                } )
                commit( 'overwriteStats', Payload.factory( { obj: stats, mutateSilently: true } ) );
            }
        } );

    },


    processSummaryResponse: ( { state, dispatch, commit, getters }, axiosResponse ) => {
        // window.console.log( 'scoresForStats', 'processAxiosResponse', 48, axiosResponse );
        return new Promise( function ( resolve ) {
            let stats = [];
            if ( !_.isUndefined( axiosResponse.data ) && axiosResponse.data.length > 0 ) {
                _.forEach( axiosResponse.data, function ( r ) {
                    let kumiIds = r.kumis.forEach( function ( k ) {
                        return k.id;
                    } );
                    //Lets get the actual objects
                    //to make it easier to display labels and data
                    // window.console.log( 'scoresForStats', 'getters', 65, getters);
                    let item = getters.getItemById( r.itemId );

                    let s = new Stat( exam, item, r.score, kumiIds )
                    stats.push( s );
                } )
                commit( 'overwriteStats', Payload.factory( { obj: stats, mutateSilently: true } ) );
            }
        } );

    }


};

const getters = {




    /**
     * Returns the item scores without identifying student information
     * for the item
     * @param state
     * @param getters
     * @param rootState
     * @param item
     * @returns {function(*=)}
     */
    getAnonScoresForItemStats: ( state, getters, rootState, item ) =>
        ( item ) => {
            // window.console.log( 'scoresForStats', 'getStatsForitem', 70, item, state);

            return (function ( state, item ) {
                var r = state.stats.filter( function ( i ) {
                    if ( i.id === item.id ) {
                        return i;
                    }
                } );
                return r;
            })( state, item )
        },


};


export default {
    actions,
    getters,
    mutations,
    state,
}