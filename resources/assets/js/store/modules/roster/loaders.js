import Student from "../../../models/Student";
import Payload from "../../../models/Payload";
import * as mTypes from "../../mutation-types";

import { loadStudentsForExam } from "../../../api/requests/studentRequests";
import Kumi from "../../../models/Kumi";
import { loadKumiForExam } from "../../../api/requests/kumiRequests";
import {
    readJsonFromPageString
} from '../../utlities/JsonHelpers';


module.exports = {
    actions: {
        /**
         * Process the result of a response where we need to
         * insert new students into store
         * @param store
         * @param response
         * @returns {Promise}
         */
        loadStudentsFromServer( { state, dispatch, commit, getters }, exam ) {
            return new Promise( function ( resolve, reject ) {

                let p = loadStudentsForExam( exam );
                p.then( function ( data ) {
                    dispatch( 'processAndStoreLoadedStudents', data ).then( function () {
                        resolve();
                    } );
                } );
            } );
        },

        loadStudentsFromPageJson( { state, dispatch, commit, getters }, jsonLocations ) {
            return new Promise( function ( resolve, reject ) {
                let studentsData = readJsonFromPageString( jsonLocations.students );
                //if we are on the feedback page, this will only have
                //given us a student, not an array containing students as the
                //next action expects. So, we wrap it in an array if needed
                if( ! _.isArray(studentsData)) studentsData = [studentsData];

                dispatch( 'processAndStoreLoadedStudents', studentsData )
                    .then( function () {
                        window.console.log( 'loaders', 'student data load done', 44, );
                    resolve();
                } );
            } );
        },

        processAndStoreLoadedStudents: ( { state, dispatch, commit, getters }, data ) => {
            return new Promise( function ( resolve, reject ) {
                _.forEach( data, function ( r ) {
                    // window.console.log( 'studentRequests', 'r', 29, r );
                    let student = Student.factory( r );

                    let payload = Payload.factory( { obj: student, mutateSilently: true } );
                    commit( mTypes.addStudentToRoster, payload );

                    if ( r.kumiIds ) {
                        _.forEach( r.kumiIds, function ( id ) {
                            //if the server sent us the id of the associated kumi
                            //we are going to look up the client side representation
                            //and then store it in the student object.
                            //NB, there might not be a kumi id for any number of reasons,
                            //including that an existing student is being newly associated with
                            //a kumi.
                            //Remember also that kumis are just groups now
                            let kumi = getters.getKumiById( id );

                            if ( !_.isUndefined( kumi ) ) {

                                //if a kumi object doesn't exist yet with this id
                                //figure out what the fuck to do.....
                                //This is probably because the kumi is not associated with the exam.

                                //Otherwise we are good, so call the mutation
                                // this will both add the kumi to the student
                                //and store the relationship centrally
                                payload.student = student;
                                payload.kumi = kumi;
                                commit( mTypes.associateStudentWithKumi, payload )

                                //actually the current problem is that we're not properly
                                //disassociating the kumi and student

                            }
                        } );
                    }
                } );
                resolve();
            } );
        },

        /**
         * Requests all kumis for the exam
         * then adds them to the kumi store by calling addKumi
         * on each object returned;
         * @param state
         * @param dispatch
         * @param commit
         * @param getters
         * @param exam
         * @returns {Promise<any>}
         */
        loadKumisForExamFromServer( { state, dispatch, commit, getters }, exam ) {
            return new Promise( function ( resolve, reject ) {
                let p = loadKumiForExam( exam );
                return p.then( function ( data ) {
                    _.forEach( data, ( d ) => {
                        let k = Kumi.factory( d );
                        let pl = Payload.factory( {
                            obj: k,
                            mutateSilently: true
                        } );

                        commit( mTypes.addKumi, pl );
                        //associate it with the exam
                        pl.exam = exam;
                        pl.kumi = k;
                        commit( mTypes.associateExamWithKumi, pl );
                    } );
                    resolve();
                } );
            } );
        },
    }
}