/**
 * This is the new version of students.
 *
 * More precisely it is a list of students for a
 * given exam or item.
 *
 * We may decide to keep the students store around
 * for things which require access to students outside
 * of an exam or item
 *
 * Created by adam on 7/8/17.
 */
import Vue from 'vue'
import Student from '../../../models/Student'
import Payload from '../../../models/Payload'

import Kumi from '../../../models/Kumi'

import * as mTypes from '../../mutation-types'
import * as aTypes from '../../action-types'
import * as gTypes from '../../getter-types';

import StudentImporter from './studentFileImporter';

import { createStudentRequest, associateStudentWithKumiRequest } from '../../../api/requests/studentRequests';




module.exports = {

    ...StudentImporter,

    /**
     * Takes a newly created (but not yet saved) student object or
     * creates a new student object from the payload,
     * saves it to the db, and stores it in
     * store.roster.
     * Does not handle any associations with kumis
     */
    createStudent: ( { state, dispatch, commit, getters }, newStudentObjectOrPayload ) => {
        return new Promise( function ( resolve, reject ) {

            let student = newStudentObjectOrPayload instanceof Student ? newStudentObjectOrPayload : Student.factory( newStudentObjectOrPayload );

            //Start by saving the student object to the db
            let p = createStudentRequest( student );
            //We will need to wait for this to resolve
            //because we will need the student's db id for
            //the next step
            p.then( function ( data ) {
                //update the id on our newly created student object
                student.id = data.id;
                let pl = Payload.factory( {
                    obj: student,
                    mutateSilently: true
                } );

                //quietly add the student to store
                commit( mTypes.addStudentToRoster, pl );

                //and we're done.
                //we return the student object so other actions
                //can use it
                resolve(student);
            } );
        } );
    },

    /**
     * One stop shop for everything which happens when a brand-new student
     * object is created.
     * This assumes that the student object was created from input data
     * elsewhere without being stored yet.
     *
     * @param state
     * @param dispatch
     * @param commit
     * @param getters
     * @param payload
     */
    [ aTypes.handleNewStudentStorageAndAssociation ]: ( { state, dispatch, commit, getters }, newStudentObject ) => {
        return new Promise( function ( resolve, reject ) {
            //Create a new student
            //and save them to the db.
            //We will need to wait for this to resolve
            //because we will need the student's db id for
            //the next step
            let p = dispatch('createStudent', newStudentObject);

            //Start by building a list of kumis that the student
            //will need to be associated with
            let kumis = [];
            //all students need to be associated with the kumi
            //connecting to the exam
            kumis.push( getters.getRootKumi );
            //get the kumis that are currently displayed and
            //selected
            kumis = kumis.concat( getters.getDisplayedKumis );
            kumis = kumis.concat( getters.getSelectedKumis );

            //once the promise has resolved, we have the student, with id,
            //stored in our roster. We can now associate them with the kumis
            p.then( function (student) {
                _.forEach( kumis, function ( k ) {
                    //Create an association between the newly created
                    //student and the currently selected kumi, both
                    //locally and on server
                    let p2 = associateStudentWithKumiRequest(student, k);
                    p2.then(function ( ) {

                        let pl = Payload.factory( {
                            student: student,
                            kumi: k,
                            mutateSilently: true
                        } );

                        commit( mTypes.associateStudentWithKumi, pl );

                    });

                } );
                //we're done, so resolve the
                //outer promise
                resolve();
            } );
        } );
    },


};