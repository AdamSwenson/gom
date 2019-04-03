/**
 * Created by adam on 12/9/17.
 */

/**
 *
 * NB this is stored separately from the score data
 * because this needs to have the student id so that
 * we can revisit their exam
 *
 */

import IModel from '../../../models/IModel';
import Payload from '../../../models/Payload';


import Vue from 'vue'
import * as mTypes from '../../mutation-types'
import * as aTypes from '../../action-types'
import * as gTypes from '../../getter-types';

import Kumi from '../../../models/Kumi'

import { getQCData } from '../../../api/requests/qualityRequests';

class QCDatum extends IModel {

    constructor() {
        super();

        this.examId;

        this.studentId;

        this.kumiIds = [];

        this.totalScore;

        this.gradingTime;

        this.gradedDatetime;

        this.gradedOrder;
    }

    /**
     * Returns a list of strings which are property
     * names. These fields can be filled from the input
     * @returns {[string,string]}
     */
    static get fillableProps() {
        return [
            'examId',
            'kumiIds',
            'totalScore',
            'gradingTime',
            'gradedDatetime',
            'gradedOrder',
            'studentId'

        ].concat( super.fillableProps );
    };

    static factory( params ) {
        let obj = new QCDatum();
        return this.fillObject( obj, params, {} );
    }

}


const state = {

    quality: []
};

const mutations = {
    overwriteQuality: ( state, payload ) => {
        state.quality = payload.obj;
    }

};

const actions = {
    /**
     * This makes the request to the server and then
     * loads the data into state.quality
     *
     * @param state
     * @param dispatch
     * @param commit
     * @param getters
     * @param exam
     * @returns {Promise<any>}
     */
    loadQCDataFromServer: ( { state, dispatch, commit, getters }, exam ) => {
        return new Promise( function ( resolve, reject ) {
            let p = getQCData( exam );
            p.then( function ( data ) {
                window.console.log( 'quality', 'loadQC', 100, data);
                let processed = [];
                _.forEach( data, function ( d ) {
                    processed.push( QCDatum.factory( { ...d } ) );
                } );
                commit( 'overwriteQuality', Payload.factory( { obj: processed , mutateSilently: true} ) );
                resolve(getters.getByGradedOrder);
            } )
        } );
    }

    // loadQCDataFromServer: ( { state, dispatch, commit, getters }, data ) => {
    //     return new Promise( function ( resolve, reject ) {
    //
    //
    //         let processed = [];
    //         _.forEach( data, function ( d ) {
    //             processed.push( QCDatum.factory( { ...d } ) );
    //         } );
    //         commit( 'overwriteQuality', Payload.factory( { obj: processed } ) );
    //         resolve();
    //     } );
    // }
};

const getters = {
    getByGradedOrder: function ( state ) {
        return state.quality;
    },
};


export default {
    actions,
    getters,
    mutations,
    state,
}