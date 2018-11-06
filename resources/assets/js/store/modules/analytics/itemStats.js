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

import Item from '../../../models/Item';
import { getItemScoreSummaryForExam } from "../../../api/requests/statsRequests";


import {
    processItemObjectsFromJson,
    readJsonFromPageString
} from '../../utlities/JsonHelpers';


export function lookupStats( state, item ) {
    return (function ( state, item ) {
        var r = state.itemStats.filter( function ( i ) {
            if ( i.item.id === item.id ) {
                return i;
            }
        } );
        return r[ 0 ];
    })( state, item )
}


let loadFromPage = ( commit, exam, item, location = 'itemStats' ) => {
    // return new Promise( function ( resolve, reject ) {

    let statsJson = readJsonFromPageString( location );
    window.console.log( 'itemStats', 'statsjson', 40, statsJson );
    if ( _.isUndefined( statsJson ) || statsJson.length == 0 ) {
        return false;
        // reject( false );
    }

    let data = statsJson[ item.id ]
    if ( _.isUndefined( data ) ) {
        return false;
        // return reject(false);
    }
    window.console.log( 'itemStats', 'loadItemScoreSummaryForExamFromPageJson', 101, item.id, data );

    let e = ItemStat.factory( data );
    e.exam = exam;
    e.item = item;
    let pl = Payload.factory( { obj: e, mutateSilently: true } );
    commit( 'addItemStats', pl );
    // return resolve( true );
    return true;

    // } );
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
        let { exam, item } = payload;

        return new Promise( function ( resolve, reject ) {
            // window.console.log( 'itemscores', '', 193, exam, item, student);

            // let p1 = loadFromPage( commit, exam, item );
            // if ( p1 ) {
            //     //loaded successfully from page
            //     return resolve();
            // } else {
            // return p1.then( function () {
            //
            // // } ).catch( function () {
            // window.console.log( 'itemStats', 'caught', 102, item.id);
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
    },

    /**
     * Asks the server for stats for the item on the given exam
     * @param state
     * @param dispatch
     * @param commit
     * @param getters
     * @param payload
     * @returns {Promise<any>}
     */
    loadItemScoreSummaryForExamFromPageJson: ( { state, dispatch, commit, getters } ) => {
        let me = this;
        let location = 'itemStats';
        let exam = getters[ gTypes.getActiveExam ];

        return new Promise( function ( resolve, reject ) {

            let statsJson = readJsonFromPageString( location );

            _.forEach( statsJson, function ( v, k ) {

                let e = ItemStat.factory( v );
                e.exam = exam;
                e.item = Item.factory( { id: Number(k) } );
                let pl = Payload.factory( { obj: e, mutateSilently: true } );
                commit( 'addItemStats', pl );

            } );
            resolve();
        } );
        // } );
    },

    // processAndStoreLoadedStats: ({state, dispatch, commit, getters}, exam, item)=>{
    //
    //     return new Promise(function(resolve, reject)){
    //
    //     } p.then( function ( data ) {
    //         let e = ItemStat.factory( data );
    //         e.exam = exam;
    //         e.item = item;
    //         let pl = Payload.factory( { obj: e, mutateSilently: true } );
    //         commit( 'addItemStats', pl );
    //         resolve();
    //     } );
    // }
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