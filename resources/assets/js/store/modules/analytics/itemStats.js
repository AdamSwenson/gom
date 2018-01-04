/**
 * This handles summary statistics for individual items
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
import { getItemScoreSummaryForExam } from "../../../api/requests/statsRequests";

export function lookupStats( state, item ) {
    return (function ( state, item ) {
        var r = state.itemStats.filter( function ( i ) {
            if ( i.item.id === item.id ) {
                return i;
            }
        } );
        return r[0];
    })( state, item )
}

const state = {
    itemStats: []
};

const mutations = {


    addItemStats: ( state, payload ) => {
        let idx = state.itemStats.indexOf( payload.obj );
        if ( idx > -1 ) {
            //remove the old object and push in the new
            state.itemStats.splice( idx, 1, payload.obj );

        } else {
            state.itemStats.push( payload.obj );
        }
    }
};

const actions = {
    /**
     * Asks the server for stats for the item on the given exam
     * @param state
     * @param dispatch
     * @param commit
     * @param getters
     * @param payload
     * @returns {Promise<any>}
     */
    loadItemScoreSummaryForExam: ( { state, dispatch, commit, getters }, payload ) => {
        let me = this;
        let {exam, item } = payload;

        return new Promise( function ( resolve, reject ) {
            // window.console.log( 'itemscores', '', 193, exam, item, student);

            let p = getItemScoreSummaryForExam( exam, item );

            return p.then( function ( data ) {
                let e = ItemStat.factory( data );
                e.exam = exam;
                e.item = item;
                let pl = Payload.factory( { obj: e, mutateSilently: true } );
                commit( 'addItemStats', pl );
                resolve();
            } );
        } );
    }
};

const getters = {


    /**
     * Returns an itemStat object for
     * the given item on the given exam
     * @param state
     * @param getters
     * @param rootState
     * @param pl
     * @returns {function(*)}
     */
    getItemStatsForExam: ( state, getters, rootState, pl ) =>
        ( pl ) => {
            let { exam, item } = pl;

            let s = lookupStats( state, item );
            return s;
        },


};


export default {
    actions,
    getters,
    mutations,
    state,
}