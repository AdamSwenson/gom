import * as mTypes from '../../mutation-types'
import * as aTypes from '../../action-types'
import * as gTypes from '../../getter-types'

import Node from "../../../models/Node";
import { getNode } from "../../../models/NodeTools";
import { getItem } from "../../utlities/itemHelpers";

import Payload from '../../../models/Payload'
import Item from '../../../models/Item'
import Exam from '../../../models/Exam'

import {loadExam  } from '../../../api/requests/examRequests';

import {
    readJsonFromPageString
} from '../../utlities/JsonHelpers';


import * as ngmTypes from "../../new-grading-mutation-types";


export default {
    actions: {
        /**
         * Reads the exam data from the data attribute of a page element
         * Options object may contain:
         *      Options.elementIds = { exam : the id of the element the data is located in}
         * Otherwise, it will use the default element id
         *
         * @param state
         * @param commit
         * @param dispatch
         * @param getters
         * @param options
         * @returns {Promise<any>}
         */
        loadExamFromPageJson: ( { state, commit, dispatch, getters }, jsonLocations ) => {
            window.console.log( 'exams.loaders', 'loadExamFromPageJson', 39, );
            return new Promise( function ( resolve, reject ) {

                //Read the data from the page element and parse it into an object
                let examJson = readJsonFromPageString( jsonLocations.exam );
                window.console.log( 'exams.loaders', '', 43, examJson);
                dispatch( 'processAndStoreLoadedExam', examJson )
                    .then( function ( exam ) {
                        //Once we're done loading the exam
                        //we set it as the current exam
                        let pl = Payload.factory( { obj: exam, mutateSilently: true } );
                        commit( mTypes.setActiveExam, pl );
                        commit( ngmTypes.setActiveExam, pl );

                        window.console.log( 'exams.loaders', 'loadExamFromPageJson', 40, 'done');

                        resolve();
                    } );
            } );

        },

        /**
         * Loads the exam object for the given id from the server,
         * sets it as root and as active
         * @param state
         * @param dispatch
         * @param commit
         * @param getters
         * @param examId
         * @returns {Promise<any>}
         */
        loadExamFromServer: ( { state, dispatch, commit, getters }, examId ) => {
            return new Promise( function ( resolve, reject ) {
                loadExam( examId )
                    .then( function ( data ) {
                        dispatch( 'processAndStoreLoadedExam', data )
                            .then( function ( exam ) {
                                //Once we're done loading the exam
                                //we set it as the current exam
                                let pl = Payload.factory( { obj: exam, mutateSilently: true } );
                                commit( mTypes.setActiveExam, pl );
                                commit( ngmTypes.setActiveExam, pl );

                                resolve();
                            } );
                    } );
            } );
        },

        /**
         * Once we have an object that has been parsed from the json
         * provided by the server or read from the page, this handles
         * creating an exam object from that data and adding it to the
         * store. It also initializes item storage on the exam.
         *
         * This does not set the exam as active (since we might want to
         * use this action to load other exams in the background). However,
         * it does return the created exam upon resolution. That allows
         * a calling process to handle setting it as active once it has been
         * created.
         *
         * @param state
         * @param dispatch
         * @param commit
         * @param getters
         * @param examDataObj
         * @returns {Promise<any>}
         */
        processAndStoreLoadedExam: ( { state, dispatch, commit, getters }, examDataObj ) => {
            return new Promise( function ( resolve, reject ) {
                let exam = Exam.factory( examDataObj );

                let pl = Payload.factory( {
                    obj: exam,
                    mutateSilently: true
                } );
                //First we save it in the exams list
                commit( mTypes.addExam, pl );
                //Now that we have the exam loaded,
                // we need to do some stuff with it.
                // NB, since these call mutations, they happen
                // synchronously, thus no need to wrap in promises
                // First, we initialize the item store (which holds the
                // order of the items) with the exam
                commit( mTypes.initializeItemStorage, pl );

                resolve( exam );
            } );
        }
    }
};

